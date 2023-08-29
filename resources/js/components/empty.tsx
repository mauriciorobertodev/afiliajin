import { PropsWithChildren } from "react";
import { Icons } from "./icons";

interface EmptyProps extends PropsWithChildren {
    icon: keyof typeof Icons;
    title: string;
    description: string;
}

export function Empty({ children, icon, title, description }: EmptyProps) {
    const Icon = Icons[icon];

    if (!Icon) {
        return null;
    }

    return (
        <div className="flex min-h-[400px] flex-col items-center justify-center rounded-md border border-dashed p-8 text-center animate-in fade-in-50 w-full">
            <div className="mx-auto flex max-w-[420px] flex-col items-center justify-center text-center">
                <div className="flex h-20 w-20 items-center justify-center rounded-full bg-muted">
                    <Icon className="h-10 w-10" />
                </div>
                <h2 className="mt-6 text-xl font-semibold">{title}</h2>
                <p className="mb-8 mt-2 text-center text-sm font-normal leading-6 text-muted-foreground">
                    {description}
                </p>
                {children}
            </div>
        </div>
    );
}
