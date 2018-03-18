<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Lesson;
use App\Models\Word;
use Illuminate\Http\Request;
use Session;
use Yajra\Datatables\Datatables;

class Words extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( App::isLocale('ka') ) $langLink = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Georgian.json";
        else $langLink = "//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json";

        $data = [
            'langLink' => $langLink,
            'books' => Book::orderBy('name', 'asc')->get(),
        ];

        return view( "admin.words.words" )->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('admin/words');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'lesson_id' => 'required',
        ]);

        foreach ($request->words as $key => $value) {
            if (empty($value) || empty($request->meanings[$key])) continue;

            $word = new Word();

            $word->lesson_id = $request->lesson_id;
            $word->word = $value;
            $word->meaning = $request->meanings[$key];

            $word->save();
        }
        
        Session::flash('message', 'Successfully created words!');
        
        return redirect('admin/words');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/words');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $books = Book::orderBy('name', 'asc')->get();

        $word = Word::with("lesson")->find($id);

        $lessons = Lesson::where("book_id", $word->lesson->book_id)->orderBy('name', 'asc')->get();

        $data = [
            'word' => $word,
            'lessons' => $lessons,
            'books' => $books,
        ];

        return view('admin.words.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $word = Word::find($id);
        
        $this->validate($request, [
            'lesson_id' => 'required',
            'word' => 'required|max:255',
            'meaning' => 'required|max:255',
        ]);

        $word->lesson_id = $request->lesson_id;
        $word->word = $request->word;
        $word->meaning = $request->meaning;
        $word->save();
        $word->touch();
        
        Session::flash('message', 'Successfully updated word!');
        return redirect('admin/words');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Word::whereId($id)->delete();

        Session::flash('message', 'Successfully deleted the word!');
        return redirect('admin/words');
    }

    // datatables
    
    public function allWords()
    {
        $words = Word::with("lesson.book")->get();
        
        return Datatables::of($words)
            ->addColumn('action', function ($word) {
                return '<a href="words/'.$word->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <form method="POST" action="words/'.$word->id.'" accept-charset="UTF-8" class="pull-right">
                            <input name="_method" type="hidden" value="DELETE">
                            ' . csrf_field() . '
                            <button type="subbmit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-remove"></i> Delete</button>
                        </form>'
                        ;
            })
            ->make(true);
    }
}
