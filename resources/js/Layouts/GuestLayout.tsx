import ApplicationLogo from "@/components/application-logo";
import { Toast } from "@/components/toast";
import { InertiaNotification } from "@/types";
import { Link } from "@inertiajs/react";
import { PropsWithChildren, useEffect } from "react";
import toast, { Toaster } from "react-hot-toast";

export default function Guest({ children, notification }: PropsWithChildren<{ notification?: InertiaNotification }>) {
    useEffect(() => {
        if (notification) toast.custom((t) => <Toast notification={notification} t={t} />);
    }, [notification]);

    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white px-4">
            <div>
                <Link href="/">
                    <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                </Link>
            </div>

            <div className="w-full sm:max-w-md">{children}</div>

            <Toaster position="bottom-right" reverseOrder={false} />
        </div>
    );
}
