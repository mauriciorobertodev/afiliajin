import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import { Header } from "@/components/header";

export default function Dashboard({ auth, flash }: PageProps) {
    return (
        <AuthenticatedLayout user={auth.user} notification={flash.notification}>
            <Header heading="Dashboard" text="Gerencie suas páginas e popups." />

            <div className="py-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
