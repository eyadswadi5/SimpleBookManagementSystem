@extends("layouts.app")
@section("title", "Home")

@section("content")
<div class="container-lg">
    <p class="title">Our Books</p>
    <div class="books-container">
        @foreach ($books as $book)
            <div class="book-card">
                <div class="book-cover-img">
                    <img src="{{ asset($book['cover']) }}" alt="book-cover">
                </div>
                <div class="book-details">
                    <p>{{ $book['name'] }}</p>
                    <p>{{ $book['author'] }}</p>
                    <p>{{ $book['date_of_production'] }}</p>
                    <a href="{{ route('books.show', ['book' => $book['id']]) }}">Details</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection