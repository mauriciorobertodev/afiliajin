import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Page, PageProps } from "@/types";
import { Header } from "@/components/header";
import { Button } from "@/components/ui/button";
import { Icons } from "@/components/icons";
import { Link } from "@inertiajs/react";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { PageInfoUpdate } from "@/components/page/page-info-update";
import { useState } from "react";
import { cn } from "@/lib/utils";
import { PageTextUpdate } from "@/components/page/page-text-update";
import { PageLinksUpdate } from "@/components/page/page-links-update";

interface Props extends PageProps {
    page: Page;
    links: {
        images: string[];
        videos: string[];
        checkouts: string[];
        links: string[];
    };
}

export default function Index({ auth, flash, page, links }: Props) {
    return (
        <AuthenticatedLayout user={auth.user} notification={flash.notification}>
            <div className="grid grid-rows-[min-content_1fr] h-full">
                <Header heading="Editar página" text="Preencha todos os campos e clique em salvar.">
                    <Link href={route("page.index")}>
                        <Button variant="outline" className="mb-4">
                            <Icons.chevronLeft className="mr-2 h-4 w-4" />
                            Voltar
                        </Button>
                    </Link>
                </Header>

                <Tabs defaultValue="data" className="h-full  grid grid-rows-[min-content_1fr]">
                    <TabsList className="grid w-full grid-cols-3">
                        <TabsTrigger value="data">Dados</TabsTrigger>
                        <TabsTrigger value="links">Links</TabsTrigger>
                        <TabsTrigger value="text">Texto</TabsTrigger>
                    </TabsList>
                    <TabsContent value="data" className="py-6">
                        <PageInfoUpdate page={page} />
                    </TabsContent>
                    <TabsContent value="links">
                        <PageLinksUpdate page={page} links={links} />
                    </TabsContent>
                    <TabsContent value="text">
                        <PageTextUpdate page={page} />
                    </TabsContent>
                </Tabs>
            </div>
        </AuthenticatedLayout>
    );
}
