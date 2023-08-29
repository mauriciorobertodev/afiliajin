import { Head } from "@inertiajs/react";

interface DashboardHeaderProps {
    heading: string;
    text?: string;
    children?: React.ReactNode;
}

export function Header({ heading, text, children }: DashboardHeaderProps) {
    return (
        <div className="flex items-center justify-between mb-8">
            <Head title={heading} />
            <div className="grid gap-1">
                <h1 className="font-heading text-2xl md:text-4xl font-bold">{heading}</h1>
                {text && <p className="text-base md:text-lg text-muted-foreground">{text}</p>}
            </div>
            {children}
        </div>
    );
}
