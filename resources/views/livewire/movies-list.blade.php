<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Movies') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl flex justify-between mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <input type="text" wire:model.live.debounce.300ms="searchTerm" class="mt-2" placeholder="Search movies..." />
        <label for="genre" class="mt-2">
            {{ __('Genre') }}:
            <select wire:model.change="genre" class="mt-2">
                <option value="0">All</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre['title'] }}">{{ $genre['title'] }}</option>
                @endforeach
            </select>
        </label>
    </div>

    @if(session()->has('message'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" x-data="{ show: true }" x-show="show">
            <strong class="font-bold">{{ session('message') }}</strong>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
              <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
        </div>
     @endif

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 grid grid-cols-6 gap-4 mb-2">
        @forelse ($movies as $movie)
            <div wire:key="{{ $movie->id }}" class="mb-4 bg-white rounded shadow-lg flex flex-col justify-between">
                <div class="flex flex-col justify-between">
                    <a href="{{ route('movies.show', $movie->api_id) }}">
                        <img class="w-full" src="https://image.tmdb.org/t/p/w500/{{ $movie->image_url }}" alt="Sunset in the mountains">
                    </a>
                    <div class="px-3 py-4">
                        <div class="flex mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FDCC0D" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                            </svg>
                            <strong class="pl-2 text-sm">{{ $movie->rating }}</strong>
                        </div>

                        <div class="font-bold text-base mb-2">
                            <a href="{{ route('movies.show', $movie->api_id) }}">{{ $movie->title }}</a>
                        </div>
                        <p class="text-gray-700 text-sm">
                            {{ str($movie->description)->words(10) }}
                        </p>
                    </div>
                    <div class="px-2 pt-4 pb-2 border-t border-gray-200">
                        @foreach ($movie->genres as $genre)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mr-1 mb-2">{{ $genre->title }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="px-3 pt-4 pb-2 border-t border-gray-200">
                    <button wire:click="confirmEditMovie({{ $movie->id }})" class="inline-block bg-gray-600 rounded-md px-3 py-1 text-xs font-semibold text-white mr-1 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                            </svg>
                    </button>
                    <button wire:click="delete({{ $movie->id }})" wire:confirm="Are you sure you want to delete this movie ?" class="inline-block bg-red-600 rounded-md px-3 py-1 text-xs font-semibold text-white mr-1 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="max-w-7xl col-span-6 grid-flow-dense flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">No movies found</span> Please run the artisan command app:fetch-movies-and-genres to populate the database.
                </div>
            </div>
        @endforelse
    </div>

    @if($movies)
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            {{ $movies->links() }}
        </div>
    @endif

    {{-- Modal Section --}}
    <x-dialog-modal wire:model="showingEditModal">
        <x-slot name="title">
            Edit movie
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Title') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model="title" />
                <x-input-error for="title" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-label for="description" value="{{ __('Description') }}" />
                <textarea id="description" type="text" class="mt-1 block w-full" wire:model="description"></textarea>
                <x-input-error for="description" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showingEditModal', false)">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="update">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
