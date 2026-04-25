export type PageProps = {
    result: {
        data: Portfolio[];
    } & PaginationLabelProps & PaginationNumberProps,
}

export type StrategiesProps = {
    items: Portfolio[]
}

export type PaginationLabelProps = {
    from: number;
    to: number;
    total: number;
}

export type PaginationNumberProps = {
    current_page: number;
    per_page: number;
}

type Portfolio = {
    id: number,
    name: string,
    created_at: string
    updated_at: string
}
