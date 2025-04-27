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
    
    protected static ?string $navigationGroup = 'Content Moderation';
    
    protected static ?string $navigationLabel = 'Comment Reports';
    
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
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('reports_count')
                    ->label('Report Count')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('content')
                    ->limit(50)
                    ->searchable()
                    ->url(fn (Comment $record) => static::getUrl('view-reports', ['record' => $record])),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->limit(30)
                    ->sortable(),
                Tables\Columns\TextColumn::make('reports_count')
                    ->label('Reports')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('reports_count', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view_comment')
                        ->label('View Comment')
                        ->url(fn (Comment $record) => url("@{$record->post->user->username}/{$record->post->slug}#comment-{$record->id}"))
                        ->openUrlInNewTab()
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Delete Comment')
                        ->modalHeading('Delete Comment')
                        ->modalDescription('Are you sure you want to delete this comment? This action cannot be undone.')
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