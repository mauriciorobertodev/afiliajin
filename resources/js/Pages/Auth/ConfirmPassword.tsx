import { useEffect, FormEventHandler } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, useForm } from "@inertiajs/react";
import { FormField } from "@/components/form";
import { Button } from "@/components/ui/button";

export default function ConfirmPassword() {
    const { data, setData, post, processing, errors, reset, clearErrors } = useForm({
        password: "",
    });

    useEffect(() => {
        return () => {
            reset("password");
        };
    }, []);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("password.confirm"));
    };

    return (
        <GuestLayout>
            <Head title="Confirm Password" />

            <div className="mb-4 text-sm text-gray-600">
                Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.
            </div>

            <form onSubmit={submit}>
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
                    autoFocus
                    required
                />

                <div className="flex items-center justify-end mt-4">
                    <Button className="w-full" disabled={processing}>
                        Confirm
                    </Button>
                </div>
            </form>
        </GuestLayout>
    );
}
