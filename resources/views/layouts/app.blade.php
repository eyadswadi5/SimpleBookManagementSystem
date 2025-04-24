<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System - @yield("title")</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="navbar-container">
        <a href="{{ route('books.index') }}">Home</a>
        <a href="{{ route('books.create') }}">New Book</a>
    </div>

    @yield("content")

</body>
</html>