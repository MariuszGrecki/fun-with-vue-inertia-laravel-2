<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Inertia\Response;

class NotificationController extends Controller
{
    public function index(Request $request): Response
    {
        return inertia('Notifications/Index', [
            'notifications' => $request->user()->notifications()->paginate(15),
        ]);
    }

    public function read(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        abort_unless($notification->notifiable_id === $request->user()->id, 403);

        $notification->markAsRead();

        return redirect()->route('realtor.listing.offer.index', $notification->data['listing_id']);
    }
}
