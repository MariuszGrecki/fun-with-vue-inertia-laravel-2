<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferMade extends Notification implements ShouldQueueAfterCommit
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public readonly Offer $offer,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New offer on your listing')
            ->line($this->offer->bidder->name.' made an offer of '.$this->offer->amount.' zł.')
            ->action('View offer', route('realtor.listing.offer.index', $this->offer->listing_id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'listing_id' => $this->offer->listing_id,
            'offer_id' => $this->offer->id,
            'amount' => $this->offer->amount,
            'bidder_name' => $this->offer->bidder->name,
        ];
    }
}
