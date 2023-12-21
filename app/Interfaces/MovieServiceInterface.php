<?php

namespace App\Interfaces;

interface MovieServiceInterface
{
    public function fetchPopularMovies(): ?array;

    public function fetchGenres(): ?array;

    public function fetchMovieDetails(int $id): ?array;
}
