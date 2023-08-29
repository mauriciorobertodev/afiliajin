import { WithPagination } from "@/types";
import { Icons } from "./icons";
import { Button } from "./ui/button";
import { router } from "@inertiajs/react";

interface PaginationProps {
    current_page: number;
    links: { url: string | null; label: string; active: boolean }[];
    next_page_url: string | null;
    prev_page_url: string | null;
}

export function Pagination<T>({ current_page, links }: PaginationProps) {
    if (links.length <= 3) return;
    return (
        <div className="w-min rounded divide-x border flex">
            {links.map((link, index) => (
                <Button
                    key={index}
                    variant="ghost"
                    size="icon"
                    className="rounded-none disabled:cursor-not-allowed"
                    disabled={link.active ? true : false}
                    onClick={() => {
                        if (link.url) router.get(link.url);
                    }}
                >
                    {index === 0 && <Icons.chevronLeft className="h-4 w-4" />}
                    {index != 0 && index != links.length - 1 && link.label}
                    {index === links.length - 1 && <Icons.chevronRight className="h-4 w-4" />}
                </Button>
            ))}
        </div>
    );
}
