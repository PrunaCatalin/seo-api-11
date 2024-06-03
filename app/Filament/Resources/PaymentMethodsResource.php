<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentMethodsResource\Pages;
use App\Filament\Resources\PaymentMethodsResource\RelationManagers;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Tenants\App\Models\Location\GenericCity;
use Modules\Tenants\App\Models\Location\GenericCountry;

class PaymentMethodsResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;
    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                //
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('provider')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Section::make('States')->schema([
                    Select::make('country_id')
                        ->relationship('genericCountry', 'name')
                        ->default(GenericCountry::where('name', '=', 'All')->first()->id)
                        ->required()
                        ->preload(),
                    Radio::make('is_active')->boolean()->default(false)->inline(),
                    Radio::make('is_sandbox')->boolean()->default(true)->inline(),
                ]),
                Section::make('Configuration')->schema([
                    KeyValue::make('configurations')
                        ->keyLabel('Key')
                        ->valueLabel('Value')
                        ->required(),
                ])
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name'),
                TextColumn::make('provider'),
                IconColumn::make('is_active')->boolean(),
                IconColumn::make('is_sandbox')->boolean(),
                TextColumn::make('genericCountry.name'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethods::route('/create'),
            'edit' => Pages\EditPaymentMethods::route('/{record}/edit'),
        ];
    }
}
