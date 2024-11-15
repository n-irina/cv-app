<?php

namespace App\Filament\Resources;

use App\Enums\ContactProfil;
use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers\CvsRelationManager;
use App\Models\Company;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personnal details')
                    ->schema([
                        Forms\Components\TextInput::make('lastname')
                            ->required(),
                        Forms\Components\TextInput::make('firstname')
                            ->required(),
                    ]),
                Forms\Components\Section::make('Contact details')
                    ->description('At least one of these fileds is required')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                        ->requiredWithoutAll(['linkedin', 'phone'])
                        ->reactive(),
                    Forms\Components\TextInput::make('linkedin')
                        ->requiredWithoutAll(['email', 'phone'])
                        ->reactive(),
                    Forms\Components\TextInput::make('phone')
                        ->requiredWithoutAll(['linkedin', 'email'])
                        ->reactive(),
                    ]),
                Forms\Components\Section::make('Work details')
                    ->schema([
                        Forms\Components\TextInput::make('job_title'),
                        Forms\Components\Select::make('profil')
                            ->options([
                                ContactProfil::Candidate ->value => 'Candidate',
                                ContactProfil::Headhunter ->value => 'Headhunter',
                                ContactProfil::Salesman ->value => 'Salesman',
                            ])
                            ->placeholder('Choose the profil')
                            ->required(),
                        Forms\Components\Select::make('company_id')
                            ->relationship('company', 'name')
                            ->placeholder('Choose the company'),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('firstname')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('lastname')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('phone')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('linkedin')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('job_title')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('profil')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('company.name')
                ->label('Company'),
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
                Tables\Filters\SelectFilter::make('profil')
                    ->label('By profil')
                    ->options(
                        Contact::pluck('profil', 'profil'),
                    ),
                    Tables\Filters\SelectFilter::make('company_id')
                    ->label('By Company')
                    ->options(
                        Company::pluck('name', 'id')
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
          CvsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
