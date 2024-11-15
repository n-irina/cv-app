<?php

namespace App\Filament\Resources;

use App\Enums\CompanyType;
use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers\ContactsRelationManager;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\SpatieTagsInput::make('techno')
                    ->placeholder('Choose the technologies'),
                Forms\Components\Select::make('company_type')
                    ->options([
                        CompanyType::Service->value => 'Service Provider',
                        CompanyType::Customer->value => 'Customer Business',
                    ])
                    ->placeholder('Choose the type of the company'),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('legal_status')
                    ->maxLength(10),
                Forms\Components\TextInput::make('SIRET_number')
                    ->numeric()
                    ->maxLength(14),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\SpatieTagsColumn::make('techno')
                    ->type('technologies'),
                Tables\Columns\TextColumn::make('company_type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('legal_status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('SIRET_number')
                    ->label('SIRET')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('name')
                    ->label('By name')
                    ->options(
                        Company::pluck('name', 'id'),
                    ),
                Tables\Filters\SelectFilter::make('company_type')
                    ->label('By type')
                    ->options(
                        Company::pluck('company_type', 'company_type'),
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
           ContactsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
            'view' => Pages\ViewCompany::route('/{record}'),
        ];
    }
}
