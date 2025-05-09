<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPostsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Post Terbaru')
            ->description('Konten terbaru yang dipublikasikan di platform')
            ->query(Post::with('user')->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comments_count')
                    ->counts('comments')
                    ->label('Komentar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dipublikasikan Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->url(fn (Post $record): string => url("@{$record->user->username}/{$record->slug}"))
                    ->icon('heroicon-o-eye')
                    ->openUrlInNewTab(),
            ]);
    }
}