export type PageProps = {
    result: {
        data: Strategy[];
    } & PaginationLabelProps & PaginationNumberProps
}

export type StrategiesProps = {
    items: Strategy[]
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

type Strategy = {
    id: number,
    name: string,
    created_at: string
}
