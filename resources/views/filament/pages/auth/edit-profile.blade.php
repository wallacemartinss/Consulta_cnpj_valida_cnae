<x-filament-panels::form.actions wire:submit="save">

{{$this->form}}

</x-filament-panels::form.actions
    :actions="$this->getCachedFormActions()"
    :full-width="$this->hasFullWidthFormActions()"
    alignment = "right"
    />
</x-filament-panels::form>
