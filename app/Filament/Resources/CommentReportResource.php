<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentReportResource\Pages;
use App\Models\Comment;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentReportResource extends Resource
{
    protected static ?string $model = Comment::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';
    
    protected static ?string $navigationGroup = 'Moderasi Konten';
    
    protected static ?string $navigationLabel = 'Laporan Komentar';
    
    protected static ?int $navigationSort = 2;

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
                Forms\Components\Textarea::make('content')
                    ->label('Isi Komentar')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('reports_count')
                    ->label('Jumlah Laporan')
                    ->label('Report Count')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('content')
                    ->label('Isi Komentar')
                    ->limit(50)
                    ->searchable()
                    ->url(fn (Comment $record) => static::getUrl('view-reports', ['record' => $record])),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pembuat')
                    ->sortable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Judul Post')
                    ->limit(30)
                    ->sortable(),
                Tables\Columns\TextColumn::make('reports_count')
                    ->label('Jumlah Laporan')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Komentar Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('reports_count', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view_comment')
                        ->label('Lihat Komentar')
                        ->url(fn (Comment $record) => url("@{$record->post->user->username}/{$record->post->slug}#comment-{$record->id}"))
                        ->openUrlInNewTab()
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus Komentar')
                        ->modalHeading('Hapus Komentar')
                        ->modalDescription('Apakah Anda yakin ingin menghapus komentar ini?')
                        ->successRedirectUrl(CommentReportResource::getUrl('index')),
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
            'index' => Pages\ListCommentReports::route('/'),
            'view-reports' => Pages\ViewCommentReports::route('/{record}/reports'),
        ];
    }
}