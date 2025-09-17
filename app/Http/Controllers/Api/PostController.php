<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        // Validasi sederhana
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        // Simpan ke database
        $post = Post::create($validated);
        return response()->json([
            'message' => 'Post berhasil dibuat',
            'data' => $post
        ], 201);
    }
    // GET /api/posts
    public function index()
    {
        // ambil semua post dengan relasi user & comments
        $posts = Post::with('user', 'comments')->latest()->get();
        return response()->json([
            'message' => 'Daftar semua post',
            'data' => $posts
        ]);
    }

    // GET /api/posts/{post}
    public function show(Post $post)
    {
        // otomatis inject berdasarkan {post}, load relasi
        $post->load('user', 'comments');
        return response()->json([
            'message' => 'Detail post',
            'data' => $post
        ]);
    }

    public function update(Request $request, Post $post)
    {
        // Validasi sederhana
        $validated = $request->validate([
            'title' => 'sometimes|required|string|min:5|max:255',
            'body' => 'sometimes|required|string',
        ]);
        // Update post
        $post->update($validated);
        return response()->json([
            'message' => 'Post berhasil diperbarui',
            'data' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => 'Post berhasil dihapus'
        ], 200);
    }
}
