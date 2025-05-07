<?php

namespace App\Models;

use App\Enums\ReportReason;
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

    protected $casts = [
        'reason' => ReportReason::class,
    ];

    public static function getReasons(): array
    {
        return ReportReason::getReasons();
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