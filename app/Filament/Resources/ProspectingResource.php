<?php

namespace App\Filament\Resources;

use App\Enums\ContactProfil;
use App\Enums\MediaType;
use App\Models\Contact;
use App\Models\Prospecting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\ProspectingType;
use App\Filament\Resources\ProspectingResource\RelationManagers\MediaRelationManager;
use App\Models\User;
use Filament\Forms\Get;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class ProspectingResource extends Resource
{
    protected static ?string $model = Prospecting::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('contacts')
                    ->required()
                    ->searchable()
                    ->multiple()
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
                    ->reactive(),
                Forms\Components\Select::make('type')
                    ->options([
                        ProspectingType::Email->value => 'Email',
                        ProspectingType::Call->value => 'Call',
                        ProspectingType::Meeting->value => 'Meeting',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('subject')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('observation')
                    ->nullable(),
                Forms\Components\MarkdownEditor::make('note')
                    ->nullable(),
                Forms\Components\Toggle::make('add_media')
                    ->label('Add Media')
                    ->default(false)
                    ->hiddenOn(['view'])
                    ->inline(false)
                    ->reactive(),
                Forms\Components\Repeater::make('media')
                    ->relationship('media')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Media Title')
                            ->required(),
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
                            ->nullable(),
                        PdfViewerField::make('media_path')
                            ->columns(1)
                            ->disabledOn(['edit', 'create'])
                            ->hiddenOn(['edit', 'create'])
                            ->required(),
                    ])
                    ->label('Other Media')
                    ->visible(fn (Get $get, string $context) => $get('add_media') || $context=='view')
                    ->collapsible(),
                Forms\Components\Toggle::make('add_contact')
                    ->label('Add contact')
                    ->default(false)
                    ->hiddenOn(['view'])
                    ->inline(false)
                    ->reactive(),
                Forms\Components\Repeater::make('new_contacts')
                    ->schema([
                        Forms\Components\TextInput::make('lastname')
                            ->required(),
                        Forms\Components\TextInput::make('firstname')
                            ->required(),
                        Forms\Components\TextInput::make('email'),
                        Forms\Components\TextInput::make('linkedin'),
                        Forms\Components\TextInput::make('phone'),
                        Forms\Components\TextInput::make('job_title'),
                        Forms\Components\Select::make('profil')
                            ->options([
                                ContactProfil::Candidate ->value => 'Candidate',
                                ContactProfil::Headhunter ->value => 'Headhunter',
                                ContactProfil::Salesman ->value => 'Salesman',
                            ])
                            ->placeholder('Choose the profil')
                            ->required(),
                    ])
                    ->visible(fn (Get $get) => $get('add_contact'))
                    ->label('Contact')
                    ->defaultItems(1)
                    ->afterStateUpdated(function (array $state, callable $set) {

                        foreach ($state as $newContactData) {
                            Contact::create($newContactData);
                        }

                        $set('add_contact', false);
                        $set('add_media', true);
                        $set('new_contacts', []);
                    })
                   ->collapsible(),
                ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contacts')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('createdBy')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('observation')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('note')
                    ->markdown()
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
                Tables\Filters\SelectFilter::make('createdBy')
                    ->options([
                        User::pluck('name', 'name')->toArray()
                    ])
                    ->label('By user'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ExportAction::make('prospecting-file.pdf')
                    ->url(fn()=>route('pdf'))
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
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
            MediaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ProspectingResource\Pages\ListProspecting::route('/'),
            'create' => ProspectingResource\Pages\CreateProspecting::route('/create'),
            'edit' => ProspectingResource\Pages\EditProspecting::route('/{record}/edit'),
            'view' => ProspectingResource\Pages\ViewProspecting::route('/{record}'),
        ];
    }
}
