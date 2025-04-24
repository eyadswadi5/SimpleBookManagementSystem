<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Image;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Psy\Readline\Hoa\FileException;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        $books = $books->map(function ($book) {
            return [
                "id" => $book->id,
                "name" => $book->name,
                "author" => $book->author,
                "date_of_production" => $book->date_of_production,
                "cover" => $book->cover->url,
            ];
        });

        return view("home", ["books" => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("add_book");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book-name' => 'required|string|unique:books,name|max:50',
            'author-name' => 'required|string|max:50',
            'production-date' => 'required',
            'number-of-pages' => 'required|integer|min:1|max:600',
            'quantity' => 'required|integer|min:1',
            'book-cover' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'book-description' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            $book = Book::create([
                "name" => $request->input("book-name"),
                "author" => $request->input("author-name"),
                "quantity" => $request->input("quantity"),
                "date_of_product" => $request->input("production-date"),
                "description" => $request->input("book-description"),
                "number_of_pages" => $request->input("number-of-pages"),
            ]);

            $file_name = $request->file("book-cover")->hashName();
            Storage::disk("public")->put("covers/", $request->file("book-cover"));
            Image::create([
                "book_id" => $book->id,
                "file_name" => $file_name,
                "path" => "covers/$file_name",
                "url" => asset("covers/$file_name"),
                "size" => $request->file("book-cover")->getSize(),
            ]);
            DB::commit();
            return to_route("books.index");
        } catch (QueryException $error) {
            DB::rollBack();
            return redirect()->back()
            ->withErrors(["exception" => "Failed to add new book, some database error occures"])
            ->withInput();
        } catch (FileException $error) {
            DB::rollBack();
            return redirect()->back()
            ->withErrors(["exception" => "Failed to add new book, some error occures when upload book cover"])
            ->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {   
        $coverUrl = $book->cover->url;
        return view("show_book", compact("coverUrl", "book"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $coverUrl = $book->cover->url;
        return view("edit_book", compact("coverUrl", "book"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'book-name' => 'required|string|unique:books,name|max:50',
            'author-name' => 'required|string|max:50',
            'production-date' => 'required',
            'number-of-pages' => 'required|integer|min:1|max:600',
            'quantity' => 'required|integer|min:1',
            'book-cover' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'book-description' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $book->name = $request->input("book-name");
            $book->author = $request->input("author-name");
            $book->quantity = $request->input("quantity");
            $book->date_of_product = $request->input("production-date");
            $book->description = $request->input("book-description");
            $book->number_of_pages = $request->input("number-of-pages");
            DB::beginTransaction();
            $book->save();
            DB::commit();
            if ($request->hasFile("book-cover")) {
                $coverPath = $book->cover->path;
                $book->cover->delete();
                if (Storage::disk("public")->exists($coverPath))
                    Storage::disk("public")->delete($coverPath);
                $file_name = $request->file("book-cover")->hashName();
                Storage::disk("public")->put("covers/", $request->file("book-cover"));
                Image::create([
                    "book_id" => $book->id,
                    "file_name" => $file_name,
                    "path" => "covers/$file_name",
                    "url" => asset("covers/$file_name"),
                    "size" => $request->file("book-cover")->getSize(),
                ]);
            }
            return to_route("books.index");
        } catch (QueryException $error) {
            DB::rollBack();
            return redirect()->back()
            ->withErrors(["exception" => "Failed to update the book, some database error occures"])
            ->withInput();
        } catch (FileException $error) {
            DB::rollBack();
            return redirect()->back()
            ->withErrors(["exception" => "Failed to update new book cover"])
            ->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            DB::beginTransaction();
            $coverPath = $book->cover->path;
            $book->cover->delete();
            $book->delete();
            if (Storage::disk("public")->exists($coverPath))
                Storage::disk("public")->delete($coverPath);
            DB::commit();
            return to_route("books.index");
        } catch (QueryException $error) {
            DB::rollBack();
            return redirect()->back()
            ->withErrors(["exception" => "Failed to delete the book, some database error occures"])
            ->withInput();
        } catch (FileException $error) {
            DB::rollBack();
            return redirect()->back()
            ->withErrors(["exception" => "Failed to delete the book, some error occures when deleting book cover"])
            ->withInput();
        }
    }
}
