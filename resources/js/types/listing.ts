export interface ListingImage {
    id: number;
    listing_id: number;
    filename: string;
    src: string;
    created_at: string;
    updated_at: string;
}
export interface Offer {
    id: number;
    amount: number;
    accepted_at?: string | null;
    created_at: string;
    bidder?: {
        id: number;
        name: string;
        email: string;
    };
}

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
    deleted_at: string | null;
    images?: ListingImage[];
    images_count?: number;
    offers_count?: number;
    accepted_offer_exists?: boolean;
}

export type ListingForm = Omit<
    Listing,
    | 'id'
    | 'created_at'
    | 'updated_at'
    | 'deleted_at'
    | 'images'
    | 'images_count'
>;

export interface ListingFilters {
    priceFrom: number | null;
    priceTo: number | null;
    beds: number | null;
    baths: number | null;
    areaFrom: number | null;
    areaTo: number | null;
}

export type SortBy = 'created_at' | 'price';
export type SortOrder = 'asc' | 'desc';

export interface SortOption {
    label: string;
    value: SortOrder;
}

export interface RealtorFilters {
    deleted: boolean;
    by: SortBy;
    order: SortOrder;
}
