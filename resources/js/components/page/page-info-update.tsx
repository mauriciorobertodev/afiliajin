import { Button } from "@/components/ui/button";
import { Icons } from "@/components/icons";
import { useForm } from "@inertiajs/react";
import { Form, FormField, SwitchField, TextAreaField } from "@/components/form";
import slugify from "slugify";
import { Page } from "@/types";

interface PageInfoUpdateProps {
    page: Page;
}

export function PageInfoUpdate({ page }: PageInfoUpdateProps) {
    const { data, setData, put, processing, errors, clearErrors } = useForm({
        name: page.name,
        slug: page.slug,
        more_18: page.more_18,
        whatsapp_show: page.whatsapp_show,
        whatsapp_number: page.whatsapp_number || "",
        whatsapp_message: page.whatsapp_message || "",
        cookie: page.cookie || "",
        head_top: page.head_top || "",
        head_bottom: page.head_bottom || "",
        body_top: page.body_top || "",
        body_bottom: page.body_bottom || "",
    });

    return (
        <Form onSubmit={() => put(route("page.update", { id: page.id }))}>
            <h3 className="text-lg font-semibold">Informações</h3>
            <div className="grid md:grid-cols-2 gap-4">
                <FormField
                    name="name"
                    label="Nome do produto"
                    placeholder="ex.: Curso de carpintaria"
                    description="Nome do produto para identificação"
                    error={errors.name}
                    value={data.name}
                    onChange={(e) => {
                        setData((data) => ({
                            ...data,
                            name: e.target.value,
                            slug: slugify(e.target.value),
                        }));
                    }}
                    onFocus={(e) => clearErrors("name")}
                    disabled={processing}
                />
                <FormField
                    pattern="^[a-z0-9]+(?:-[a-z0-9]+)*$"
                    name="slug"
                    label="Slug"
                    placeholder="ex.: curso-de-carpintaria"
                    description="Caminho que será usado para acessar a página"
                    error={errors.slug}
                    value={data.slug}
                    onChange={(e) => setData("slug", slugify(e.target.value, { trim: false }))}
                    onFocus={(e) => clearErrors("slug")}
                    onBlur={(e) => setData("slug", slugify(e.target.value))}
                    disabled={processing}
                />
            </div>
            <FormField
                type="url"
                name="cookie"
                label="Cookie"
                placeholder="ex.: https:://go.hotmart.com/H6786786"
                description="Cria um iframe na página com o link do afiliado a pra marcar cookie"
                error={errors.cookie}
                value={data.cookie}
                onChange={(e) => setData("cookie", e.target.value)}
                onFocus={(e) => clearErrors("cookie")}
                disabled={processing}
            />
            <SwitchField
                name="more_18"
                label="Produto +18?"
                error={errors.more_18}
                checked={data.more_18}
                onCheckedChange={(e) => setData("more_18", e)}
                onFocus={(e) => clearErrors("more_18")}
                disabled={processing}
            />
            <hr />
            <h3 className="text-lg font-semibold">Botão de whatsapp</h3>
            <SwitchField
                name="whatsapp_show"
                label="Mostrar botão de whatsapp"
                error={errors.whatsapp_show}
                checked={data.whatsapp_show}
                onCheckedChange={(e) => setData("whatsapp_show", e)}
                onFocus={(e) => clearErrors("whatsapp_show")}
                disabled={processing}
            />
            <FormField
                pattern="^[0-9]*$"
                name="whatsapp_number"
                label="Número de whatsapp"
                placeholder="ex.: 5534223123454"
                description="Número que o usuário será direcionado"
                error={errors.whatsapp_number}
                value={data.whatsapp_number}
                onChange={(e) => setData("whatsapp_number", e.target.value)}
                onFocus={(e) => clearErrors("whatsapp_number")}
                disabled={processing}
            />
            <TextAreaField
                name="whatsapp_message"
                label="Mensagem"
                placeholder="ex.: Olá, gostaria de saber mais sobre o produto."
                description="Número que o usuário será direcionado"
                error={errors.whatsapp_message}
                value={data.whatsapp_message}
                onChange={(e) => setData("whatsapp_message", e.target.value)}
                onFocus={(e) => clearErrors("whatsapp_message")}
                disabled={processing}
            />
            <hr />
            <h3 className="text-lg font-semibold">Avançado</h3>
            <TextAreaField
                name="head_top"
                label="Começo da tag head"
                error={errors.head_top}
                value={data.head_top}
                onChange={(e) => setData("head_top", e.target.value)}
                onFocus={(e) => clearErrors("head_top")}
                disabled={processing}
            />
            <TextAreaField
                name="head_bottom"
                label="Final da tag head"
                error={errors.head_bottom}
                value={data.head_bottom}
                onChange={(e) => setData("head_bottom", e.target.value)}
                onFocus={(e) => clearErrors("head_bottom")}
                disabled={processing}
            />
            <TextAreaField
                name="body_top"
                label="Começo da tag body"
                error={errors.body_top}
                value={data.body_top}
                onChange={(e) => setData("body_top", e.target.value)}
                onFocus={(e) => clearErrors("body_top")}
                disabled={processing}
            />
            <TextAreaField
                name="body_bottom"
                label="Final da tag body"
                error={errors.body_bottom}
                value={data.body_bottom}
                onChange={(e) => setData("body_bottom", e.target.value)}
                onFocus={(e) => clearErrors("body_bottom")}
                disabled={processing}
            />
            <Button>
                {processing ? (
                    <Icons.spinner className="mr-2 h-4 w-4 animate-spin" />
                ) : (
                    <Icons.check className="mr-2 h-4 w-4" />
                )}
                Salvar
            </Button>
        </Form>
    );
}
