<?php

namespace App\Console\Commands;

use App\Interfaces\MovieServiceInterface;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Console\Command;

class FetchMoviesAndGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-movies-and-genres {--M|movies}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch movies or genres from TMDB API and store in database';

    public function __construct(
        protected MovieServiceInterface $movieService
    ){
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $defaultChoice = $this->options('movies');

        $key = 1;

        if(!$defaultChoice['movies']) {
            $choices = [
                1 => 'Fetch movies from TMDB',
                2 => 'Fetch genres from TMDB',
            ];

            $this->info('The first time you run this command, fetch the genres first.');
            $choice = $this->choice('What do you want to do?', $choices, 1);
            $key    = array_search($choice, $choices);
        }

        switch ($key) {
            case 1: //tmdb - fetch movies
                $this->fetchMovies();
                break;

            case 2: //tmdb - fetch genres
                $this->fetchGenres();
                break;
        }

        $this->info('Done!');
    }

    /**
     * Fetches movies from the movie service and updates or creates movie records in the database.
     * @return void
     */
    private function fetchMovies(): void
    {
        // Fetch genres from TMDB API if there are no genres in the database
        if(Genre::count() == 0) {
            $this->info('No genres found in database. Fetching genres from TMDB API...');
            $this->fetchGenres();
        }

        // Fetch movies from TMDB API
        $this->info('Fetching movies from TMDB API...');
        $movies = $this->movieService->fetchPopularMovies();

        foreach($movies as $apiMovie) {
            $movie = Movie::updateOrCreate(
                ['api_id' => $apiMovie['id']],
                [
                    'title'         => $apiMovie['title'],
                    'description'   => $apiMovie['overview'],
                    'image_url'     => $apiMovie['poster_path'],
                    'rating'        => $apiMovie['vote_average'],
                    'release_date'  => $apiMovie['release_date'],
                    'from_api'      => true
                ]
            );

            // Attach genres to movie
            $movie->genres()->syncWithoutDetaching($apiMovie['genre_ids']);
        }
    }

    /**
     * Fetches genres from TMDB API and updates the database.
     * @return void
     */
    private function fetchGenres(): void
    {
        // Fetch genres from TMDB API
        $this->info('Fetching genres from TMDB API...');
        $genres = $this->movieService->fetchGenres();

        foreach($genres as $genre) {
            Genre::updateOrCreate(
                [
                    'id' => $genre['id']
                ],
                [
                    'id'    => $genre['id'],
                    'title' => $genre['name'],
                ]
            );
        }
    }
}
