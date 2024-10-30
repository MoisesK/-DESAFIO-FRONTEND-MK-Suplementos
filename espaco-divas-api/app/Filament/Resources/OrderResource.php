<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Helpers\AmountHelper;
use App\Models\Enum\OrderStatus;
use App\Models\Order;
use DateTimeImmutable;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?string $navigationIcon = 'heroicon-s-book-open';
    protected static ?string $navigationLabel = 'Agendamentos';
    protected static ?string $label = "Agendamentos";

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn (int $state) => match ($state) {
                        1 => 'PENDENTE',
                        2 => 'COMPROVANTE APROVADO',
                        3 => 'CONFIRMADO',
                        4 => 'CANCELADO',
                        5 => 'COMPROVANTE NÃO APROVADO',
                    })
                    ->badge()
                    ->color(fn (int $state) => match ($state) {
                        1 => 'warning',
                        2 => 'success',
                        3 => 'success',
                        4 => 'danger',
                        5 => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produto')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->formatStateUsing(fn ($state) => 'R$ ' . AmountHelper::formatAmountToMoneyReal($state))
                    ->label('Valor Final')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pre_amount')
                    ->formatStateUsing(fn ($state) => 'R$ ' . AmountHelper::formatAmountToMoneyReal($state))
                    ->label('Valor da Reserva')
                    ->sortable(),
                Tables\Columns\TextColumn::make('post_amount')
                    ->formatStateUsing(fn ($state) => 'R$ ' . AmountHelper::formatAmountToMoneyReal($state))
                    ->label('Valor Faltante')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_proof_file_path')
                    ->label('Comprovante')
                    ->default('')
                    ->formatStateUsing(function ($state) {
                        return "<a href='{$state}' target='_blank' class='text-blue-500 hover:underline'>Visualizar</a>";
                    })
                    ->html(),
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
//                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('approve')
                        ->hidden(fn (Model $record) => $record->status !== OrderStatus::PENDING->value)
                        ->label('Aprovar')
                        ->color('success')
                        ->modalHeading('Aprovar Comprovante de Pagamento')
                        ->requiresConfirmation()
                        ->action(function (Order $record) {
                            $record->status = OrderStatus::PROOF_FILE_APPROVED;
                            $record->save();
                        }),
                    Tables\Actions\Action::make('refuse_proof_file')
                        ->hidden(fn (Model $record) => $record->status !== OrderStatus::PENDING->value)
                        ->label('Recusar')
                        ->form([
                            Forms\Components\Textarea::make('reason')->label('Motivo')->required()
                        ])
                        ->color('danger')
                        ->modalHeading('Recusar Comprovante de Pagamento')
                        ->requiresConfirmation()
                        ->action(function (Order $record, array $data) {
                            $record->status = OrderStatus::PROOF_FILE_NOT_APPROVED;
                            $record->refused_reason = $data['reason'];
                            $record->save();
                        }),
                    Tables\Actions\Action::make('confirm_customer_schedule')
                        ->hidden(fn (Model $record) => $record->status !== OrderStatus::PROOF_FILE_APPROVED->value)
                        ->color('success')
                        ->label('Confirmar com o Cliente')
                        ->requiresConfirmation()
                        ->url(fn (Order $record) => self::generateWhatsappCustomerConfirmation($record->customer->phone, $record->product->name, $record->customer->name, $record->date), true),
                    Tables\Actions\Action::make('confirm_schedule')
                        ->hidden(fn (Model $record) => $record->status !== OrderStatus::PROOF_FILE_APPROVED->value)
                        ->color('success')
                        ->label('Marcar como confirmado')
                        ->requiresConfirmation()
                        ->action(function (Action $action, Order $record) {
                            $record->status = OrderStatus::CONFIRMED;
                            $record->save();
                        }),
                    Tables\Actions\Action::make('cancel_schedule')
                        ->hidden(fn (Model $record) => $record->status !== OrderStatus::PROOF_FILE_APPROVED->value)
                        ->label('Cancelar Agendamento')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Order $record) {
                            $record->status = OrderStatus::CANCELLED;
                            $record->save();
                        }),
                    Tables\Actions\Action::make('cancel_customer_schedule')
                        ->hidden(fn (Model $record) => $record->status !== OrderStatus::CANCELLED->value)
                        ->label('Notificar Cancelamento do Agendamento')
                        ->url(fn (Order $record) => self::generateWhatsappCustomerCancel($record->customer->phone, $record->product->name, $record->customer->name, $record->date, $record->cancel_reason), true)
                        ->requiresConfirmation(),
                ])->label('Ações')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
        ];
    }

    private static function generateWhatsappCustomerConfirmation($phone, $productName, $customerName, $date)
    {
        $date = new DateTimeImmutable($date);

        $message = "Olá {$customerName}, esperamos que você esteja bem. Passando aqui para confirmar que " .
            "analisamos o comprovante de pagamento enviado e está tudo ok ref. ao agendamento do(a) {$productName} em" .
            "{$date->format('d/m/Y')} às {$date->format('h:i')} horas! Nos vemos lá.";

        $encodedMessage = urlencode($message);

        return "https://api.whatsapp.com/send/?phone=$phone&text=$encodedMessage";
    }

    private static function generateWhatsappCustomerCancel($phone, $productName, $customerName, $date, $reason)
    {
        $date = new DateTimeImmutable($date);
        $now = new DateTimeImmutable();

//      @todo Fazer validação e caso esteja dentro do prazo de reembolso inserir mensagem do reembolso.

        $message = "Olá {$customerName}, esperamos que você esteja bem. Infelizmente estou aqui para informar que " .
            "{$reason} e por este motivo será cancelado o agendamento do(a) {$productName} em " .
            "{$date->format('d/m/Y')} às {$date->format('h:i')} horas!";

        $encodedMessage = urlencode($message);

        return "https://api.whatsapp.com/send/?phone=$phone&text=$encodedMessage";
    }

}
