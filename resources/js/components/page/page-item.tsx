import { Page } from "@/types";
import { PageItemActions } from "./page-item-actions";

interface PageItemProps {
    page: Pick<Page, "id" | "name" | "created_at" | "slug">;
}

export function PageItem({ page }: PageItemProps) {
    return (
        <div className="p-4 flex items-center justify-between">
            <div className="flex flex-col">
                <a target="__blank" href={route("page.show", { slug: page.slug })}>
                    <h4 className="font-semibold hover:underline">{page.name}</h4>
                </a>
                <p className="text-sm text-muted-foreground">{page.created_at}</p>
            </div>
            <PageItemActions page={page} />
        </div>
    );
}
