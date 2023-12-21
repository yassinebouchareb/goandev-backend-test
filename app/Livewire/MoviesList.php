<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Popular Movies')]
class MoviesList extends Component
{
    public function delete(Movie $movie)
    {
        dd($movie);
    }

    public function render()
    {
        return view('livewire.movies-list', [
            'movies' => Movie::paginate(12),
        ]);
    }
}
