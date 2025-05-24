@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('pages.create') }}" class="btn">Create New Page</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>URL</th>
                </tr>
            </thead>
            @foreach ($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td><a href="{{ $page->url }}">Link</a></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
