<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\Customer;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Resources\Pages\ManageRecords;

class ManageCustomer extends ManageRecords implements HasForms
{
    use InteractsWithFormActions;
    use InteractsWithForms;

    public ?array $data = [];

    protected static string $resource = CustomerResource::class;

    protected static string $view = 'filament.resources.customer-resource.pages.manage-customer';

    public function form(Form $form): Form
    {
        return $this::$resource::form($form)
            ->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label(__('filament-panels::resources/pages/create-record.form.actions.create.label'))
                ->submit('create')
                ->keyBindings(['mod+s']),
        ];
    }
    // public function form(Form $form): Form
    // {
    //     return $this::$resource::form($form)
    // }

    public function create(): void
    {
        Customer::create($this->form->getState());
    }
}
