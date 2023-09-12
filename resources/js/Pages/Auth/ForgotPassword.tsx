import GuestLayout from "@/Layouts/GuestLayout";
import { Head, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { Button } from "@/components/ui/button";
import { FormField } from "@/components/form";

export default function ForgotPassword({ status }: { status?: string }) {
    const { data, setData, post, processing, errors, clearErrors } = useForm({
        email: "",
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("password.email"));
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <div className="mb-4 text-sm text-gray-600">
                Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos uma senha por
                e-mail link de redefinição que permitirá que você escolha um novo.
            </div>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <form onSubmit={submit}>
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

                <div className="flex items-center justify-end mt-4">
                    <Button className="w-full" disabled={processing}>
                        Link de redefinição de senha de e-mail
                    </Button>
                </div>
            </form>
        </GuestLayout>
    );
}
