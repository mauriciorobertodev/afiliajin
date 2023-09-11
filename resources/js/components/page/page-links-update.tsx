import { Page } from "@/types";
import { Input } from "../ui/input";
import { Button } from "../ui/button";
import { Icons } from "../icons";
import { LinkReplace } from "./link-replace";
import { useState } from "react";
import { Empty } from "../empty";
import { useForm } from "@inertiajs/react";

interface PageLinksUpdateProps {
    page: Page;
    links: {
        images: string[];
        videos: string[];
        checkouts: string[];
        links: string[];
    };
}

export function PageLinksUpdate({ page, links }: PageLinksUpdateProps) {
    const { data, setData, put, processing, errors } = useForm<{ replace: { [key: string]: string } }>({ replace: {} });

    const hasLinks =
        links.checkouts.length > 0 || links.images.length > 0 || links.videos.length > 0 || links.links.length > 0;

    function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
        e.preventDefault();

        Object.keys(data.replace).forEach((key) => {
            if (!data.replace[key].trim()) delete data.replace[key];
        });

        put(route("page.update.links", { id: page.id }));
    }

    return (
        <form onSubmit={handleSubmit} className="w-full h-full pt-4 pb-6 space-y-8">
            {errors && <p className="text-sm text-muted-foreground h-5">{errors.replace}</p>}
            {/* checkouts */}
            {links.checkouts.length > 0 && (
                <div>
                    <div className="flex gap-4 items-center">
                        <Icons.cart className="text-foreground/70" />
                        <h3 className="font-heading text-lg md:text-2xl font-bold">Checkouts</h3>
                    </div>
                    <div className="pt-4 space-y-2">
                        {links.checkouts.map((link, index) => {
                            return (
                                <LinkReplace
                                    link={link}
                                    key={index}
                                    value={data.replace[link] || ""}
                                    onChange={(e) => setData("replace", { ...data.replace, [link]: e.target.value })}
                                />
                            );
                        })}
                    </div>
                </div>
            )}
            {/* images */}
            {links.images.length > 0 && (
                <div>
                    <div className="flex gap-4 items-center">
                        <Icons.image className="text-foreground/70" />
                        <h3 className="font-heading text-lg md:text-2xl font-bold">Imagens</h3>
                    </div>
                    <div className="pt-4 space-y-2">
                        {links.images.map((link, index) => {
                            return (
                                <LinkReplace
                                    link={link}
                                    key={index}
                                    value={data.replace[link] || ""}
                                    onChange={(e) => setData("replace", { ...data.replace, [link]: e.target.value })}
                                />
                            );
                        })}
                    </div>
                </div>
            )}
            {/* videos */}
            {links.videos.length > 0 && (
                <div>
                    <div className="flex gap-4 items-center">
                        <Icons.play className="text-foreground/70" />
                        <h3 className="font-heading text-lg md:text-2xl font-bold">Videos</h3>
                    </div>
                    <div className="pt-4 space-y-2">
                        {links.videos.map((link, index) => {
                            return (
                                <LinkReplace
                                    link={link}
                                    key={index}
                                    value={data.replace[link] || ""}
                                    onChange={(e) => setData("replace", { ...data.replace, [link]: e.target.value })}
                                />
                            );
                        })}
                    </div>
                </div>
            )}

            {/* links */}
            {links.links.length > 0 && (
                <div>
                    <div className="flex gap-4 items-center">
                        <Icons.link className="text-foreground/70" />
                        <h3 className="font-heading text-lg md:text-2xl font-bold">Links</h3>
                    </div>
                    <div className="pt-4 space-y-2">
                        {links.links.map((link, index) => {
                            return (
                                <LinkReplace
                                    link={link}
                                    key={index}
                                    value={data.replace[link] || ""}
                                    onChange={(e) => setData("replace", { ...data.replace, [link]: e.target.value })}
                                />
                            );
                        })}
                    </div>
                </div>
            )}
            {hasLinks && (
                <Button>
                    {processing ? (
                        <Icons.spinner className="mr-2 h-4 w-4 animate-spin" />
                    ) : (
                        <Icons.check className="mr-2 h-4 w-4" />
                    )}
                    Salvar
                </Button>
            )}
            {!hasLinks && (
                <Empty
                    icon="link"
                    title="Sem links"
                    description="Não conseguimos detectar os links contidos na página."
                />
            )}
        </form>
    );
}
