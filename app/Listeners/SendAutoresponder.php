<?php

namespace App\Listeners;

use App\Events\DataWasReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAutoresponder
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\DataWasReceived  $event
     * @return void
     */
    public function handle(DataWasReceived $event)
    {
        $sensores = $event->data;
    }
}
