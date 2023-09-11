import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import { Header } from "@/components/header";
import { Button } from "@/components/ui/button";
import { Icons } from "@/components/icons";
import { Link, useForm } from "@inertiajs/react";
import { Form, FormField } from "@/components/form";
import slugify from "slugify";

export default function Index({ auth, flash }: PageProps) {
    const { data, setData, post, processing, errors, clearErrors } = useForm({
        cloned_from: "",
        name: "",
        slug: "",
    });

    return (
        <AuthenticatedLayout user={auth.user} notification={flash.notification}>
            <Header heading="Nova página" text="Preencha todos os campos e clique em salvar.">
                <Link href={route("page.index")}>
                    <Button variant="outline" className="mb-4">
                        <Icons.chevronLeft className="mr-2 h-4 w-4" />
                        Voltar
                    </Button>
                </Link>
            </Header>

            <Form onSubmit={() => post(route("page.store"))}>
                <FormField
                    name="cloned_from"
                    label="Página  para clonar"
                    placeholder="ex.: https://curso-de-carpintaria-do-zero-ao-profissional"
                    description="link da página a ser clonada"
                    error={errors.cloned_from}
                    value={data.cloned_from}
                    onChange={(e) => setData("cloned_from", e.target.value)}
                    onFocus={(e) => clearErrors("cloned_from")}
                    disabled={processing}
                />
                <div className="grid md:grid-cols-2 gap-4">
                    <FormField
                        name="name"
                        label="Nome do produto"
                        placeholder="ex.: Curso de carpintaria"
                        description="Nome do produto para identificação"
                        error={errors.name}
                        value={data.name}
                        onChange={(e) => {
                            setData((data) => ({ ...data, name: e.target.value, slug: slugify(e.target.value) }));
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
                <Button>
                    {processing ? (
                        <Icons.spinner className="mr-2 h-4 w-4 animate-spin" />
                    ) : (
                        <Icons.check className="mr-2 h-4 w-4" />
                    )}
                    Salvar
                </Button>
            </Form>
        </AuthenticatedLayout>
    );
}
