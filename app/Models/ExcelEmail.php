<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ExcelEmail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email_arqui',
        'num_obra',
        'obra',
        'dir_obra',
        'pobla_obra',
        'provi_obra',
        'type',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the user that owns the excel_email.
     */
    public function excel_file(): BelongsTo
    {
        return $this->belongsTo(ExcelFile::class);
    }

    public function getStatusLabelAttribute()
    {
        return __('status:email:'.$this->status);
    }
}
