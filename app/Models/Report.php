<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reason',
        'details',
        'reviewed',
    ];

    // Define report reasons as enum-like constants
    public const REASON_IRRELEVANT = 'konten_tidak_relevan';
    public const REASON_HATE_SPEECH = 'ujaran_kebencian';
    public const REASON_SPAM = 'spam';
    public const REASON_MISLEADING = 'informasi_menyesatkan';
    public const REASON_INAPPROPRIATE = 'konten_tidak_pantas';
    public const REASON_OTHER = 'lainnya';

    // Get all available reasons
    public static function getReasons(): array
    {
        return [
            self::REASON_IRRELEVANT => 'Konten tidak ada hubungannya dengan teknologi',
            self::REASON_HATE_SPEECH => 'Konten mengandung tulisan negatif/ujaran kebencian',
            self::REASON_SPAM => 'Spam atau konten promosi berlebihan',
            self::REASON_MISLEADING => 'Informasi menyesatkan',
            self::REASON_INAPPROPRIATE => 'Konten tidak pantas',
            self::REASON_OTHER => 'Alasan lainnya',
        ];
    }

    public function reportable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}