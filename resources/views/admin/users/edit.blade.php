@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">Edit {{ $model->name }}</h1>
        <form action="{{ route('users.update', ['user' => $model->id]) }}" method="POST">
            {{ method_field('PUT') }}
            {!! csrf_field() !!}

            <div class="checkboxes field">
                @foreach ($roles as $role)
                    <div class="field">
                        <label class="checkbox">
                            <input
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->id }}"
                                {{ $model->hasRole($role->name) ? 'checked' : '' }}
                            >
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="field">
                <input type="submit" class="button is-primary" value="Submit">
            </div>
        </form>
    </div>
@endsection
