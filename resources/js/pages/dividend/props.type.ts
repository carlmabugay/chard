import { DataTableProps } from '@/components/shared/datatable/props.type'

export type PageProps = DataTableProps & DividendProps

export type DividendProps = {
    items: Dividend[]
}

type Dividend = {
    id: number,
    name: string,
    symbol: string,
    amount: string,
    recorded_at: string,
}
