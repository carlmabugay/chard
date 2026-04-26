import { DataTableProps } from '@/components/shared/datatable/props.type'

export type PageProps = DataTableProps & PortfolioProps

export type PortfolioProps = {
    items: Portfolio[]
}

type Portfolio = {
    id: number,
    name: string,
    created_at: string
    updated_at: string
}
