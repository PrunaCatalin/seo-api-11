<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerCompanyRelationManager extends RelationManager
{
    protected static string $relationship = 'customerCompany';
    protected static ?string $title = 'Companies';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([
                    Hidden::make('city_id')->default(1),
                    Hidden::make('county_id')->default(1),
                    TextInput::make('company_name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('prefix_code')->default('NA')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('cui_code')->default('0')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('commerce_reg_letter')->default('NA')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('county_code')->default('NA')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('company_year')
                        ->numeric()
                        ->required(),
                    TextInput::make('bank_name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('iban_account')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('company_address')
                        ->required()
                        ->maxLength(255),
                ])->columns(2)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Customer Company')
            ->columns([
                Tables\Columns\TextColumn::make('company_name')->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('bank_name')->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('iban_account')->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('created_at')->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('updated_at')->searchable(isIndividual: true),
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
