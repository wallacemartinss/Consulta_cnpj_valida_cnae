<div
    id="{{ $record->getKey() }}"
    wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
    class="record bg-white dark:bg-gray-700 rounded-lg px-4 py-2 cursor-grab font-medium text-gray-600 dark:text-gray-200"
    @if($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}) < 3)
        x-data
        x-init="
            $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')
            $el.classList.remove('bg-white', 'dark:bg-gray-700')
            setTimeout(() => {
                $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')
                $el.classList.add('bg-white', 'dark:bg-gray-700')
            }, 3000)
        "
    @endif
>

<div class="flex justify-between">
    {{ $record['title']}}
    @if ($record['urgent'])
        <x-heroicon-s-star class="inline-block text-primary-500 w-4 h-4"/>
    @endif

</div>
    <div class="text-xs text-right text-gray-400">{{$record['owner']}} <div>
</div>

<div class="text-xs text-gray-400 border-l mt-2 mb-2">

    {{ $record['description'] }}

</div>

<div class="flex -space-x-2">

    @foreach ( $record['team'] as $member )

    <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-primary-500">


    </div>
        
    @endforeach
    
</div>

</div>

<div class="mt-2 relative">
    <div class="absolute h-1 bg-primary-500" rounded-full style="width: {{ $record['progress'] }}%"></div>
    <div class="h-1 bg-gray-200" rounded-full></div>

</div>
  
</div>
