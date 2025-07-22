@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <article class="message is-danger">
                <div class="message-body">
                    {{ session('status') }}
                </div>
            </article>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                </tr>
            </thead>
            @foreach ($users as $user)
                <tr>
                    <td>
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}">{{ $user->name }}</a>
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $users->links() }}
    </div>
@endsection
