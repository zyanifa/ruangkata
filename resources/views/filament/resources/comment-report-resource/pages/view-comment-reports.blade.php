<x-filament::page>
    <x-filament::card>
        <div class="space-y-2">
            <div class="flex justify-between">
                <h3 class="text-lg font-medium">Informasi Komentar</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-2">
                    <span class="font-medium">Isi Komentar:</span> {{ $this->record->content }}
                </div>
                <div>
                    <span class="font-medium">Pembuat:</span> {{ $this->record->user->name }}
                </div>
                <div>
                    <span class="font-medium">Dibuat Pada:</span> {{ $this->record->created_at->format('d M Y, H:i') }}
                </div>
                <div>
                    <span class="font-medium">Judul Postingan:</span> {{ $this->record->post->title }}
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