<?php

namespace App\Filament\Resources;

use App\Enums\MediaType;
use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
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
            Forms\Components\Select::make('cv_id')
                ->relationship('cv', 'title'),
            Forms\Components\Select::make('contract_id')
                ->relationship('contract', 'id'),
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

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('media_path')
                ->label('Media')
                ->formatStateUsing(function ($state) {
                    return Storage::url($state);
                })
                ->url(fn ($record) => Storage::url($record->media_path[0]))
                ->openUrlInNewTab(),
            Tables\Columns\TextColumn::make('type')
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
                Tables\Filters\SelectFilter::make('type')
                    ->label('By type')
                    ->options(
                        Media::pluck('type', 'type'),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\LinkAction::make('download')
                    ->label('Télécharger')
                    ->url(fn ($record) => Storage::url($record->media_path[0]))
                    ->icon('heroicon-o-document-arrow-down')
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'view' => Pages\ViewMedia::route('/{record}'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
