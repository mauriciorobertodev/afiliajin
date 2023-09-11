import ApplicationLogo from "@/Components/ApplicationLogo";
import { ChevronFirst, LogOut } from "lucide-react";
import { Button } from "@/components/ui/button";
import { ReactNode, useState } from "react";
import { User } from "@/types";
import { cn } from "@/lib/utils";
import { Icons } from "./icons";

import { Link } from "@inertiajs/react";

interface SidebarItem {
    routeName: string;
    title: string;
    icon: string;
}

interface SidebarProps {
    user: User;
    items: SidebarItem[];
}

export default function Sidebar({ user, items }: SidebarProps) {
    const localExpanded = localStorage.getItem("menuExpanded") ?? true;

    const [expanded, setExpanded] = useState(localExpanded === "true" ? true : false);

    function toggleMenu() {
        localStorage.setItem("menuExpanded", expanded ? "false" : "true");
        setExpanded((current) => !current);
    }

    return (
        <aside className="md:h-screen group z-50" data-expanded={expanded}>
            <nav className="h-full flex flex-col md:border-r bg-white w-full md:w-64 md:overflow-hidden md:group-data-[expanded=false]:w-16 transition-all duration-300 transform ">
                <div className="px-3  flex justify-between h-16 md:h-min md:py-6 items-center">
                    <ApplicationLogo
                        className={cn(
                            "fill-current h-10 transition-all overflow-hidden duration-300 transform",
                            expanded ? "w-10" : "md:w-0"
                        )}
                    />
                    <Button variant="outline" size="icon" onClick={() => toggleMenu()} className="h-10 w-10">
                        <ChevronFirst
                            className={cn(
                                "transition-all duration-300 transform w-6 h-6 block",
                                expanded ? "" : "rotate-180"
                            )}
                        />
                    </Button>
                </div>
                <div className="md:flex-1 flex flex-col justify-between fixed md:static h-screen md:h-full  w-full top-0  pt-16 md:pt-0 -z-10 md:z-10 left-0 bg-white transition-all overflow-hidden duration-300 transform group-data-[expanded=false]:-left-full">
                    <ul className=" px-3 py-4 space-y-1 bg-white">
                        {items.map((item, index) => {
                            const Icon = Icons[item.icon || "arrowRight"];
                            return (
                                <li key={index}>
                                    <Link
                                        href={route(item.routeName)}
                                        className={cn(
                                            "group flex items-center relative rounded-md text-sm font-medium hover:bg-accent hover:text-accent-foreground h-10",
                                            route().current() === item.routeName ? "bg-accent" : "transparent",
                                            expanded ? "md:!p-0" : ""
                                        )}
                                    >
                                        <Icon className="w-6 h-6 absolute left-2" />
                                        <span className="transition-all overflow-hidden duration-100 w-32 ml-10 transform md:group-data-[expanded=false]:w-0 md:group-data-[expanded=false]:ml-0">
                                            {item.title}
                                        </span>
                                    </Link>
                                </li>
                            );
                        })}
                    </ul>
                    <div className="flex p-3 items-center">
                        <div className="flex flex-col items-start justify-center flex-1 transition-all overflow-hidden duration-300 transform w-44 md:group-data-[expanded=false]:w-0">
                            <p className="font-medium truncate ">{user.name}</p>
                            <p className="text-sm text-muted-foreground truncate">{user.email}</p>
                        </div>
                        <Button variant="ghost" size="icon">
                            <LogOut />
                        </Button>
                    </div>
                </div>
            </nav>
        </aside>
    );
}
