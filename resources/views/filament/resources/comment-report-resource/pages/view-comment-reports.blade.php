<x-filament::page>
    <x-filament::card>
        <div class="space-y-2">
            <div class="flex justify-between">
                <h3 class="text-lg font-medium">Comment Information</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-2">
                    <span class="font-medium">Content:</span> {{ $this->record->content }}
                </div>
                <div>
                    <span class="font-medium">Author:</span> {{ $this->record->user->name }}
                </div>
                <div>
                    <span class="font-medium">Date:</span> {{ $this->record->created_at->format('M d, Y H:i') }}
                </div>
                <div>
                    <span class="font-medium">Post:</span> {{ $this->record->post->title }}
                </div>
                <div>
                    <span class="font-medium">Reports:</span> {{ $this->record->reports()->count() }}
                </div>
            </div>
        </div>
    </x-filament::card>
    
    <div class="mt-4">
        {{ $this->table }}
    </div>
</x-filament::page>