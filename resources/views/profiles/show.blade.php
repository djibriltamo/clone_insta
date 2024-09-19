@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">

            <div class="col-4 text-center">
                <img src="{{ $user->profile->getImage() }}"
                    class="rounded-circle" width="250px" style="max-width: 230px">
            </div>

            <div class="col-8">
                <div class="d-flex align-items-baseline">
                    <div class="h4 pt-2" style="margin-right: 10px">{{ $user->username }}</div>
                    <follow-button profile-id="{{ $user->profile->id }}" follows="{{ $follows }}"></follow-button>
                </div>

                <div class="d-flex" style="margin-top: 3px">
                    <div style="margin-right: 13px"><strong>{{ $postsCount }}</strong> publication(s)</div>
                    <div style="margin-right: 13px"><strong>{{ $followersCount }}</strong> Abonné(s)</div>
                    <div style="margin-right: 13px"><strong>{{ $followingCount }}</strong> abonnement(s)</div>
                </div>

                @can('update', $user->profile)
                    <a href="{{ route('profiles.edit', ['user' => $user->username]) }}" class="btn btn-outline-secondary mt-3"> 
                        <b>Modifier mon profil</b>
                    </a>
                @endcan

                <div class="mt-3">
                    <div class="font-weight-bold mt-4²x"><b>Mon profil : </b> {{ $user->profile->title }}</div>
                    <div><b>Ma bio : </b>{{ $user->profile->description }}</div>
                    <b>Lien : </b><a href="{{ $user->profile->url }}"> {{ $user->profile->url }}</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            @foreach ($user->posts as $post)
                <div class="col-4 pb-3">
                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                        <img src="{{ asset('storage') . '/' . $post->image }}" width="75%">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
