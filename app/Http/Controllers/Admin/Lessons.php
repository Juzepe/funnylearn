<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Session;
use Yajra\Datatables\Datatables;

class Lessons extends Controller
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

        return view( "admin.lessons.lessons" )->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('admin/lessons');
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
            'book_id' => 'required',
            'name' => 'required|max:255',
        ]);
        
        $lesson = new Lesson();

        $lesson->book_id = $request->book_id;
        $lesson->name = $request->name;

        $lesson->save();
        
        Session::flash('message', 'Successfully created lesson!');
        
        return redirect('admin/lessons');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/lessons');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $books = Book::orderBy('name', 'asc')->get()->mapWithKeys(function ($book) {
            return [$book['id'] => $book['name']];
        })->toArray();

        $data = [
            'lesson' => Lesson::find($id),
            'books' => $books,
        ];

        return view('admin.lessons.edit')->with($data);
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
        $lesson = Lesson::find($id);
        
        $this->validate($request, [
            'book_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $lesson->book_id = $request->book_id;
        $lesson->name = $request->name;
        $lesson->save();
        $lesson->touch();
        
        Session::flash('message', 'Successfully updated lesson!');
        return redirect('admin/lessons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lesson = Lesson::find($id);

        $lesson->active = !$lesson->active;
        $lesson->save();
        $lesson->touch();
        
        Session::flash('message', 'Successfully updated lesson!');

        return redirect('admin/lessons');
    }

    // datatables
    
    public function allLessons()
    {
        $lessons = Lesson::with("book")->get();
        
        return Datatables::of($lessons)
            ->editColumn('active', function ($lesson) {
                return ($lesson->active) ? "Active" : "Disabled";
            })
            ->addColumn('action', function ($lesson) {
                $button = ($lesson->active) ? "Disable" : "Active";

                return '<a href="lessons/'.$lesson->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <form method="POST" action="lessons/'.$lesson->id.'" accept-charset="UTF-8" class="pull-right">
                            <input name="_method" type="hidden" value="DELETE">
                            ' . csrf_field() . '
                            <button type="subbmit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-remove"></i> ' . $button . '</button>
                        </form>'
                        ;
            })
            ->make(true);
    }
}
