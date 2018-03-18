<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Session;
use Yajra\Datatables\Datatables;

class Books extends Controller
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
        ];

        return view( "admin.books.books" )->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('admin/books');
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
            'name' => 'required|max:255',
            'note' => 'max:255',
        ]);
        
        $book = new Book();

        $book->name = $request->name;
        $book->note = $request->note;

        $book->save();
        
        Session::flash('message', 'Successfully created book!');
        
        return redirect('admin/books');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/books');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        
        $data = [
            'book'=>$book,
        ];

        return view('admin.books.edit')->with($data);
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
        $book = Book::find($id);
        
        $this->validate($request, [
            'name' => 'required|max:255',
            'note' => 'max:255',
        ]);

        $book->name = $request->name;
        $book->note = $request->note;
        $book->save();
        $book->touch();
        
        Session::flash('message', 'Successfully updated book!');
        return redirect('admin/books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        $book->active = !$book->active;
        $book->save();
        $book->touch();
        
        Session::flash('message', 'Successfully updated book!');

        return redirect('admin/books');
    }

    // datatables
    
    public function allBooks()
    {
        $books = Book::all();
        
        return Datatables::of($books)
            ->editColumn('active', function ($book) {
                return ($book->active) ? "Active" : "Disabled";
            })
            ->addColumn('action', function ($book) {
                $button = ($book->active) ? "Disable" : "Active";

                return '<a href="books/'.$book->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <form method="POST" action="books/'.$book->id.'" accept-charset="UTF-8" class="pull-right">
                            <input name="_method" type="hidden" value="DELETE">
                            ' . csrf_field() . '
                            <button type="subbmit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-remove"></i> ' . $button . '</button>
                        </form>'
                        ;
            })
            ->make(true);
    }

    // get lessons by book_id
    
    public function getLessons(Request $request)
    {
        $data = [
            "lessons" => Lesson::where("book_id", $request->book_id)->get(),
        ];

        return view('admin.books.lessons')->with($data)->render();
    }

}
