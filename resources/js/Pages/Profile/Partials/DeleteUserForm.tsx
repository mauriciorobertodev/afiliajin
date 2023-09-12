import { useRef, useState, FormEventHandler } from "react";
import { useForm } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { FormField } from "@/components/form";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";

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

            <Dialog>
                <DialogTrigger>
                    <Button variant="destructive" onClick={confirmUserDeletion}>
                        Excluir conta
                    </Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Tem certeza de que deseja excluir sua conta?</DialogTitle>
                        <DialogDescription>
                            Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos
                            permanentemente. Por favor digite sua senha para confirmar que deseja excluir
                            permanentemente sua conta.
                        </DialogDescription>

                        <form onSubmit={deleteUser} className="space-y-4">
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
                    </DialogHeader>
                </DialogContent>
            </Dialog>
        </section>
    );
}
