<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers\CustomerCompanyRelationManager;
use App\Filament\Resources\CustomerResource\RelationManagers\CustomerDomainsRelationManager;
use App\Filament\Resources\CustomerResource\RelationManagers\ReferralsReceivedRelationManager;
use App\Filament\Resources\CustomerResource\RelationManagers\SubscriptionPlanRelationManager;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Modules\Tenants\App\Enums\Customer\CustomerAccountStatus;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Services\Subscription\SubscriptionService;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationGroup = 'Customer';
    protected static ?string $navigationLabel = 'List Customers';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Grid::make('')->schema([
                    Tabs::make('Customer Details')->schema([
                        Tab::make('Customer details')->schema([
                            TextInput::make('email')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),
                            Select::make('tenant_id')
                                ->relationship('tenant', 'id')
                                ->required(),
                            TextInput::make('password')
                                ->password()
                                ->maxLength(255)
                                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(Page $livewire) => ($livewire instanceof CreateRecord))
                                ->confirmed(),
                            TextInput::make('password_confirmation')
                                ->password()->required(
                                    fn(Page $livewire) => ($livewire instanceof CreateRecord)
                                ),
                            Select::make('account_status')
                                ->options([
                                    CustomerAccountStatus::OPEN->value => CustomerAccountStatus::OPEN->name,
                                    CustomerAccountStatus::PENDING->value => CustomerAccountStatus::PENDING->name,
                                    CustomerAccountStatus::BLOCKED->value => CustomerAccountStatus::BLOCKED->name,
                                ])->default(CustomerAccountStatus::OPEN->value)
                                ->required(),
                        ])->columns(2),
                        Tab::make('Personal Details')->schema([
                            Fieldset::make('Details')
                                ->relationship('customerDetails')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('lastname')
                                        ->label('Last Name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('phone')
                                        ->label('Phone')
                                        ->required()
                                        ->maxLength(255),
                                    DatePicker::make('date_of_birth')
                                        ->label('Date Of birth')
                                        ->required(),
                                    Select::make('gender')
                                        ->label('Gender')
                                        ->options(['0' => 'Male', '1' => 'Female'])
                                        ->required()
                                ])

                        ])->columns(3),
                        Tab::make('Financial information')->schema([
                            Fieldset::make('Details')
                                ->schema([
                                    Forms\Components\Placeholder::make('credits')
                                        ->content(
                                            fn(Customer $record): string => $record->credits
                                        )->label('Credit'),
                                    Forms\Components\Placeholder::make('current_plan')
                                        ->content(
                                            function (Customer $record): string {
                                                $currentPlan = $record->currentPlan();
                                                if ($currentPlan) {
                                                    return $currentPlan->name . ' | ' .
                                                        $currentPlan->pivot->frequency . ' | ' .
                                                        (new SubscriptionService())
                                                            ->calculateCredits(
                                                                $currentPlan->pivot->frequency,
                                                                $currentPlan->pivot->subscription_plan_id
                                                            );
                                                } else {
                                                    return 'None';
                                                }
                                            }
                                        )->label('Current Plan'),
                                    Forms\Components\Placeholder::make('next_plan')
                                        ->content(
                                            function (Customer $record): string {
                                                $nextPlan = $record->nextPlan();
                                                if ($nextPlan) {
                                                    return $nextPlan->name . ' | ' .
                                                        $nextPlan->pivot->frequency . ' | ' .
                                                        (new SubscriptionService())
                                                            ->calculateCredits(
                                                                $nextPlan->pivot->frequency,
                                                                $nextPlan->pivot->subscription_plan_id
                                                            );
                                                } else {
                                                    return 'None';
                                                }
                                            }
                                        )
                                        ->label('Next plan'),
                                    Forms\Components\Placeholder::make('next_payment_day')
                                        ->content(
                                            function (Customer $record): string {
                                                $nextPlan = $record->currentPlan();
                                                if ($nextPlan) {
                                                    return $nextPlan->pivot->ended_at;
                                                } else {
                                                    return 'None';
                                                }
                                            }
                                        )
                                        ->label('Next payment date'),

                                ])

                        ])->columns(2)
                    ])
                ])->columns(1)


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customerDetails.name')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->label('Name'),
                Tables\Columns\TextColumn::make('customerDetails.lastname')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->label('Last Name'),
                Tables\Columns\TextColumn::make('referral_id')
                    ->searchable(isIndividual: true)
                    ->extraAttributes(['style' => 'max-width:260px'])
                    ->wrap(),
                Tables\Columns\TextColumn::make('email')->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('account_status'),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()->searchable(),
            ])
            ->filters([
                //
                SelectFilter::make('account_status')
                    ->options([
                        CustomerAccountStatus::OPEN->value => CustomerAccountStatus::OPEN->name,
                        CustomerAccountStatus::PENDING->value => CustomerAccountStatus::PENDING->name,
                        CustomerAccountStatus::BLOCKED->value => CustomerAccountStatus::BLOCKED->name,
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            CustomerDomainsRelationManager::class,
            CustomerCompanyRelationManager::class,
            ReferralsReceivedRelationManager::class,
            SubscriptionPlanRelationManager::class


        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
