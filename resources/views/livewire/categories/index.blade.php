<div>
    {{-- Toast to confirm deletion --}}
    @if (session()->has('msg'))
        <div id="toast-simple" class="flex   fixed top-5 right-5   items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            <div class="ps-4 text-sm font-normal">{{ __(session('msg')) }}</div>
        </div>
    @endif

    {{-- form to remove a category --}}
    <flux:modal name="form-r" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __("Delete item ?") }}</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete this record {{$recordId}}.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" wire:click="deleteRecord()" variant="danger">Delete record</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- button to activate the add category form --}}
    <flux:button variant="primary" wire:click="formOpen()">{{ __('Create') }}</flux:button>
    
    {{-- Form create/edit --}}
    <flux:modal name="form" class="md:w-96">
        <form class="space-y-6" wire:submit="save">
            <div>
                <flux:heading size="lg">@if(!is_null($id)){{ __("Edit category") }}@else{{ __("Create category") }}@endif</flux:heading>
            </div>

            <flux:field>
                <flux:input label="Name" placeholder="{{ __('name') }}" wire:model="name" />
            </flux:field>
    
            <flux:field>
                <flux:textarea label="{{ __('Description') }}" placeholder="{{ __('description') }}" resize="none" wire:model="description" />
            </flux:field>

            <div class="flex">
                <flux:spacer />
    
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- table to display categories--}}
    <div class="relative py-4 overflow-x-auto shadow-md sm:rounded-lg">
        <div class="pb-4 bg-white dark:bg-gray-900">
            <label for="table-search" class="sr-only">{{ __('Search') }}</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" 
                        id="table-search" 
                        class="block p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Search for items"
                        wire:model.live.debounce.300ms="search" />
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" wire:click="doSort('name')" >
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="name" />
                    </th>
                    <th scope="col" class="px-6 py-3" wire:click="doSort('description')" >
                        {{ __('Description') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$category->name}}
                        </th>
                        <td class="px-6 py-4">
                            {{$category->description}}
                        </td>
                        <td class="px-6 py-4">
                            <flux:button variant="primary" size="sm" wire:click="formOpen({{$category->id}})">{{ __('Edit') }}</flux:button>
                            <flux:button variant="danger" size="sm" wire:click="selectId({{$category->id}})">{{ __('Delete') }}</flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="py-4 px-3">
        <div class="flex">
            <div class="flex space-x-4 items-center mb-3">
                <label for=""> {{ __("Per page")}}
                    <select wire:model.live="perPage">
                    <option value="3">3</option>
                    <option value="6">6</option>
                    <option value="9">9</option>
                    </select>
                </label>
            </div>
        </div>
        {{$categories->links()}}
    </div>
</div>
