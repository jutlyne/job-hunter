<?php

namespace App\Observers;

use App\Models\Sos;
use App\Notifications\SosNotification;
use Illuminate\Support\Facades\Notification;

class SosObserver
{
    /**
     * Handle the Sos "created" event.
     *
     * @param  \App\Models\Sos  $sos
     * @return void
     */
    public function created(Sos $sos)
    {
        $devices = $sos->sosGarage->garage->staff->devices;
        Notification::send($devices, new SosNotification($sos));
    }

    /**
     * Handle the Sos "updated" event.
     *
     * @param  \App\Models\Sos  $sos
     * @return void
     */
    public function updated(Sos $sos)
    {
        //
    }

    /**
     * Handle the Sos "deleted" event.
     *
     * @param  \App\Models\Sos  $sos
     * @return void
     */
    public function deleted(Sos $sos)
    {
        //
    }

    /**
     * Handle the Sos "restored" event.
     *
     * @param  \App\Models\Sos  $sos
     * @return void
     */
    public function restored(Sos $sos)
    {
        //
    }

    /**
     * Handle the Sos "force deleted" event.
     *
     * @param  \App\Models\Sos  $sos
     * @return void
     */
    public function forceDeleted(Sos $sos)
    {
        //
    }
}
