import { useRef, FormEventHandler } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { useForm } from "@inertiajs/react";
import { Transition } from "@headlessui/react";
import { FormField } from "@/components/form";
import { Button } from "@/components/ui/button";

export default function UpdatePasswordForm({ className = "" }: { className?: string }) {
    const passwordInput = useRef<HTMLInputElement>();
    const currentPasswordInput = useRef<HTMLInputElement>();

    const { data, setData, errors, put, reset, processing, recentlySuccessful, clearErrors } = useForm({
        current_password: "",
        password: "",
        password_confirmation: "",
    });

    const updatePassword: FormEventHandler = (e) => {
        e.preventDefault();

        put(route("password.update"), {
            preserveScroll: true,
            onSuccess: () => reset(),
            onError: (errors) => {},
        });
    };

    return (
        <section className={`mt-6 ${className}`}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Atualizar Senha</h2>
                <p className="mt-1 text-sm text-gray-600">
                    Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.
                </p>
            </header>

            <form onSubmit={updatePassword} className="mt-6">
                <FormField
                    name="current_password"
                    label="Senha atual"
                    error={errors.current_password}
                    value={data.current_password}
                    onChange={(e) => setData("current_password", e.target.value)}
                    onFocus={(e) => clearErrors("current_password")}
                    disabled={processing}
                    type="password"
                    autoComplete="current-password"
                    autoFocus
                    required
                />
                <FormField
                    name="password"
                    label="Nova senha"
                    error={errors.password}
                    value={data.password}
                    onChange={(e) => setData("password", e.target.value)}
                    onFocus={(e) => clearErrors("password")}
                    disabled={processing}
                    type="password"
                    autoComplete="new-password"
                    required
                />
                <FormField
                    name="password_confirmation"
                    label="Nova senha"
                    error={errors.password_confirmation}
                    value={data.password_confirmation}
                    onChange={(e) => setData("password_confirmation", e.target.value)}
                    onFocus={(e) => clearErrors("password_confirmation")}
                    disabled={processing}
                    type="password"
                    autoComplete="new-password"
                    required
                />

                <Button disabled={processing}>Salvar</Button>
            </form>
        </section>
    );
}
