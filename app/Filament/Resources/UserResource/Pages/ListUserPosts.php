<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Post;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;

class ListUserPosts extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.list-user-posts';

    public $user;

    public function mount($record): void
    {
        $this->user = static::getResource()::getModel()::findOrFail($record);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()->where('user_id', $this->user->id)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->sortable()
                    ->searchable()
                    ->url(function (Post $record): string {
                        return url("@{$record->user->username}/{$record->slug}");
                    })
                    ->openUrlInNewTab(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Dipublikasi pada')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('claps_count')
                    ->counts('claps')
                    ->label('Jumlah Clap')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (Post $record): string => url("@{$record->user->username}/{$record->slug}"))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to Users')
                ->url(UserResource::getUrl())
                ->color('secondary'),
            Actions\Action::make('viewProfile')
                ->label('Lihat Profil Pengguna')
                ->url(url("@{$this->user->username}"))
                ->openUrlInNewTab()
                ->color('success')
                ->icon('heroicon-o-user'),
        ];
    }

    public function getTitle(): string 
    {
        return "Post oleh {$this->user->name}";
    }

    public function getSubheading(): string
    {
        return "@{$this->user->username} • {$this->user->posts->count()} post";
    }
}