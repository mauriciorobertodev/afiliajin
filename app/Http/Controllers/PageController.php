<?php

namespace App\Http\Controllers;

use App\Actions\Clone;
use App\Http\Requests\PageStoreRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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

    public function store(PageStoreRequest $request)
    {
        $request->replace(['cloned_from' => parse_url($request->cloned_from, PHP_URL_HOST) . '/' . trim(parse_url($request->cloned_from, PHP_URL_PATH), '/') . '/']);

        $content = Clone\GetPageContent::run($request->cloned_from);

        if ( ! $content) {
            return redirect()->back()->withErrors(['cloned_from' => __('app.errors.clone_fail')]);
        }

        $stored = Clone\StorePageContent::run($request->slug, $content);

        if ( ! $stored) {
            return redirect()->back()->with('notification', ['type' => 'error', 'text' => __('app.errors.clone_storage_fail')]);
        }

        $saved = Clone\SaveNewPage::run($request->all());

        if ( ! $saved) {
            return redirect()->back()->with('notification', ['type' => 'error', 'text' => __('app.errors.clone_requestbase_fail')]);
        }

        return to_route('page.index')->with('notification', ['type' => 'success', 'text' => __('app.success.cloned')]);
    }

    public function show(string $slug)
    {
        if (view()->exists($slug)) {
            return view($slug, ['notification' => 'Olá, Mundo!']);
        }

        abort(Response::HTTP_NOT_FOUND);
    }

    public function destroy(string $id)
    {
        $page = Page::query()->find($id);

        if ( ! $page) {
            return back()->with('notification', ['type' => 'warning', 'text' => 'Essa página não existe']);
        }

        Storage::disk('pages')->delete($page->slug . '.blade.php');
        $page->delete();
    }
}
