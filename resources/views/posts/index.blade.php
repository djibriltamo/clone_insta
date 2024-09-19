@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($posts->isEmpty())
            <p class="text-center">Aucun post trouvé.</p>
        @else
            @foreach ($posts as $post)
                <div class="row mb-4">
                    <div class="col-6 offset-3">
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                            <img src="{{ asset('storage') . '/' . $post->image }}" width="75%">
                        </a>
                        <hr>

                        <div>
                            Posté par : <strong>{{ $post->user->username }}</strong> le {{ $post->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="col-12">
            <div class="row d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection