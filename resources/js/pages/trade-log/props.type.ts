import { DataTableProps } from '@/components/shared/datatable/props.type'

export type PageProps = DataTableProps & TradeLogProps

export type TradeLogProps = {
    items: TradeLog[]
}

type TradeLog = {
    id: number,
    name: string,
    type: string,
    symbol: string,
    price: string,
    shares: string,
    fees: string,
    recorded_at: string,
}
