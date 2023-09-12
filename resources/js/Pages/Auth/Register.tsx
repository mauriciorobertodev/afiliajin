import { useEffect, FormEventHandler } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { FormField } from "@/components/form";
import { Button } from "@/components/ui/button";

export default function Register() {
    const { data, setData, post, processing, errors, reset, clearErrors } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    useEffect(() => {
        return () => {
            reset("password", "password_confirmation");
        };
    }, []);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route("register"));
    };

    return (
        <GuestLayout>
            <Head title="Registro" />

            <form onSubmit={submit}>
                <FormField
                    name="name"
                    label="Nome"
                    error={errors.name}
                    value={data.name}
                    onChange={(e) => setData("name", e.target.value)}
                    onFocus={(e) => clearErrors("name")}
                    disabled={processing}
                    autoComplete="name"
                    autoFocus
                    required
                />
                <FormField
                    name="email"
                    label="Email"
                    error={errors.email}
                    value={data.email}
                    onChange={(e) => setData("email", e.target.value)}
                    onFocus={(e) => clearErrors("email")}
                    disabled={processing}
                    autoComplete="email"
                    type="email"
                    required
                />
                <FormField
                    name="password"
                    label="Senha"
                    error={errors.password}
                    value={data.password}
                    onChange={(e) => setData("password", e.target.value)}
                    onFocus={(e) => clearErrors("password")}
                    disabled={processing}
                    autoComplete="new-password"
                    type="password"
                    required
                />
                <FormField
                    name="password_confirmation"
                    label="Confirme a senha"
                    error={errors.password_confirmation}
                    value={data.password_confirmation}
                    onChange={(e) => setData("password_confirmation", e.target.value)}
                    onFocus={(e) => clearErrors("password_confirmation")}
                    disabled={processing}
                    autoComplete="new-password"
                    type="password"
                    required
                />

                <div className="flex flex-col gap-4">
                    <Button disabled={processing}>Registrar</Button>
                    <Link
                        href={route("login")}
                        className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Já é registrado ?
                    </Link>
                </div>
            </form>
        </GuestLayout>
    );
}
