<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\ProductCategory;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Ramsey\Uuid\Uuid;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->label('Categoria')
                    ->options(ProductCategory::pluck('name', 'id')),
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(250),
                TextInput::make('sufix')
                    ->label('Sufixo')
                    ->default('Cada')
                    ->maxLength(100),
                TextInput::make('amount')
                    ->label('Custo')
                    ->reactive()
                    ->afterStateUpdated(function (TextInput $component,  ?string $state) {
                        if (!$state) {
                            return;
                        }
                        $state = preg_replace("/[^0-9]/", "", $state);
                        $component->state(number_format($state / 100, 2, ',', '.'));
                    })
                    ->required(),
                Textarea::make('description')
                    ->label('Descrição do Produto')
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('images')
                    ->multiple()
                    ->directory('products')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->required()
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uuid'] = Uuid::uuid4()->toString();
        $data['images'] = array_map(
            fn ($fileName) => explode('/app/',
                storage_path($fileName))[1], $data['images']
        );

        $data['amount'] = preg_replace("/[^0-9]/", "", $data['amount']);
        return parent::mutateFormDataBeforeCreate($data);
    }
}
