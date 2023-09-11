import { Input, InputProps } from "../ui/input";
import { Icons } from "../icons";

interface LinkReplaceProps extends InputProps {
    link: string;
}

export function LinkReplace({ link, ...props }: LinkReplaceProps) {
    const openInNewTab = (url: string) => {
        window.open(url, "_blank", "noreferrer");
    };
    return (
        <div className="grid grid-rows-2 grid-cols-[min-content_1fr] md:grid-rows-1 md:grid-cols-[1fr_min-content_1fr]">
            <Input
                className="row-span-1 col-span-1 col-start-2 md:col-start-1 border-b-none rounded-b-none rounded-tl-none md:rounded-l md:rounded-r-none md:border-r-none"
                value={link}
                disabled
            />

            <button
                type="button"
                onClick={() => openInNewTab(link)}
                className=" w-10 group flex items-center justify-center row-span-2 col-span-1 md:row-span-1 col-start-1 row-start-1 md:col-start-2 border-l border-y rounded-l md:border-y md:rounded-none"
            >
                <Icons.arrowRightLeft className="h-5 w-5 group-hover:hidden" />
                <Icons.external className="h-5 w-5 group-hover:block hidden" />
            </button>
            <Input
                {...props}
                className="row-span-1 col-span-1 col-start-2 md:col-start-3  border-b-none rounded-t-none rounded-bl-none  md:rounded-r md:rounded-l-none md:border-l-none"
            />
        </div>
    );
}
