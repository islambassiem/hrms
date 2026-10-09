import type { PageProps } from '@inertiajs/core';

export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string | null;
    employee_code?: string | null;
    name_en?: string | null;
    name_ar?: string | null;
    permissions?: string[];
    email_verified_at: string | null;
    two_factor_enabled?: boolean;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};

export type Passkey = {
    id: number;
    name: string;
    authenticator: string | null;
    created_at_diff: string;
    last_used_at_diff: string | null;
};

export type TwoFactorSetupData = {
    svg: string;
    url: string;
};

export type TwoFactorSecretKey = {
    secretKey: string;
};

export interface Space {
    key: 'employee' | 'hr' | 'head';
    name: string;
    description: string;
    href: string;
}

export interface SharedData extends PageProps {
    locale: 'en' | 'ar';
    spaces: Space[];
    currentSpace: Space['key'];
}
