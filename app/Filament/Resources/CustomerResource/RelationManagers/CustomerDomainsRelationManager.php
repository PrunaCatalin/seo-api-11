<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Tenants\App\Models\Customer\Customer;

class CustomerDomainsRelationManager extends RelationManager
{
    protected static string $relationship = 'customerDomains';
    protected static ?string $title = 'Domains';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('domain')
                    ->unique(ignoreRecord: true)
                    ->prefix('https://')
                    ->label('Domain')
                    ->required()
                    ->maxLength(255),
                TextInput::make('tenant_id')
                    ->label('Tenant')
                    ->default($this->getOwnerRecord()->getAttribute('tenant_id'))
                    ->readOnly()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        $currentPlan = $this->getOwnerRecord()->currentPlan();
        return $table
            ->recordTitleAttribute('Domains')
            ->columns([
                Tables\Columns\TextColumn::make('domain')->searchable(),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->disabled(function () use($currentPlan) {
                    return !$currentPlan;
                })->label(function() use($currentPlan) {
                    return $currentPlan ? "Add Domain" : "Subscription plan is missing";
                })
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
