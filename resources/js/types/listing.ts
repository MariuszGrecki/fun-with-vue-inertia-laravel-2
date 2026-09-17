export interface Listing {
    id: number;
    beds: number;
    baths: number;
    area: number;
    city: string;
    code: string;
    street: string;
    street_nr: string;
    price: number;
    created_at: string;
    updated_at: string;
}

export type ListingForm = Omit<Listing, 'id' | 'created_at' | 'updated_at'>;
