<?php

namespace App\Http\Livewire;

use App\Models\City;
use Filament\Facades\Filament;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

/**
 * @property ComponentContainer $form
 */
class Register extends Component implements HasForms
{
    use InteractsWithForms;

    public $email = '';

    public $name = '';

    public $password = '';

    public $city_id = null;

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function register()
    {
        $user = Role::query()
            ->where('name', 'user')
            ->firstOrFail()
            ->users()
            ->create($this->form->getState());

        Filament::auth()->login($user);

        return redirect()->intended(Filament::getUrl());
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('filament::register.fields.name.label'))
                ->string()
                ->maxLength(255)
                ->required(),

            TextInput::make('email')
                ->label(__('filament::register.fields.email.label'))
                ->string()
                ->maxLength(255)
                ->email()
                ->unique('users', 'email')
                ->required()
                ->autocomplete(),

            Select::make('city_id')
                ->options(City::query()->pluck('name', 'id'))
                ->required()
                ->exists('cities', 'id')
                ->label(__('filament::register.fields.city.label')),

            TextInput::make('password')
                ->label(__('filament::register.fields.password.label'))
                ->string()
                ->maxLength(255)
                ->password()
                ->confirmed()
                ->required()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state)),

            TextInput::make('password_confirmation')
                ->label(__('filament::register.fields.password_confirmation.label'))
                ->string()
                ->maxLength(255)
                ->password()
                ->required()
                ->dehydrated(false),
        ];
    }

    public function render(): View
    {
        return view('livewire.register')
            ->layout('filament::components.layouts.card', [
                'title' => __('filament::register.title'),
            ]);
    }
}
