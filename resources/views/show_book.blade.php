@extends('layouts.app')
@section('title', $book['name'])
@section('content')

    <div class="container" style="width: 700px">
        <div class="book-details-card">
            <div class="book-cover">
                <img src="{{ $coverUrl }}" alt="Book Cover">
            </div>

            <div class="book-info">
                <h2 class="book-title">{{ $book["name"] }}</h2>
                <p class="author">{{ $book["author"] }}, <span>{{ $book["date_of_product"] }}</span></p>
                <p class="description">{{ $book["description"] }}</p>
                <p>Quantity: {{ $book["quantity"] }}</p>
                <p>Number Of Pages: {{ $book["quantity"] }}</p>
                
                <form action="{{ route('books.destroy', ['book' => $book['id']]) }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
                <a href="{{ route('books.edit', ['book' => $book['id']]) }}">
                    <button>edit</button>
                </a>
            </div>
        </div>
    </div>

@endsection
