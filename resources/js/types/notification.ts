export interface AppNotification {
    id: string;
    read_at: string | null;
    created_at: string;
    data: {
        listing_id: number;
        offer_id: number;
        amount: number;
        bidder_name: string;
    };
}
