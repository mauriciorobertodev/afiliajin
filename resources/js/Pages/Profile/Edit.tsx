import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import DeleteUserForm from "./Partials/DeleteUserForm";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm";
import { PageProps } from "@/types";
import { Header } from "@/components/header";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

export default function Edit({
    auth,
    mustVerifyEmail,
    status,
    flash,
}: PageProps<{ mustVerifyEmail: boolean; status?: string }>) {
    return (
        <AuthenticatedLayout user={auth.user} notification={flash.notification}>
            <div className="grid grid-rows-[min-content_1fr] h-full">
                <Header heading="Perfil" text="Gerencie as configurações da conta." />

                <Tabs defaultValue="info" className="h-full  grid grid-rows-[min-content_1fr]">
                    <TabsList className="grid w-full grid-cols-3">
                        <TabsTrigger value="info">Informações</TabsTrigger>
                        <TabsTrigger value="password">Senha</TabsTrigger>
                        <TabsTrigger value="account">Conta</TabsTrigger>
                    </TabsList>
                    <TabsContent value="info" className="py-6">
                        <UpdateProfileInformationForm mustVerifyEmail={mustVerifyEmail} status={status} />
                    </TabsContent>
                    <TabsContent value="password">
                        <UpdatePasswordForm />
                    </TabsContent>
                    <TabsContent value="account">
                        <DeleteUserForm />
                    </TabsContent>
                </Tabs>
            </div>
        </AuthenticatedLayout>
    );
}
