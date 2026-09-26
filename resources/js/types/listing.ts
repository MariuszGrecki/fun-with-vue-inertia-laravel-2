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

export interface ListingFilters {
    priceFrom: number | null;
    priceTo: number | null;
    beds: number | null;
    baths: number | null;
    areaFrom: number | null;
    areaTo: number | null;
}
