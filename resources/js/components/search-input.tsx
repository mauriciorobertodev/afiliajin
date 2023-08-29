import { Icons } from "./icons";
import { Input, InputProps } from "./ui/input";

export function SearchInput(props: InputProps) {
    return (
        <div className="relative">
            <Icons.search className="w-5 h-5 absolute top-2.5 left-2 text-slate-500" />
            <Input id="search" name="search" className="pl-8" {...props} />
        </div>
    );
}
