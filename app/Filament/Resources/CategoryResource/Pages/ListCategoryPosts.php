<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Models\Post;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Builder;

class ListCategoryPosts extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = CategoryResource::class;

    protected static string $view = 'filament.resources.category-resource.pages.list-category-posts';

    public $category;

    public function mount($record): void
    {
        $this->category = static::getResource()::getModel()::findOrFail($record);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()->where('category_id', $this->category->id)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->sortable()
                    ->searchable()
                    ->url(function (Post $record): string {
                        return url("@{$record->user->username}/{$record->slug}");
                    }),
                TextColumn::make('user.name')
                    ->label('Penulis')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Dipublikasikan Pada')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('claps_count')
                    ->counts('claps')
                    ->label('Jumlah Like')
                    ->sortable(),
            ])
            ->filters([
                // Add any filters you want here
            ])
            ->actions([
                // Add actions if needed
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to Categories')
                ->url(CategoryResource::getUrl())
                ->color('secondary'),
        ];
    }

    public function getTitle(): string 
    {
        return "Postingan pada kategori {$this->category->name}";
    }
}