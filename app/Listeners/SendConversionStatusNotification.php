<?php

namespace App\Listeners;

use App\Events\ConversionStatusUpdated;
use App\Notifications\ConversionStatusUpdated as ConversionStatusUpdatedNotification;

class SendConversionStatusNotification
{
    /**
     * Handle the event.
     *
     * @param \App\Events\ConversionStatusUpdated $event
     *
     * @return void
     */
    public function handle(ConversionStatusUpdated $event): void
    {
        $event->user()->notify(
            new ConversionStatusUpdatedNotification($event->conversion())
        );
    }
}
