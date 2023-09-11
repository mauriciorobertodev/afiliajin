import { Button } from "@/components/ui/button";
import { Icons } from "@/components/icons";
import { cn } from "@/lib/utils";
import { Page } from "@/types";
import { useState } from "react";
import { useForm } from "@inertiajs/react";

interface PageTextUpdateProps {
    page: Page;
}

export function PageTextUpdate({ page }: PageTextUpdateProps) {
    const [expand, setExpand] = useState(false);

    const { data, setData, put, processing, errors, clearErrors } = useForm({
        body: "",
    });

    function toggleToEditable() {
        const doc = document.querySelector("iframe");
        if (doc && doc.contentDocument) doc.contentDocument.designMode = "on";
    }

    function save() {
        const doc = document.querySelector("iframe");
        if (doc?.contentDocument?.body) {
            data.body = doc.contentDocument.body.outerHTML.toString();
        }
        put(route("page.update.body", { id: page.id }));
    }

    return (
        <div className={cn("w-full h-full rounded relative", expand && "fixed h-screen w-screen top-0 left-0 z-[100]")}>
            <iframe
                onLoad={toggleToEditable}
                src={route("page.show", { slug: page.slug }).toString()}
                className="w-full h-full bg-white"
            ></iframe>
            <div className="absolute top-4 right-4 flex items-end gap-2">
                <Button disabled={processing} type="button" variant="outline" className="gap-2" onClick={(e) => save()}>
                    <Icons.check className="h-5 w-5" /> Salvar
                </Button>
                <Button type="button" variant="outline" className="h-10 w-10 p-0" onClick={(e) => setExpand(!expand)}>
                    {expand ? <Icons.minimize /> : <Icons.expand />}
                </Button>
            </div>
        </div>
    );
}
