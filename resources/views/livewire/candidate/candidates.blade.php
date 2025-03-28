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
        <table class="min-w-full divide-y divide-gray-200 border  rounded-lg">
          <thead class="">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File url</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
              
            </tr>
          </thead>
          <tbody class=" divide-y divide-gray-200">
            @foreach ($candidates as $candidate )
                
            
              <tr class="">
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-white">{{ $candidate->id }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-white">{{ $candidate->name }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-white">{{ $candidate->email }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-white">
                  @if ($candidate->cv_file)
                      <a href="{{ Storage::url($candidate->cv_file) }}" target="_blank">View PDF</a>
                  @endif

              </td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-white">
                    <flux:button variant="primary" size="sm" wire:click="edit({{$candidate->id}})" class="cursor-pointer">Edit</flux:button>
                    <flux:button variant="danger" size="sm" wire:click="delete({{$candidate->id}})" class="cursor-pointer">Delete</flux:button>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>

</div>
