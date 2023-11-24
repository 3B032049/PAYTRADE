<?php

namespace App\Livewire\Shopping;

use Livewire\Component;
use App\Models\Product;

class Index extends Component
{
    public function render()
    {
        return view('livewire.shopping.index',[
            'list' => Product::all(),
        ]);
    }
}
