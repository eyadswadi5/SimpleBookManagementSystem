@extends("layouts.app")
@section("title", "new book")

@section("content")
<div class="container">
    <p class="title">Add Book</p>
    <form class="form-group" method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
    @csrf
        <div class="tiny-form-group">
            <input type="text" name="book-name" placeholder="Book Name">
            <input type="text" name="author-name" placeholder="Author Name">
        </div>
        @error('book-name')
                <div class="invalid-feedback"> - {{ $message }}</div>
        @enderror
        @error('author-name')
                <div class="invalid-feedback"> - {{ $message }}</div>
        @enderror
        <div class="tiny-form-group">
            <input type="date" name="production-date" placeholder="Production date">
            <input type="number" name="number-of-pages" min="1" max="600" placeholder="Number of pages">
            <input type="number" name="quantity" min="1" placeholder="Quantity">
        </div>
        @error('production-date')
                <div class="invalid-feedback"> - {{ $message }}</div>
        @enderror
        @error('number-of-pages')
                <div class="invalid-feedback"> - {{ $message }}</div>
        @enderror
        @error('quantity')
                <div class="invalid-feedback"> - {{ $message }}</div>
        @enderror
        <div style="margin: 10px 0px;">
            <div class="file-input-container">
                <label for="bookCover" class="file-input-label">
                    <span>Drag & drop your book cover here or <span class="browse-text">browse</span></span>
                    <span class="file-name" id="fileName">No file selected</span>
                </label>
                <input type="file" id="bookCover" name="book-cover" class="file-input" accept="image/*">
            </div>
            <div class="preview-container">
                <img id="previewImage" class="preview-image" alt="Book cover preview">
            </div>
        </div>
        @error('book-cover')
                <div class="invalid-feedback"> - {{ $message }}</div>
        @enderror
        <textarea name="book-description" placeholder="Book Description"></textarea>
        @error('book-description')
                <div class="invalid-feedback"> - {{ $message }}</div>
        @enderror
        @if ($errors->has("exception"))
            <div class="invalid-feedback"> - {{ $errors->first('exception') }}</div>
        @endif
        <button type="submit" class="btn">Add Book</button>

    </form>
</div>
@endsection