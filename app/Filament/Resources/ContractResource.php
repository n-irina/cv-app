<?php

namespace App\Filament\Resources;

use App\Enums\ContractType;
use App\Enums\MediaType;
use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers\MediaRelationManager;
use App\Models\Contact;
use App\Models\Contract;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('type')
                ->options([
                    ContractType::Long ->value => 'Long',
                    ContractType::Short ->value => 'Short',
                    ContractType::Ponctual ->value => 'Ponctual',
                ])
                ->required(),
            Forms\Components\DatePicker::make('start_date')
                ->required()
                ->minDate(Carbon::today())
                ->live(onBlur: true),
            Forms\Components\DatePicker::make('end_date')
                ->required()
                ->minDate(fn (callable $get) => $get('start_date') ?? Carbon::today()),
            Forms\Components\Select::make('signatories')
                ->searchable()
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
                ->multiple(),
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
            Tables\Columns\TextColumn::make('type')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('start_date')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('end_date')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('signatories')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('media.title')
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
                        Contract::pluck('type', 'type'),
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
            MediaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'view' => Pages\ViewContract::route('/{record}'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
