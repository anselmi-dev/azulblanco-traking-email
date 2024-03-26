<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use App\Observers\ExcelFileObserver;
use App\Models\OwnEmailSentModel;

#[ObservedBy([ExcelFileObserver::class])]
class ExcelFile extends Model
{
    use HasFactory;

    const DISK = 'public';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'original_name',
        'status',
        'file',
        'message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array'
    ];

    /**
     * Get the user that owns the excel_file.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the excel_emails for the excel_file.
     */
    public function excel_emails(): HasMany
    {
        return $this->hasMany(ExcelEmail::class);
    }

    /**
     * Get the emails for the excel_file.
     */
    public function emails(): HasManyThrough
    {
        return $this->hasManyThrough(OwnEmailSentModel::class, ExcelEmail::class);
    }

    /**
     * Get the user's first name.
     */
    public function getFilePathAttribute()
    {
        return Storage::disk($this->DISK)->url($this->file);
    }

    /**
     * Get the user's first name.
     */
    public function getFileStorageAttribute()
    {
        return Storage::disk($this->DISK)->get($this->file);
    }

    public function getIsPendingAttribute() : bool
    {
        return $this->status === 'pending';
    }

    public function getIsReadingAttribute() : bool
    {
        return $this->status === 'reading';
    }

    public function getIsSentAttribute() : bool
    {
        return in_array($this->status, [
            'sending',
            'done',
            'error',
        ]);
    }

    public function getIsSendingAttribute() : bool
    {
        return $this->status === 'sending';
    }

    public function getIsProcessedAttribute() : bool
    {
        return $this->is_error || $this->is_done;
    }

    public function getIsErrorAttribute() : bool
    {
        return $this->status === 'error';
    }

    public function getIsDoneAttribute() : bool
    {
        return $this->status === 'done';
    }

    public function getStatusLabelAttribute()
    {
        return __('status:'.$this->status);
    }
}
