<?php

namespace App\Services;

use App\Interfaces\MovieServiceInterface;
use Illuminate\Support\Facades\Http;

class TMDBService implements MovieServiceInterface
{
    /**
     * Get popular movies from the TMDB API.
     *
     * @return array An array of movies.
     * @throws \Throwable When an error occurs while fetching the movies.
     */
    public function fetchPopularMovies(): ?array
    {
        try {
            $movies = Http::withToken(config('services.tmdb.api_key'))
                ->get(config('services.tmdb.base_url') . 'movie/popular')
                ->json('results');

            return $movies;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Fetches the genres from the TMDB API.
     *
     * @throws \Throwable if an error occurs during the API request.
     * @return array an array of genres.
     */
    public function fetchGenres(): ?array
    {
        try {
            $genres = Http::withToken(config('services.tmdb.api_key'))
                ->get(config('services.tmdb.base_url') . 'genre/movie/list')
                ->json('genres');

            return $genres;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Fetches the details of a movie.
     *
     * @param int $id The ID of the movie.
     * @throws \Throwable If an error occurs while fetching the movie details.
     * @return array The movie details as an array.
     */
    public function fetchMovieDetails(int $id): ?array
    {
        try {
            $movie = Http::withToken(config('services.tmdb.api_key'))
                ->get(config('services.tmdb.base_url') . 'movie/' . $id)
                ->json();

            return $movie;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
