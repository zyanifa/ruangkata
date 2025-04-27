<x-filament::page>
    <x-filament::card>
        <div class="space-y-2">
            <div class="flex justify-between">
                <h3 class="text-lg font-medium">Informasi Postingan</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="font-medium">Judul:</span> {{ $this->record->title }}
                </div>
                <div>
                    <span class="font-medium">Penulis:</span> {{ $this->record->user->name }}
                </div>
                <div>
                    <span class="font-medium">Dipublikasikan pada:</span> 
                    @if($this->record->published_at)
                    {{ \Carbon\Carbon::parse($this->record->published_at)->format('d M Y, H:i') }}
                    @else
                        Draft
                    @endif
                </div>
                <div>
                    <span class="font-medium">Jumlah Laporan:</span> {{ $this->record->reports()->count() }}
                </div>
            </div>
        </div>
    </x-filament::card>
    
    <div class="mt-4">
        {{ $this->table }}
    </div>
</x-filament::page>