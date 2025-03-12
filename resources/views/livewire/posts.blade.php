<div>
    <flux:modal.trigger name="create-post">
    <flux:button class="cursor-pointer">Create post</flux:button>
    </flux:modal.trigger>

    <livewire:post-create/>
    <livewire:post-edit/>
    
    <flux:modal name="delete-post" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete post?</flux:heading>

            <flux:subheading>
                <p>You're about to delete this post.</p>
                <p>This action cannot be reversed.</p>
            </flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost" class="cursor-pointer">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger" wire:click="destroy()" class="cursor-pointer">Delete post</flux:button>
        </div>
    </div>
    </flux:modal>
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Body</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
              
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($posts as $post )
                
            
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-700">{{ $post->id }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $post->title }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $post->body }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">
                    <flux:button variant="primary" size="sm" wire:click="edit({{$post->id}})" class="cursor-pointer">Edit</flux:button>
                    <flux:button variant="danger" size="sm" wire:click="delete({{$post->id}})" class="cursor-pointer">Delete</flux:button>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>

</div>
