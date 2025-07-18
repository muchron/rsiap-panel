<div>
    {{-- <div class="aspect-w-16 aspect-h-9">
        <img src="{{ Storage::url($image) }}" alt="{{ $image }}" class="object-cover rounded-lg shadow-lg dark:shadow-[0px_0px_0px_1px_#fffaed2d]">
    </div> --}}

    {{-- <div class="w-100 h-20 overflow-hidden rounded-lg shadow-lg dark:shadow-[0px_0px_0px_1px_#fffaed2d]"> --}}
    <img src="{{ Storage::url($image) }}" alt="{{ $image }}" class="w-96 h-48 object-none">
    {{-- </div> --}}
</div>
