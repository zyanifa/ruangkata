<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Pengguna', User::count())
                ->description('Total pengguna terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
                
            Stat::make('Jumlah Postingan', Post::count())
                ->description('Semua konten yang dipublikasikan')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart([2, 10, 3, 15, 4, 17, 18])
                ->color('info'),
                
            Stat::make('Jumlah Komentar', Comment::count())
                ->description('Keterlibatan pengguna')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->chart([15, 4, 17, 18, 20, 14, 23])
                ->color('warning'),
        ];
    }
}