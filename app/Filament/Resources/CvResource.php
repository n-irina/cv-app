<?php

namespace App\Filament\Resources;

use App\Enums\MediaType;
use App\Filament\Resources\CvResource\Pages;
use App\Filament\Resources\CvResource\RelationManagers\MediaRelationManager;
use App\Models\Contact;
use App\Models\Cv;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class CvResource extends Resource
{
    protected static ?string $model = Cv::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('contact_id')
                    ->required()
                    ->relationship('contact', 'lastname')
                    ->options(function (string $searchTerm = null) {
                        return Contact::query()
                            ->when($searchTerm, function ($query, $searchTerm) {
                                $query->where('email', 'like', "%{$searchTerm}%")
                                    ->orWhere('lastname', 'like', "%{$searchTerm}%")
                                    ->orWhere('firstname', 'like', "%{$searchTerm}%");
                            })
                            ->get()
                            ->mapWithKeys(function ($contact) {
                                $label = "{$contact->firstname} {$contact->lastname}";
                                if (!empty($contact->email)) {
                                    $label .= " ({$contact->email})";
                                }
                                return [$contact->id => $label];
                            });
                    })
                    ->placeholder('Choose the contact'),

                Forms\Components\Repeater::make('media')
                    ->relationship('media')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->label('Media Title'),
                        Forms\Components\FileUpload::make('media_path')
                            ->label('Media File')
                            ->acceptedFileTypes(['application/pdf', '.jpg', '.xlm', '.doc'])
                            ->directory('media')
                            ->multiple()
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->options([
                                MediaType::Resume->value => 'Resume',
                                MediaType::Contract->value => 'Contract',
                                MediaType::Other->value => 'Other',
                            ])
                            ->label('Media Type')
                            ->required(),
                        PdfViewerField::make('media_path')
                            ->required()
                            ->columns(1)
                            ->disabledOn(['edit','create'])
                            ->hiddenOn(['edit','create']),
                ])
                ->label('Add Media')
                ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact.lastname')
                    ->sortable()
                    ->searchable()
                    ->label('Owner'),
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
                Tables\Filters\SelectFilter::make('title')
                    ->options(
                        Cv::pluck('title', 'id'),
                    ),
                Tables\Filters\SelectFilter::make('contact_id')
                    ->options(
                        Contact::pluck('lastname', 'id'),
                    )
                    ->label('By owner\'s lastname'),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
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
           MediaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCvs::route('/'),
            'create' => Pages\CreateCv::route('/create'),
            'view' => Pages\ViewCv::route('/{record}'),
            'edit' => Pages\EditCv::route('/{record}/edit'),
        ];
    }
}
