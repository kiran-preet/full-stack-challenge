export interface Company {
    id: number;
    name: string;
    logo: string | null;
    website: string | null;
    email: string;
    created_at: string;
    updated_at: string;
    jobs_count?: number;
}

export interface Job {
    id: number;
    company_id: number;
    title: string;
    description: string;
    position_type: 'remote' | 'in-person' | 'hybrid';
    location: string | null;
    salary_min: number;
    salary_max: number;
    salary_currency: string;
    is_published: boolean;
    published_at: string | null;
    created_at: string;
    updated_at: string;
    company: Company;
}

export interface PaginatedJobs {
    data: Job[];
    links: {
        first: string | null;
        last: string | null;
        prev: string | null;
        next: string | null;
    };
    meta?: {
        current_page: number;
        from: number;
        last_page: number;
        links: {
            url: string | null;
            label: string;
            active: boolean;
        }[];
        path: string;
        per_page: number;
        to: number;
        total: number;
    };
}