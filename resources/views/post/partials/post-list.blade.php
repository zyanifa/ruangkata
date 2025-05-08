<!-- filepath: d:\ruangkata\resources\views\post\partials\post-list.blade.php -->
@forelse ($posts as $p)
    <x-post-item :post="$p"></x-post-item>
@empty
    <div class="text-center text-gray-400 py-16">Tidak ada post</div>
@endforelse

{{ $posts->links() }}