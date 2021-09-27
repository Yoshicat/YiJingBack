<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hexagram;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HexagramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Hexagram::all()->each(function ($item) {
            $item->id -= 1;
            return $item;
        });
    }

}
