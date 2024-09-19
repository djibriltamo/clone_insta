<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->profile->id) : false;

        $postsCount = Cache::remember('posts.count' . $user->id, now()->addSeconds(30), function() use ($user){
            return $user->posts->count();
        });

        $followersCount = Cache::remember('followers.count' . $user->id, now()->addSeconds(30), function() use ($user){
            return $user->profile->followers->count();
        });

        $followingCount = Cache::remember('following.count' . $user->id, now()->addSeconds(30), function() use ($user){
            return $user->following->count();
        });

        return view('profiles.show', compact('user', 'follows', 'postsCount', 'followingCount', 'followersCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'required|url',
            'image' => 'sometimes|image|max:6000'
        ]);

        if (request('image')) {
            $imagePath = request('image')->store('avatars', 'public');
            $image = Image::read(public_path("storage/{$imagePath}"))->resize(1200, 1200);
            $image->save();

            auth()->user()->profile->update(array_merge(
                $data,
                ['image' => $imagePath]
            ));
        }else{
            auth()->user()->profile->update($data);
        }

        return redirect()->route('profiles.show', $user);
    }
}
