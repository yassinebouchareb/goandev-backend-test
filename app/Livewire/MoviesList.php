<?php

namespace App\Livewire;

use App\Models\Genre;
use App\Models\Movie;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Popular Movies')]
class MoviesList extends Component
{
    #[Rule('required')]
    public $title;

    #[Rule('required')]
    public $description;

    public $currentMovie;
    public $showingEditModal = false;

    public $searchTerm = '';
    public $genre = '';

    public function delete(Movie $movie)
    {
        $movie->genres()->detach();
        $movie->delete();
        session()->flash('message', 'Movie deleted successfully.');
    }

    public function confirmEditMovie(Movie $movie)
    {
        $this->currentMovie = $movie;
        $this->title = $movie->title;
        $this->description = $movie->description;
        $this->showingEditModal = true;
    }

    public function update()
    {
        $this->validate();

        $this->currentMovie->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Movie updated successfully.');

        $this->showingEditModal = false;
        $this->reset();
    }

    public function render()
    {
        $movies = Movie::where(function($query) {
            if ($this->searchTerm) {
                $query->where('title', 'like', '%' .$this->searchTerm. '%');
            }
            if($this->genre) {
                $query->whereHas('genres', function($q) {
                    $q->where('title', $this->genre);
                });
            }
        });

        $movies = $movies->paginate(12);

        $genres = Genre::all();

        return view('livewire.movies-list', compact('movies', 'genres'));
    }

}
