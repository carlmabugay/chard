import { DataTableProps } from '@/components/shared/datatable/props.type'

export type PageProps = DataTableProps & CashFlowProps

export type CashFlowProps = {
    items: CashFlow[]
}

type CashFlow = {
    id: number,
    type: string,
    amount: string
    created_at: string
}
