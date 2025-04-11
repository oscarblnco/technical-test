<div class="flex items-center">
    {{ __($columnName) }}
    @if ($sortColumn !== $columnName)
    <flux:icon.chevron-up-down class="w-6 h-6 ms-2" />
    @elseif($sortDirection ==='ASC')
        <flux:icon.chevron-down class="w-3 h-6 ms-2" />
    @else
        <flux:icon.chevron-up class="w-3 h-6 ms-2" />
    @endif
</div>