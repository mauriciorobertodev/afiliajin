import Sidebar from "@/components/sidebar";
import { PropsWithChildren, useEffect } from "react";
import { Toast } from "@/components/toast";
import { InertiaNotification, User } from "@/types";
import toast, { Toaster } from "react-hot-toast";

export default function Authenticated({
    user,
    children,
    notification,
}: PropsWithChildren<{ user: User; notification?: InertiaNotification }>) {
    useEffect(() => {
        if (notification) toast.custom((t) => <Toast notification={notification} t={t} />);
    }, [notification]);

    return (
        <div className="h-screen w-screen fixed top-0 left-0">
            <div className="h-screen container grid grid-rows-[min-content_1fr] md:grid-cols-[min-content_1fr] overflow-hidden px-0 ">
                <Sidebar
                    user={user}
                    items={[
                        { icon: "dashboard", title: "Dashboard", routeName: "dashboard" },
                        { icon: "user", title: "Perfil", routeName: "profile.edit" },
                    ]}
                />
                <main className="py-6 px-4 md:px-8 min-h-screen overflow-y-auto">{children}</main>
            </div>
            <Toaster position="bottom-right" reverseOrder={false} />
        </div>
    );
}
