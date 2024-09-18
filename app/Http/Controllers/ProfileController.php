<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', compact('user'));
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
