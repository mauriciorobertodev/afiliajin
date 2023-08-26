import { VariantProps, cva } from "class-variance-authority";
import { Icons } from "./icons";
import { InertiaNotification, ToastType } from "@/types";
import toast, { Toast as ToastHot } from "react-hot-toast";

const toastVariants = cva(
  "group pointer-events-auto relative flex items-center justify-between space-x-4 overflow-hidden rounded-md border p-6 pr-8 shadow-lg transition-all data-[swipe=cancel]:translate-x-0 data-[swipe=end]:translate-x-[var(--radix-toast-swipe-end-x)] data-[swipe=move]:translate-x-[var(--radix-toast-swipe-move-x)] data-[swipe=move]:transition-none data-[state=open]:animate-in data-[state=closed]:animate-out data-[swipe=end]:animate-out data-[state=closed]:fade-out-80 data-[state=closed]:slide-out-to-right-full data-[state=open]:slide-in-from-top-full data-[state=open]:sm:slide-in-from-bottom-full",
  {
    variants: {
      variant: {
        success: "border bg-background text-foreground border-l-4 border-l-green-600",
        error:
          "destructive group border-destructive bg-destructive text-destructive-foreground",
        warning:
          "border bg-background text-foreground  border-l-4 border-l-amber-500",
        info:
          "border bg-background text-foreground border-l-4 border-l-blue-600",
      },
    },
    defaultVariants: {
      variant: "info",
    },
  }
)

const iconVariants = cva(
  "h-6 w-6",
  {
    variants: {
      variant: {
        success: "text-green-600",
        error:"text-white",
        warning:"text-amber-500",
        info:"text-blue-600",
      },
    },
    defaultVariants: {
      variant: "info",
    },
  }
)

const iconMap : { [key in  ToastType]: string } =  {
    success: 'success',
    error: 'error',
    warning: 'warning',
    info: 'info',
};

const tittleMap : { [key in  ToastType]: string } =  {
    success: 'Sucesso!',
    error: 'Erro!',
    warning: 'Atenção!',
    info: 'Informação',
};

interface ToastProps{ notification:InertiaNotification, t: ToastHot}

export function Toast({ notification, t}: ToastProps) {
    const title = tittleMap[notification.type]
    const Icon =  Icons[ iconMap[notification.type] || "arrowRight"]

    return (
        <div className={toastVariants({ variant: notification.type })}>
            <div className="grid gap-1  w-full space-y-2">
                <div className="flex gap-2 w-full items-end">
                    <Icon className={iconVariants({variant: notification.type})} />
                    <div className="text-sm font-semibold">{title}</div>
                </div>
                <div className="text-sm opacity-90">{notification.text}</div>
            </div>
            <button onClick={() => toast.dismiss(t.id)} type="button" className="absolute right-2 top-2 rounded-md p-1 text-foreground/50 opacity-0 transition-opacity hover:text-foreground focus:opacity-100 focus:outline-none focus:ring-2 group-hover:opacity-100 group-[.destructive]:text-red-300 group-[.destructive]:hover:text-red-50 group-[.destructive]:focus:ring-red-400 group-[.destructive]:focus:ring-offset-red-600">
                <Icons.x className="h-4 w-4" />
            </button>
        </div>
    );
}
