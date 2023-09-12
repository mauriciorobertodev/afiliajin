import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import { Header } from "@/components/header";

export default function Dashboard({ auth, flash }: PageProps) {
    return (
        <AuthenticatedLayout user={auth.user} notification={flash.notification}>
            <Header heading="Dashboard" />

            <div className="py-8">
                <div className=" text-gray-900">Você está logado!</div>
            </div>
        </AuthenticatedLayout>
    );
}
