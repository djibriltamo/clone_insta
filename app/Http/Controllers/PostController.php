<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following->pluck('user_id');

        if ($users->isEmpty()) {
            return redirect()->route('home')->with('message', 'Vous ne suivez aucun utilisateur.');
        }

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts.index', compact('posts'));
    }

    
    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => ['required', 'string'],
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::read(public_path("storage/{$imagePath}"))->resize(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect()->route('profiles.show', ['user' => auth()->user()]);
    }

    public function show(Post $post) 
    {
        return view('posts.show', compact('post'));
    }
}
