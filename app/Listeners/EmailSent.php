<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\OwnEmailSentModel;
use App\Models\ExcelEmail;

class EmailSent implements ShouldQueue
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

            $excel_email = ExcelEmail::find($model_id);

            if ($excel_email) {

                $excel_email->status = 'done';

                $excel_email->save();

                if ($excel_file = $excel_email->excel_file) {
                    if (
                        $excel_file->is_sending
                        && $excel_file->excel_emails()->where('status', '!=', 'done')->count() == 0
                    ) {
                        $excel_file->status = 'done';

                        $excel_file->save();

                    }
                }
            }
        }
    }
}
