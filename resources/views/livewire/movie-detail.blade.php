<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Movie Detail') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 mb-2">
        <div class="flex justify-between bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
            <div class="w-1/4">
                <img class="object-cover w-full rounded-t-lg md:rounded-none md:rounded-s-lg" src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" alt="">
            </div>
            <div class="w-3/4 flex flex-col p-7 leading-normal">
                <h5 class="mt-4 text-2xl font-bold text-gray-900">{{ $movie['title'] }}</h5>
                <div class="mt-4">
                    <strong class="pl-2">{{ $movie['release_date'] }}</strong>
                </div>
                <div class="flex mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FDCC0D" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                    </svg>
                    <strong class="pl-2 text-sm">{{ number_format($movie['vote_average'], 2) }}</strong>
                </div>
                <p class="mt-5 font-normal text-gray-700">
                    {{ $movie['overview'] }}
                </p>
                <div class="px-2 py-5 mt-5 border-t border-gray-200">
                    @foreach ($movie['genres'] as $genre)
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 font-semibold text-gray-700 mr-1 mb-2">{{ $genre['name'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
