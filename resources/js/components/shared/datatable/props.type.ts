export type DataTableProps = HeadersProps & PaginationProps

export type HeadersProps = {
    headers: HeaderProps[]
}

type HeaderProps = {
    label: string
    key: string
}

export type PaginationProps = {
    pagination: PaginationLabelProps & PaginationNumberProps
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
