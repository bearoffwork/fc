<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use App\Models\Probe;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationLabel = '客戶管理';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make('add customer')
                    ->schema([
                        TextInput::make('company_name'),
                        TextInput::make('company_phone'),
                        TextInput::make('company_address'),
                        Select::make('probes')
                            ->relationship()
                            ->allowHtml()
                            ->getOptionLabelFromRecordUsing(fn(Probe $record) => new HtmlString("
                                <div>{$record->probe_id}</div>
                                <div>{$record->type}</div>
                            "))
                            ->multiple()
                            ->preload()
                            ->default(null)
                            ->createOptionForm([
                                TextInput::make('probe_id')
                                    ->default(Str::random()),
                                TextInput::make('type')
                                    ->required(),
                            ]),
                        // Repeater::make('probe')
                        //     ->relationship('probes')
                        //     ->schema([
                        //         TextInput::make('probe_id')->default(Str::random()),
                        //         TextInput::make('type'),
                        //     ]),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('company_name')
                    ->searchable(),
                TextColumn::make('company_phone')
                    ->searchable(),
                TextColumn::make('company_address')
                    ->searchable(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
