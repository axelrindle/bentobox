export type Item = {
    // columns
    id: unknown
    created_at: string | null
    updated_at: string | null
    name: string
    is_consumable: boolean
    is_lendable: boolean
    amount: number
    tags: Array<unknown>
    warehouse_id: unknown
    parent_id: unknown
    // relations
    warehouse?: Warehouse
    parent?: Item
    children?: Items
}
export type Items = Item[]
export type ItemResults = api.MetApiResults & { data: Items }
export type ItemResult = api.MetApiResults & { data: Item }
export type ItemMetApiData = api.MetApiData & { data: Item }
export type ItemResponse = api.MetApiResponse & { data: ItemMetApiData }

export type Place = {
    // columns
    id: unknown
    created_at: string | null
    updated_at: string | null
    name: string
    description: string | null
    latitude: number | null
    longitude: number | null
    // relations
    warehouses?: Warehouses
}
export type Places = Place[]
export type PlaceResults = api.MetApiResults & { data: Places }
export type PlaceResult = api.MetApiResults & { data: Place }
export type PlaceMetApiData = api.MetApiData & { data: Place }
export type PlaceResponse = api.MetApiResponse & { data: PlaceMetApiData }

export type User = {
    // columns
    id: number
    name: string
    email: string
    email_verified_at: string | null
    created_at: string | null
    updated_at: string | null
    two_factor_confirmed_at: string | null
    // relations
    notifications?: DatabaseNotifications
}
export type Users = User[]
export type UserResults = api.MetApiResults & { data: Users }
export type UserResult = api.MetApiResults & { data: User }
export type UserMetApiData = api.MetApiData & { data: User }
export type UserResponse = api.MetApiResponse & { data: UserMetApiData }

export type Warehouse = {
    // columns
    id: unknown
    created_at: string | null
    updated_at: string | null
    name: string
    description: string | null
    latitude: number | null
    longitude: number | null
    place_id: unknown
    // relations
    place?: Place
}
export type Warehouses = Warehouse[]
export type WarehouseResults = api.MetApiResults & { data: Warehouses }
export type WarehouseResult = api.MetApiResults & { data: Warehouse }
export type WarehouseMetApiData = api.MetApiData & { data: Warehouse }
export type WarehouseResponse = api.MetApiResponse & { data: WarehouseMetApiData }
