<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text"  autocomplete="form.name" placeholder="Name"/>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>