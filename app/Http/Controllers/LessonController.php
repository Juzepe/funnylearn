<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Word;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    /**
     * Display possible activities.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('lessons/index')->with([
            "lesson" => Lesson::find($id),
        ]);
    }

    /**
     * Display possible activities.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function words($id)
    {
        return view('lessons/words')->with([
            "lesson" => Lesson::find($id),
            "words" => Word::inRandomOrder()->get(),
        ]);
    }

}
