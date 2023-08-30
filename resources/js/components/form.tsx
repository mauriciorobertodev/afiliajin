import { PropsWithChildren, ReactNode } from "react";
import { Label } from "./ui/label";
import { Input, InputProps } from "./ui/input";
import { cn } from "@/lib/utils";
import { Switch } from "./ui/switch";
import { SwitchProps } from "@radix-ui/react-switch";
import { Textarea, TextareaProps } from "./ui/textarea";

interface FormProps {
    children: ReactNode;
    onSubmit: (event: React.FormEvent<HTMLFormElement>) => void;
}

export function Form({ children, onSubmit }: FormProps) {
    function handleSubmit(event: React.FormEvent<HTMLFormElement>) {
        event.preventDefault();
        onSubmit(event);
    }

    return (
        <form onSubmit={handleSubmit} className="space-y-6">
            {children}
        </form>
    );
}

interface FormFieldProps extends InputProps {
    name: string;
    label?: string;
    description?: string;
    error: string | undefined;
}

export function FormField(props: FormFieldProps) {
    const { label, type, name, placeholder, description, error, value, onChange, onFocus } = props;
    return (
        <div className="space-y-2 min-h-[100px]">
            {label && <Label htmlFor={name}>{label}</Label>}
            <Input
                className={cn(error && "outline-none ring-2 ring-ring ring-offset-2 ring-red-500")}
                id={name}
                {...props}
            />
            {!error && description && <p className="text-sm text-muted-foreground h-5">{description}</p>}
            {error && <p className="text-sm text-muted-foreground h-5 text-red-500">{error}</p>}
        </div>
    );
}

interface SwitchFieldProps extends SwitchProps {
    name: string;
    label?: string;
    description?: string;
    error: string | undefined;
}

export function SwitchField(props: SwitchFieldProps) {
    const { label, name, description, error } = props;
    return (
        <div className="space-y-2 min-h flex flex-col">
            {label && <Label htmlFor={name}>{label}</Label>}
            <Switch
                className={cn(error && "outline-none ring-2 ring-ring ring-offset-2 ring-red-500")}
                id={name}
                {...props}
            />
            {!error && description && <p className="text-sm text-muted-foreground h-5">{description}</p>}
            {error && <p className="text-sm text-muted-foreground h-5 text-red-500">{error}</p>}
        </div>
    );
}

interface TextAreaFieldProps extends TextareaProps {
    name: string;
    label?: string;
    description?: string;
    error: string | undefined;
}

export function TextAreaField(props: TextAreaFieldProps) {
    const { label, name, description, error } = props;
    return (
        <div className="space-y-2 min-h-[100px]">
            {label && <Label htmlFor={name}>{label}</Label>}
            <Textarea
                className={cn(error && "outline-none ring-2 ring-ring ring-offset-2 ring-red-500")}
                id={name}
                {...props}
            />
            {!error && description && <p className="text-sm text-muted-foreground h-5">{description}</p>}
            {error && <p className="text-sm text-muted-foreground h-5 text-red-500">{error}</p>}
        </div>
    );
}
