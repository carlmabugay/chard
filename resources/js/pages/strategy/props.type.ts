import { DataTableProps } from '@/components/shared/datatable/props.type'

export type PageProps = DataTableProps & StrategiesProps

export type StrategiesProps = {
    items: Strategy[]
}

type Strategy = {
    id: number,
    name: string,
    created_at: string
}
