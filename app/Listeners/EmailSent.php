<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\OwnEmailSentModel;
use App\Models\ExcelEmail;

class EmailSent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($model_id = $event->sent_email->getHeader('X-Model-ID')) {
            OwnEmailSentModel::where('id', $event->sent_email->id)->update([
                'excel_email_id' => $model_id
            ]);

            ExcelEmail::where('id', $event->sent_email->id)->update([
                'status' => 'done'
            ]);
        }
    }
}
