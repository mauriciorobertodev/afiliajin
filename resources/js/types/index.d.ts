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

export interface WithPagination<T> {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: { url: string | null; label: string; active: boolean }[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
    data: T[];
}

export interface Page {
    cloned_from: string;
    created_at: string;
    id: number;
    name: string;
    slug: string;
    updated_at: string;
    user_id: number;
}
