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

    {{-- form to remove a book --}}
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

    {{-- button to activate the add book form --}}
    <flux:button variant="primary" wire:click="formOpen()">{{ __('Create') }}</flux:button>
    
    {{-- Form create/edit --}}
    <flux:modal name="form" class="md:w-96">
        <form class="space-y-6" wire:submit="save">
            <div>
                <flux:heading size="lg">@if(!is_null($id)){{ __("Edit book") }}@else{{ __("Create book") }}@endif</flux:heading>
            </div>

            <flux:field>
                <flux:input label="Title" placeholder="{{ __('title') }}" wire:model="title" />
            </flux:field>
    
            <flux:field>
                <flux:input label="Author" placeholder="{{ __('author') }}" wire:model="author" />
            </flux:field>

            <flux:field>
                <flux:input label="Editorial" placeholder="{{ __('Editorial') }}" wire:model="editorial" />
            </flux:field>

            <flux:field>
                <flux:input label="Year of publication" placeholder="{{ __('Year of publication') }}" wire:model="yearPublication" />
            </flux:field>

            <flux:field>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                <select multiple class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model="categories">
                    @foreach ($dataCategories as $category)
                        <option value="{{$category->id}}"  @if(in_array($category->id, $categories)) selected @endif>{{$category->name}}</option>
                    @endforeach
                </select>
            </flux:field>

            <div class="flex">
                <flux:spacer />
    
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- table to display books--}}
    <div class="relative py-4 overflow-x-auto shadow-md sm:rounded-lg">
        <div class="pb-4 bg-white dark:bg-gray-900">
            <label for="table-search" class="sr-only">{{ __('Search') }}</label>


            <div class="columns-3">

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

                <select 
                    id="statusBook" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-50 p-4 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    wire:model.live="searchRead" >
                        <option value="all" selected>{{ __('Choose a status') }}</option>
                        <option value="0">{{ __('Not read') }}</option>
                        <option value="1">{{ __('Read') }}</option>
                </select>

                <select 
                    id="categoryBook" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-50 p-4 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    wire:model.live="searchCategory" >
                        <option value="all" selected>{{ __('Choose a category') }}</option>
                        @foreach ($dataCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                </select>
            
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" wire:click="doSort('id')" >
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="id" />
                    </th>
                    <th scope="col" class="px-6 py-3" wire:click="doSort('title')" >
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="title" />
                    </th>
                    <th scope="col" class="px-6 py-3" wire:click="doSort('author')" >
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="author" />
                    </th>
                    <th scope="col" class="px-6 py-3" wire:click="doSort('editorial')" >
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="editorial" />
                    </th>
                    <th scope="col" class="px-6 py-3" wire:click="doSort('year_publication')" >
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="year_publication" />
                    </th>
                    <th scope="col" class="px-6 py-3"  >
                        {{ __('Categories') }}
                    </th>
                    <th scope="col" class="px-6 py-3" wire:click="doSort('read')" >
                        {{ __('Status') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{$book->id}}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$book->title}}
                        </th>
                        <td class="px-6 py-4">
                            {{$book->author}}
                        </td>
                        <td class="px-6 py-4">
                            {{$book->editorial}}
                        </td>
                        <td class="px-6 py-4">
                            {{$book->year_publication}}
                        </td>
                        <td class="px-6 py-4">
                            @foreach($book->categories as $category)
                            {{$category->name}}@if(!$loop->last){{ ', ' }}@endif
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            <flux:badge color="@if($book->read==1){{ 'lime' }}@else{{ 'zinc' }}@endif" wire:click="changeStatus({{$book->id}})">
                                @if($book->read==1){{ __('Read') }}@else{{ __('Not Read') }}@endif
                            </flux:badge>
                        </td>
                        <td class="px-6 py-4">
                            <flux:button variant="primary" size="sm" wire:click="formOpen({{$book->id}})">{{ __('Edit') }}</flux:button>
                            <flux:button variant="danger" size="sm" wire:click="selectId({{$book->id}})">{{ __('Delete') }}</flux:button>
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
        {{$books->links()}}
    </div>
</div>
