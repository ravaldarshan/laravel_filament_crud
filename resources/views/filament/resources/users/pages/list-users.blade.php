{{-- <div class="center">
    <h1>Custum page</h1>
</div> --}}
<div class="py-2 px-5">
    @foreach ($records as $record)
        <div>
            <div>{{ $record->email }}</div>
            <div class="text-xs italic">-{{ $record->name }}</div>
        </div>
        <hr>
    @endforeach
</div>
