import { useEffect, FormEventHandler } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, useForm } from "@inertiajs/react";
import { FormField } from "@/components/form";
import { Button } from "@/components/ui/button";

export default function ResetPassword({ token, email }: { token: string; email: string }) {
    const { data, setData, post, processing, errors, reset, clearErrors } = useForm({
        token: token,
        email: email,
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

        post(route("password.store"));
    };

    return (
        <GuestLayout>
            <Head title="Reset Password" />

            <form onSubmit={submit}>
                <FormField
                    name="email"
                    label="Email"
                    error={errors.email}
                    value={data.email}
                    onChange={(e) => setData("email", e.target.value)}
                    onFocus={(e) => clearErrors("email")}
                    disabled={processing}
                    autoComplete="username"
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
                    label="Senha"
                    error={errors.password_confirmation}
                    value={data.password_confirmation}
                    onChange={(e) => setData("password_confirmation", e.target.value)}
                    onFocus={(e) => clearErrors("password_confirmation")}
                    disabled={processing}
                    autoComplete="new-password"
                    type="password"
                    required
                />

                <div className="flex items-center justify-end mt-4">
                    <Button className="w-full" disabled={processing}>
                        Resetar senha
                    </Button>
                </div>
            </form>
        </GuestLayout>
    );
}
