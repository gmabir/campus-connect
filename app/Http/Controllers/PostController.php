<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with(['user', 'comments.user'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request) {
        $request->validate(['content' => 'required']);
        Post::create(['user_id' => Auth::id(), 'content' => $request->content]);
        return back()->with('success', 'Post shared!');
    }

    public function storeComment(Request $request, $postId) {
        $request->validate(['comment' => 'required']);
        Comment::create([
            'post_id' => $postId,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return back();
    }
}