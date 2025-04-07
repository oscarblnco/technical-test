<div class="flex items-center">
    {{ __($columnName) }}
    @if ($sortColumn !== $columnName)
    <x-fluentui-chevron-up-down-16  class="w-6 h-6" />
    @elseif($sortDirection ==='ASC')
        <x-tni-down-small-o class="w-6 h-6" />
    @else
        <x-tni-up-small-o class="w-6 h-6" />
    @endif
</div>