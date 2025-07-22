@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">Edit Page</h1>
        <div class="box">
            <form action="{{ route('pages.update', ['page' => $model->id]) }}" method="POST">
                {{ method_field('PUT') }}
                @include('admin.pages.partials.fields')
            </form>
        </div>
    </div>
@endsection
