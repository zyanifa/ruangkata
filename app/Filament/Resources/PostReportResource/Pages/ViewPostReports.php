<?php

namespace App\Filament\Resources\PostReportResource\Pages;

use App\Filament\Resources\PostReportResource;
use App\Models\Report;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ViewPostReports extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    
    protected static string $resource = PostReportResource::class;

    protected static string $view = 'filament.resources.post-report-resource.pages.view-post-reports';
    
    public $record;
    
    public function mount($record): void
    {
        $this->record = static::getResource()::getModel()::findOrFail($record);
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Report::query()->where('reportable_type', 'App\\Models\\Post')
                    ->where('reportable_id', $this->record->id)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Reported By')
                    ->sortable(),
                TextColumn::make('reason')
                    ->formatStateUsing(fn (string $state) => Report::getReasons()[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('details')
                    ->limit(50),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('reviewed')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Reviewed' : 'Pending'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('reason')
                    ->options(Report::getReasons()),
                Tables\Filters\SelectFilter::make('reviewed')
                    ->options([
                        '0' => 'Pending',
                        '1' => 'Reviewed',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_reviewed')
                    ->label('Mark as Reviewed')
                    ->visible(fn (Report $record) => !$record->reviewed)
                    ->action(fn (Report $record) => $record->update(['reviewed' => true]))
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('mark_pending')
                    ->label('Mark as Pending')
                    ->visible(fn (Report $record) => $record->reviewed)
                    ->action(fn (Report $record) => $record->update(['reviewed' => false]))
                    ->color('warning')
                    ->icon('heroicon-o-clock'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_reviewed')
                        ->label('Mark as Reviewed')
                        ->action(fn ($records) => $records->each->update(['reviewed' => true]))
                        ->color('success')
                        ->icon('heroicon-o-check'),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public function getTitle(): string 
    {
        return "Reports for: {$this->record->title}";
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_post')
                ->label('View Post')
                ->url(url("@{$this->record->user->username}/{$this->record->slug}"))
                ->openUrlInNewTab()
                ->color('success')
                ->icon('heroicon-o-eye'),
            Actions\Action::make('delete_post')
                ->label('Delete Post')
                ->action(function () {
                    $this->record->delete();
                    return redirect()->to(PostReportResource::getUrl('index'));
                })
                ->requiresConfirmation()
                ->modalHeading('Delete Post')
                ->modalDescription('Are you sure you want to delete this post? This action cannot be undone.')
                ->color('danger')
                ->icon('heroicon-o-trash'),
        ];
    }
}