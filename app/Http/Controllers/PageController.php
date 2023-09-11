<?php

namespace App\Http\Controllers;

use App\Actions\Clone;
use App\Actions\Clone\FormatPageContent;
use App\Actions\Update\UpdateBodyBottom;
use App\Actions\Update\UpdateBodyTop;
use App\Actions\Update\UpdateCookie;
use App\Actions\Update\UpdateHeadBottom;
use App\Actions\Update\UpdateHeadTop;
use App\Actions\Update\UpdateWhatsappButton;
use App\Actions\Util\GetLinks;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateLinksRequest;
use App\Http\Requests\PageUpdateRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;

final class PageController extends Controller
{
    public function index(Request $request)
    {
        $pages = Page::query()
            ->orderBy('created_at', 'desc')
            ->where('user_id', Auth::user()->id)
            ->when(
                $request->s,
                fn ($query, $s) => $query->where('name', 'LIKE', '%' . $s . '%')
            )
            ->paginate(20, [
                'id',
                'user_id',
                'created_at',
                'slug',
                'name',
            ]);

        return Inertia::render('Page/Index', ['pages' => $pages, 's' => $request->s]);
    }

    public function create()
    {
        return Inertia::render('Page/Create');

    }

    public function edit(string $id)
    {
        $page = Page::query()->where('user_id', Auth::user()->id)->findOrFail($id);

        $content = Storage::disk('pages')->get($page->file . '.html');

        if ( ! $content) {
            return back()->with('notification', ['type' => 'error', __('app.errors.deleted_content')]);
        }

        $links = GetLinks::run($content);

        return Inertia::render('Page/Edit', compact('page', 'links' ));
    }

    public function update(PageUpdateRequest $request, string $id)
    {
        $page = Page::query()->where('user_id', Auth::user()->id)->findOrFail($id);

        $request->merge(['whatsapp_number' => preg_replace('/[^0-9]*/', '', $request->whatsapp_number)]);

        $page->fill($request->all());

        $file = Storage::disk('pages')->get($page->file . '.html');

        $file = UpdateCookie::run($page, $file);
        $file = UpdateBodyTop::run($page, $file);
        $file = UpdateBodyBottom::run($page, $file);
        $file = UpdateHeadTop::run($page, $file);
        $file = UpdateHeadBottom::run($page, $file);
        $file = UpdateWhatsappButton::run($page, $file);

        Storage::disk('pages')->put($page->file . '.html', $file);

        $page->save();

        return back()->with('notification', ['type' => 'success', 'text' => __('app.success.page.updated')]);
    }

    // public function updateLinks(Request $request, string $id)
    public function updateLinks(PageUpdateLinksRequest $request, string $id)
    {
        $page = Page::query()->where('user_id', Auth::user()->id)->findOrFail($id);

        if ( ! empty($request->replace)) {
            $file = Storage::disk('pages')->get($page->file . '.html');
            $file = str_ireplace(array_keys($request->replace), array_values($request->replace), $file);
            Storage::disk('pages')->put($page->file . '.html', $file);
        }

        return back()->with('notification', ['type' => 'success', 'text' => __('app.success.page.updated')]);
    }

    public function updateBody(Request $request, string $id)
    {
        $page = Page::query()->where('user_id', Auth::user()->id)->findOrFail($id);

        if ( ! empty($request->body)) {
            $file = Storage::disk('pages')->get($page->file . '.html');
            $file = preg_replace('/(<\s*body[^>]*>(?:[\w|\W]*)<\/\s*body[^>]*>)/i', $request->body, $file);
            Storage::disk('pages')->put($page->file . '.html', $file);
        }

        return back()->with('notification', ['type' => 'success', 'text' => __('app.success.page.updated')]);
    }

    public function store(PageStoreRequest $request)
    {
        $host = trim(parse_url($request->cloned_from, PHP_URL_HOST), '/');
        $path = trim(parse_url($request->cloned_from, PHP_URL_PATH), '/');
        $request->merge(['cloned_from' => $host . '/' . ($path ? $path . '/' : '')]);

        $content = Clone\GetPageContent::run($request->cloned_from);

        if ( ! $content) {
            return redirect()->back()->withErrors(['cloned_from' => __('app.errors.clone_fail')]);
        }

        $content = FormatPageContent::run($request->cloned_from, $content);

        $uuid   = Uuid::uuid4();
        $stored = Clone\StorePageContent::run($uuid, $content);

        if ( ! $stored) {
            return redirect()->back()->with('notification', ['type' => 'error', 'text' => __('app.errors.clone_storage_fail')]);
        }

        $saved = Clone\SaveNewPage::run(['file' => $uuid, ...$request->all()]);

        if ( ! $saved) {
            return redirect()->back()->with('notification', ['type' => 'error', 'text' => __('app.errors.clone_requestbase_fail')]);
        }

        return to_route('page.index')->with('notification', ['type' => 'success', 'text' => __('app.success.page.cloned')]);
    }

    public function show(Request $request, string $slug)
    {
        if (env('APP_DEBUG')) {
            \Barryvdh\Debugbar\Facades\Debugbar::disable();
        }

        $page     = Page::query()->where('slug', $slug)->firstOrFail(['file']);
        $file     = Storage::disk('pages')->get($page->file . '.html');

        if ($file) {
            return $file;
        }

        abort(Response::HTTP_NOT_FOUND);

    }

    public function destroy(string $id)
    {
        $page    = Page::query()->where('user_id', Auth::user()->id)->find($id, ['user_id', 'id', 'file']);

        if ($page ) {
            $storage = Storage::disk('pages');
            $storage->delete($page->file . '.html');
            $page->delete();
        }

        return back()->with('notification', ['type' => 'success', 'text' => __('app.success.page.destroyed')]);
    }
}
