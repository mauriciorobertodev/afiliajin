import { Link, useForm, usePage } from "@inertiajs/react";
import { Transition } from "@headlessui/react";
import { FormEventHandler } from "react";
import { PageProps } from "@/types";
import { FormField } from "@/components/form";
import { Button } from "@/components/ui/button";

export default function UpdateProfileInformation({
    mustVerifyEmail,
    status,
    className = "",
}: {
    mustVerifyEmail: boolean;
    status?: string;
    className?: string;
}) {
    const user = usePage<PageProps>().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful, clearErrors } = useForm({
        name: user.name,
        email: user.email,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        patch(route("profile.update"));
    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Informações</h2>
                <p className="mt-1 text-sm text-gray-600">Atualize as informações da sua conta e email</p>
            </header>

            <form onSubmit={submit} className="mt-6">
                <FormField
                    name="name"
                    label="Nome"
                    error={errors.name}
                    value={data.name}
                    onChange={(e) => setData("name", e.target.value)}
                    onFocus={(e) => clearErrors("name")}
                    disabled={processing}
                    autoFocus
                    required
                />

                <FormField
                    type="email"
                    name="email"
                    label="Email"
                    error={errors.email}
                    value={data.email}
                    onChange={(e) => setData("email", e.target.value)}
                    onFocus={(e) => clearErrors("email")}
                    disabled={processing}
                    autoFocus
                    required
                />

                {mustVerifyEmail && user.email_verified_at === null && (
                    <div>
                        <p className="text-sm mt-2 text-gray-800">
                            Seu endereço de e-mail não foi verificado.
                            <Link
                                href={route("verification.send")}
                                method="post"
                                as="button"
                                className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Clique aqui para reenviar o e-mail de verificação.
                            </Link>
                        </p>

                        {status === "verification-link-sent" && (
                            <div className="mt-2 font-medium text-sm text-green-600">
                                Um novo link de verificação foi enviado para seu endereço de e-mail.
                            </div>
                        )}
                    </div>
                )}

                <Button disabled={processing}>Salvar</Button>
            </form>
        </section>
    );
}
