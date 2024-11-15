<?php

namespace App\Filament\Resources\ContractResource\RelationManagers;

use App\Enums\MediaType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class MediaRelationManager extends RelationManager
{
    protected static string $relationship = 'media';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                ->required(),
            Forms\Components\FileUpload::make('media_path')
                ->required()
                ->columns(1)
                ->acceptedFileTypes(['application/pdf','.jpg', '.xlm', '.doc'])
                ->multiple()
                ->directory('media')
                ->hiddenOn('view'),
            PdfViewerField::make('media_path')
                ->required()
                ->columns(1)
                ->disabledOn(['edit','create'])
                ->hiddenOn(['edit','create']),
            Forms\Components\Select::make('contract_id')
                ->relationship('contracts', 'id'),
            Forms\Components\Select::make('type')
                ->options([
                    MediaType::Resume ->value => 'Resume',
                    MediaType::Contract ->value => 'Contract',
                    MediaType::Other ->value => 'Other',
                ])
                ->placeholder('Choose the type of media')
                ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
