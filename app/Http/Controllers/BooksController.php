<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Validator;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::where('user_id', Auth::user()->id)->orderBy('published','desc')->paginate(4);
        return view('books', ['books' => $books]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required | min:3 | max:100',
            'item_purchase' => 'required | numeric',
            'item_amount' => 'required | numeric | between:1000,4000',
            'published' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/books')->withInput()->withErrors($validator);
        }
        $book = new Book;
        $book->item_name     = $request->item_name;
        $book->item_purchase = $request->item_purchase;
        $book->item_amount   = $request->item_amount;
        $book->user_id       = Auth::user()->id;
        $book->published     = $request->published;
        $book->save();

        $request->session()->flash('success', 'データを追加しました');

        return redirect('/');
    }

    public function edit($book_id)
    {
        $book = Book::where('user_id', Auth::user()->id)->find($book_id);
        return view('books.edit',['book' => $book]);
    }

    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required | min:3 | max:100',
            'item_purchase' => 'required | numeric',
            'item_amount' => 'required | numeric | between:1000,4000',
            'published' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/books/' . $book->id)->withInput()->withErrors($validator);
        }

        $book->item_name     = $request->item_name;
        $book->item_purchase = $request->item_purchase;
        $book->item_amount   = $request->item_amount;
        $book->user_id       = Auth::user()->id;
        $book->published     = $request->published;
        $book->save();

        $request->session()->flash('update', 'データを編集しました');

        return redirect('/');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/');
    }

    public function show(Book $book)
    {
        return view('show', ['book' => $book]);
    }
}
