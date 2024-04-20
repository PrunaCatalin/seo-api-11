<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionPlanResource\Pages;
use App\Filament\Resources\SubscriptionPlanResource\RelationManagers\DetailsRelationManager;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Models\SubscriptionPlan;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class SubscriptionPlanResource extends Resource
{
    protected static ?string $model = SubscriptionPlan::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()->schema([
                    Section::make('Details')->schema([
                        TextInput::make('name')->required()->maxLength(255)->unique(ignoreRecord: true),
                        TextInput::make('rate')
                            ->numeric()->extraAttributes(['step' => '0.01'])->required(),
                        TextInput::make('points')
                            ->numeric()->extraAttributes(['step' => '0.01'])->required(),
                        TextInput::make('points_annually')
                            ->numeric()->extraAttributes(['step' => '0.01'])->required(),
                        Section::make('States')->schema([
                            Forms\Components\Radio::make('is_active')->boolean()->default(false)->inline(),
                            Forms\Components\Radio::make('is_popular')->boolean()->default(false)->inline(),
                        ])->columns(2),
                        Textarea::make('description')->required(),

                    ])->columns(2),
                ])->columns(1)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('points')->searchable(),
                Tables\Columns\TextColumn::make('points_annually')->searchable(),
                Tables\Columns\TextColumn::make('description')->searchable(),
                Tables\Columns\TextColumn::make('rate')->searchable(),
                Tables\Columns\IconColumn::make('is_popular')->boolean()->searchable(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->searchable(),
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
            DetailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptionPlans::route('/'),
            'create' => Pages\CreateSubscriptionPlan::route('/create'),
            'edit' => Pages\EditSubscriptionPlan::route('/{record}/edit'),
        ];
    }
}
