<?php

namespace App\Livewire;

use App\Interfaces\MovieServiceInterface;
use Livewire\Component;

class MovieDetail extends Component
{
    private $movieService;
    public $id;

    public function mount(MovieServiceInterface $movieService, $id)
    {
        $this->id = $id;
        $this->movieService = $movieService;
    }

    public function render()
    {
        $movie = $this->movieService->fetchMovieDetails($this->id);

        if(isset($movie['success']) && $movie['success'] === false) {
            abort(404);
        }

        return view('livewire.movie-detail', compact('movie'));
    }
}
