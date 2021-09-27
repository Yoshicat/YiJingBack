<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Paginator
     */
    public function index(): Paginator
    {
        return Question::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Question
     */
    public function store(Request $request): Question
    {
        return Question::create([
            'question' => $request->question,
            'code' => $request->code,
            'user_id' => Auth::id()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Question
     */
    public function show(int $id): Question
    {
        return Question::where('user_id', Auth::id())->where('id', $id)->first();
    }

}
