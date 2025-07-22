@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-heading is-flex is-justify-content-space-between is-align-content-center">
            <h1 class="title">Pages</h1>
            <a href="{{ route('pages.create') }}" class="button is-primary">Create New Page</a>
        </div>
        <div class="box">
            <table class="table">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>URL</th>
                </tr>
                </thead>
                @foreach ($pages as $page)
                    <tr>
                        <td>
                            <a href="{{ route('pages.edit', ['page' => $page->id]) }}">{{ $page->title }}</a>
                        </td>
                        <td>
                            <a href="{{ $page->url }}">Link</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
