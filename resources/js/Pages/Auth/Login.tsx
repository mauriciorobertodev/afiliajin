import { useEffect, FormEventHandler } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { FormField } from "@/components/form";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";

export default function Login({ status, canResetPassword }: { status?: string; canResetPassword: boolean }) {
    const { data, setData, post, processing, errors, reset, clearErrors } = useForm({
        email: "",
        password: "",
        remember: false,
    });

    useEffect(() => {
        return () => {
            reset("password");
        };
    }, []);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("login"));
    };

    return (
        <GuestLayout>
            <Head title="Entrar" />

            <form onSubmit={submit}>
                <FormField
                    name="email"
                    label="Email"
                    error={errors.email}
                    value={data.email}
                    onChange={(e) => setData("email", e.target.value)}
                    onFocus={(e) => clearErrors("email")}
                    disabled={processing}
                    type="email"
                    autoComplete="username"
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
                    type="password"
                    autoComplete="current-password"
                    required
                />

                <div className="block mt-4">
                    <label className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onCheckedChange={(e) => setData("remember", e.toString().toLowerCase() === "true")}
                        />
                        <span className="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div className="flex flex-col gap-2 mt-4">
                    <Button className=" w-full " disabled={processing}>
                        Entrar
                    </Button>
                    {canResetPassword && (
                        <Link
                            href={route("password.request")}
                            className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Esqueceu a senha?
                        </Link>
                    )}
                </div>
            </form>
        </GuestLayout>
    );
}
