<div>
    <flux:modal name="edit-post" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Edit document</flux:heading>
            <flux:subheading>Edit details for the document</flux:subheading>
        </div>

        <flux:input wire:model="title" label="Title" placeholder="Your title" />

        <flux:textarea wire:model="body" label="Body" placeholder="Your body" />

        <div class="flex">
            <flux:spacer />

            <flux:button type="submit" variant="primary" wire:click="update" class="cursor-pointer">Update</flux:button>
        </div>
    </div>
    </flux:modal>
</div>
