<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $navigationLabel = 'Pengguna';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label('Email Terverifikasi Pada'),
                Forms\Components\TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Forms\Components\Textarea::make('bio')
                    ->label('Bio Data')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_admin')
                    ->label('Adalah Admin')
                    ->helperText('Nyalakan jika pengguna adalah admin')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Nama")
                    ->searchable()
                    ->sortable()
                    ->url(fn (User $record): string => 
                        static::getUrl('posts', ['record' => $record])),
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Jumlah Postingan')
                    ->counts('posts')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Terverifikasi pada')                
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_admin')
                    ->options([
                        '1' => 'Admin',
                        '0' => 'User',
                    ])
                    ->label('Role'),
                Tables\Filters\Filter::make('verified')
                    ->query(fn ($query) => $query->whereNotNull('email_verified_at'))
                    ->label('Verified Users'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make('posts')
                        ->label('Lihat Postingan')
                        ->url(fn (User $record): string => 
                            static::getUrl('posts', ['record' => $record])),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'posts' => Pages\ListUserPosts::route('/{record}/posts'),
        ];
    }
}