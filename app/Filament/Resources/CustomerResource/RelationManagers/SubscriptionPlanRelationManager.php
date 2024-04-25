<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Models\SubscriptionPlan;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Modules\Tenants\App\Enums\Subscription\SubscriptionStatus;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Services\Customer\WalletService;
use Modules\Tenants\App\Services\Subscription\SubscriptionService;

class SubscriptionPlanRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptionPlans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subscription')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('subscription')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('pivot.frequency')->label('Frequency'),
                TextColumn::make('points')->getStateUsing(function ($record) {
                    return match ($record->pivot->frequency) {
                        'monthly' => $record->points,
                        'yearly' => $record->points_annually
                    };
                }),
                TextColumn::make('pivot.created_at')
                    ->label('Start'),
                TextColumn::make('pivot.ended_at')
                    ->label('End'),
                Tables\Columns\IconColumn::make('is_demo')
                    ->label('Demo')->boolean()->searchable(),
                TextColumn::make('remaining_days')
                    ->label('Remaining Days')
                    ->getStateUsing(function ($record) {
                        $createdAt = Carbon::parse($record->pivot->created_at);
                        $endedAt = Carbon::parse($record->pivot->ended_at);
                        if (!$createdAt || !$endedAt) {
                            return 'Invalid dates';
                        }
                        if ($endedAt->isPast()) {
                            return 'Expired';
                        } else {
                            $diff = $createdAt->diff($endedAt);
                            $diffInMonths = $createdAt->diffInMonths($endedAt);
                            return sprintf(
                                '%d months, %d days, %d hours',
                                $diffInMonths,
                                $diff->d,
                                $diff->h
                            );
                        }
                    }),
                TextColumn::make('pivot.status')
                    ->label('Status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->form([
                        Forms\Components\Select::make('subscription_plan_id')
                            ->label('Select Plan')
                            ->options(
                                SubscriptionPlan::isActive()->hasNeverBeenDemoForCustomer(
                                    $this->getOwnerRecord()->id
                                )->pluck('name', 'id')->toArray()
                            )
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('frequency')->options([
                            'monthly' => 'Monthly',
                            'yearly' => 'Yearly',
                        ])->required(),
                    ])->action(function (array $data, Tables\Actions\Action $action): void {
                        $relatedModel = $this->getOwnerRecord();
                        $subscriptionService = new SubscriptionService();
                        try {
                            $subscriptionService->attachPlan($relatedModel, $data);
                            Notification::make()->success()->title('Subscription plan attached successfully!')->send();
                        } catch (ServiceException $e) {
                            Notification::make()->danger()->title($e->getMessage())->send();
                        }
                    })
            ])
            ->actions([
                Tables\Actions\Action::make('cancel-subscription')
                    ->label('Cancel')
                    ->icon('heroicon-s-archive-box-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->after(function (RelationManager $livewire, $record) {
                        $subscriptionService = new SubscriptionService();
                        $relatedModel = $this->getOwnerRecord();
                        try {
                            $subscriptionService->cancelPlan($relatedModel, $record->pivot->subscription_plan_id);
                            Notification::make()->success()->title('Subscription was cancelled with success')->send();
                        } catch (ServiceException $e) {
                            Notification::make()->danger()->title($e->getMessage())->send();
                        }
                    })->visible(function (RelationManager $livewire, $record) {
                        return $record->pivot->status === SubscriptionStatus::ACTIVE->value;
                    }),
                Tables\Actions\Action::make('active-subscription')
                    ->label('Activate')
                    ->icon('heroicon-s-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalDescription(
                        'All active subscription will be canceled and activate this one, credits will be cumulated'
                    )
                    ->after(function (RelationManager $livewire, $record) {
                        $subscriptionService = new SubscriptionService();
                        $relatedModel = $this->getOwnerRecord();
                        try {
                            $subscriptionService->activatePlan($relatedModel, $record->pivot->subscription_plan_id);
                            Notification::make()->success()->title('Subscription was activated with success')->send();
                        } catch (ServiceException $e) {
                            Notification::make()->danger()->title($e->getMessage())->send();
                        }
                    })->visible(function (RelationManager $livewire, $record) {
                        return $record->pivot->status === SubscriptionStatus::PENDING->value;
                    }),
                Tables\Actions\DetachAction::make()->action(function (RelationManager $livewire, $record) {
                    $relatedModel = $this->getOwnerRecord();
                    $subscriptionService = new SubscriptionService();
                    try {
                        $subscriptionService->detachPlan($relatedModel, $record->pivot);
                    } catch (ServiceException $e) {
                        Notification::make()->danger()->title($e->getMessage())->send();
                    }
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
