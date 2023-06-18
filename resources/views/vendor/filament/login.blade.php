
<form wire:submit.prevent="authenticate" class="space-y-8">
    {{ $this->form }}

    <x-filament::button type="submit" form="authenticate" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <x-filament::link class="w-full text-center" href="{{ route('filament.auth.register') }}">@lang('filament::login.buttons.cancel.label')</x-filament::link>

</form>
