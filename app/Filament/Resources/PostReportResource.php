<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostReportResource\Pages;
use App\Models\Post;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostReportResource extends Resource
{
    protected static ?string $model = Post::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    
    protected static ?string $navigationGroup = 'Moderasi Konten';
    
    protected static ?string $navigationLabel = 'Laporan Post';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $recordTitleAttribute = 'title';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('reports')
            ->withCount('reports');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reports_count')
                    ->label('Report Count')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Post $record) => static::getUrl('view-reports', ['record' => $record])),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penulis')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reports_count')
                    ->label('Jumlah Laporan')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Dipublikasikan pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('reports_count', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view_post')
                        ->label('Lihat Post')
                        ->url(fn (Post $record) => url("@{$record->user->username}/{$record->slug}"))
                        ->openUrlInNewTab()
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus Post')
                        ->modalHeading('Hapus Post')
                        ->modalDescription('Apakah Anda yakin ingin menghapus post ini?'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostReports::route('/'),
            'view-reports' => Pages\ViewPostReports::route('/{record}/reports'),
        ];
    }
}