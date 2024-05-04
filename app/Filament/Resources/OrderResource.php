<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;
use App\Helpers\EnumHelper;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Tenants\App\Enums\Customer\CustomerAccountStatus;
use Modules\Tenants\App\Enums\Order\OrderStatus;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup = 'Financial Transactions';

    protected static ?string $navigationLabel = 'List Orders';

    protected static ?int $navigationSort = -2;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->width(10)
                    ->alignment(Alignment::Center),
                TextColumn::make('customer.email')
                    ->alignment(Alignment::Center)
                    ->searchable(),

                TextColumn::make('internal_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(isIndividual: true),
                TextColumn::make('external_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(isIndividual: true),
                SelectColumn::make('status')
                    ->options(EnumHelper::getEnumValueNameMapping(OrderStatus::class))
                    ->updateStateUsing(function ($state, $record) {
                        if (strlen($state) > 0) {
                            $record->status = $state;
                            $record->save();
                            Notification::make()->success()->title('Order update successfully!')->send();
                        } else {
                            Notification::make()->danger()->title('Order state needs a value!')->send();
                        }
                    })->default(function ($state, $record) {
                        return $record->status;
                    })->disabled(function ($livewire, $record) {
                        return $record->status === OrderStatus::Completed->value;
                    }),
                TextColumn::make('amount')
                    ->money('USD')
                    ->alignment(Alignment::Center)
                    ->sortable(),
                TextColumn::make('paymentMethod.name')
                    ->alignment(Alignment::Center)
                    ->label('Method'),
                TextColumn::make('created_at')
                    ->alignment(Alignment::Center)
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(EnumHelper::getEnumValueNameMapping(OrderStatus::class)),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Details'),
                Tables\Actions\DeleteAction::make()
                    ->visible(function ($livewire, $record) {
                        return $record->status !== OrderStatus::Completed->value;
                    }),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
