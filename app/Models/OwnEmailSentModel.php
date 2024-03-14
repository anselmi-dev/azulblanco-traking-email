<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use jdavidbakr\MailTracker\Concerns\IsSentEmailModel;
use jdavidbakr\MailTracker\Contracts\SentEmailModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnEmailSentModel extends Model implements SentEmailModel {

    protected $table = 'sent_emails';

    use IsSentEmailModel;

    protected static $unguarded = true;

    protected $casts = [
        'meta' => 'collection',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
    ];

    /**
     * Get the excel_emails for the excel_file.
     */
    public function excel_email (): BelongsTo
    {
        return $this->belongsTo(ExcelEmail::class);
    }
}
