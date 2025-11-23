import { InertiaLinkProps } from '@inertiajs/vue3'
import type { LucideIcon } from 'lucide-vue-next'

export interface Auth {
    isOidcEnabled: boolean;
    user: App.Data.UserResource;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
    isDisabled?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
}

export type BreadcrumbItemType = BreadcrumbItem

export type PaginatedResource<T> = {
    data: T[];
    current_page: number;
    from: number;
    last_page: number;
    per_page: number;
    to: number;
    total: number;
}

export type PaginationParams = {
    per_page?: number
    page?: number
    // query?: string
}
