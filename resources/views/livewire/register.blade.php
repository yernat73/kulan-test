<form wire:submit.prevent="register" class="space-y-8">
    {{ $this->form }}


    <x-filament::button type="submit" form="register" class="w-full">
        {{ __('filament::register.buttons.submit.label') }}
    </x-filament::button>

    <x-filament::link class="w-full text-center" href="{{ route('filament.auth.login') }}">@lang('filament::register.buttons.cancel.label')</x-filament::link>

</form>