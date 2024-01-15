<form wire:submit.prevent="submit" class="max-w-xl p-8 mx-auto">
    {{ $this->form }}

    <x-forms::button class="mt-2" type="submit">
        Submit
    </x-forms::button>

    {{ var_dump($data) }}
</form>
