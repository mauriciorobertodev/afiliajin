import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Page, PageProps, WithPagination } from "@/types";
import { Header } from "@/components/header";
import { Button } from "@/components/ui/button";
import { Icons } from "@/components/icons";
import { Link, router } from "@inertiajs/react";
import { PageItem } from "@/components/page/page-item";
import { Empty } from "@/components/empty";
import { Pagination } from "@/components/pagination";
import { Input } from "@/components/ui/input";
import { ChangeEvent, useEffect, useState } from "react";
import { SearchInput } from "@/components/search-input";

interface IndexProps extends PageProps {
    pages: WithPagination<Pick<Page, "id" | "user_id" | "created_at" | "slug" | "name">>;
    s?: string;
}

export default function Index({ auth, flash, pages, s }: IndexProps) {
    const [searchInput, setSearchInput] = useState(s || "");

    const handleSearchInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const value = event.target.value || "";
        setSearchInput(value);
        router.get(route("page.index", value ? { s: value } : {}), {}, { preserveState: true });
    };

    return (
        <AuthenticatedLayout user={auth.user} notification={flash.notification}>
            <Header heading="Páginas" text="Gerencie suas páginas.">
                <Link href={route("page.create")}>
                    <Button>
                        <Icons.add className="mr-2 h-4 w-4" />
                        Nova página
                    </Button>
                </Link>
            </Header>

            <div className="space-y-4">
                <SearchInput value={searchInput} onChange={handleSearchInputChange} placeholder="Buscar página..." />
                {pages.data.length > 0 ? (
                    <div className="rounded border divide-y ">
                        {pages.data.map((page, index) => {
                            return <PageItem page={page} key={index} />;
                        })}
                    </div>
                ) : (
                    <Empty
                        icon="page"
                        title="Sem páginas"
                        description="Sua busca não retornou nada ou você ainda não clonou nenhuma página."
                    />
                )}
                <Pagination {...pages} />
            </div>
        </AuthenticatedLayout>
    );
}
