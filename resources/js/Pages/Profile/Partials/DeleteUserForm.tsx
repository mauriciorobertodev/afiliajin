import { useRef, useState, FormEventHandler } from "react";
import DangerButton from "@/Components/DangerButton";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import Modal from "@/Components/Modal";
import SecondaryButton from "@/Components/SecondaryButton";
import TextInput from "@/Components/TextInput";
import { useForm } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { FormField } from "@/components/form";

export default function DeleteUserForm({ className = "" }: { className?: string }) {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const passwordInput = useRef<HTMLInputElement>();

    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        errors,
        clearErrors,
    } = useForm({
        password: "",
    });

    const confirmUserDeletion = () => {
        setConfirmingUserDeletion(true);
    };

    const deleteUser: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route("profile.destroy"), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current?.focus(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);

        reset();
    };

    return (
        <section className={`space-y-6 mt-6 ${className}`}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Excluir conta</h2>
                <p className="mt-1 text-sm text-gray-600">
                    Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos permanentemente.
                    Antes excluir sua conta, baixe quaisquer dados ou informações que você deseja reter.
                </p>
            </header>

            <Button variant="destructive" onClick={confirmUserDeletion}>
                Excluir conta
            </Button>

            <Modal show={confirmingUserDeletion} onClose={closeModal}>
                <form onSubmit={deleteUser} className="p-6 space-y-4">
                    <div>
                        <h2 className="text-lg font-medium text-gray-900">
                            Tem certeza de que deseja excluir sua conta?
                        </h2>
                        <p className="mt-1 text-sm text-gray-600">
                            Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos
                            permanentemente. Por favor digite sua senha para confirmar que deseja excluir
                            permanentemente sua conta.
                        </p>
                    </div>

                    <FormField
                        name="password"
                        label="Senha"
                        error={errors.password}
                        value={data.password}
                        onChange={(e) => setData("password", e.target.value)}
                        onFocus={(e) => clearErrors("password")}
                        disabled={processing}
                        type="password"
                        autoComplete="new-password"
                        required
                    />

                    <div className="mt-6 flex justify-end">
                        <Button variant="outline" onClick={closeModal}>
                            Cancelar
                        </Button>

                        <Button variant={"destructive"} className="ml-3" disabled={processing}>
                            Excluir conta
                        </Button>
                    </div>
                </form>
            </Modal>
        </section>
    );
}
