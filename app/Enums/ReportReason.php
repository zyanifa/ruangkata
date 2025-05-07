<?php

namespace App\Enums;

enum ReportReason: string
{
    case IRRELEVANT = 'konten_tidak_relevan';
    case HATE_SPEECH = 'ujaran_kebencian';
    case SPAM = 'spam';
    case MISLEADING = 'informasi_menyesatkan';
    case INAPPROPRIATE = 'konten_tidak_pantas';
    case OTHER = 'lainnya';

    public function label(): string
    {
        return match($this) {
            self::IRRELEVANT => 'Konten tidak ada hubungannya dengan teknologi',
            self::HATE_SPEECH => 'Konten mengandung tulisan negatif/ujaran kebencian',
            self::SPAM => 'Spam atau konten promosi berlebihan',
            self::MISLEADING => 'Informasi menyesatkan',
            self::INAPPROPRIATE => 'Konten tidak pantas',
            self::OTHER => 'Alasan lainnya',
        };
    }

    public static function getReasons(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->label()
        ])->all();
    }
}