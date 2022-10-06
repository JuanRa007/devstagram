<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{

    // Este atributo (variable) ya está disponible en la vista {view('livewire.like-post')},
    // no habría que pasarla como en las otras vistas.
    public $post;
    public $isLiked;
    public $likes;


    public function mount($post)
    {
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        if ($this->post->checkLike(auth()->user())) {
            // dd('Eliminando LIKE');
            // $request NO EXISTE en LIVEWIRE
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->isLiked = false;
            $this->likes--;
        } else {
            // dd($post->id);
            // dd($request->user()->id);
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
