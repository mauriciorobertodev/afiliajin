export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type ToastType = "info" | "success" | "warning" | "error";

export interface InertiaNotification {
    text: string;
    type: ToastType;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    flash: {
        notification?: InertiaNotification;
    };
};
