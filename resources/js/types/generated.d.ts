declare namespace App.Data {
    export type ItemResource = {
        id: string;
        createdAt: string;
        updatedAt: string;
        name: string;
        isConsumable: boolean;
        isLendable: boolean;
        amount: number;
        tags: Array<string>;
        warehouse?: App.Data.WarehouseResource;
        parent?: App.Data.ItemResource;
    }
    export type PlaceResource = {
        id: string;
        createdAt: string;
        updatedAt: string;
        name: string;
        description?: string;
        latitude?: number;
        longitude?: number;
    }
    export type UserResource = {
        id: number;
        createdAt: string;
        updatedAt: string;
        name: string;
        email?: string;
        emailVerifiedAt?: string;
        provider?: string;
        isExternal: boolean;
    }
    export type WarehouseResource = {
        id: string;
        createdAt: string;
        updatedAt: string;
        name: string;
        description?: string;
        latitude?: number;
        longitude?: number;
        place?: App.Data.PlaceResource;
    }
}
