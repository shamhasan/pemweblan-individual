<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Membuat Comment
    public function store(Request $request)
    {
        // memvalidasi inputan user
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'author' => 'required|string|max:100',
            'content' => 'required|string|max:255',
        ]);
        // simpan ke database
        $comment = Comment::create($validated);
        // response
        return response()->json(
            [
                'message' => 'Komentar berhasil dibuat',
                'data' => 'test'
            ],
            201
        );
    }
    // Menampilkan comment sesuai dengan post_id
    public function index(Comment $comment, Post $post)
    {
        // Mencari comment berdasarkan post_id
        $comment = Comment::where('post_id', $post->id)->get();
        // Memberikan response sukses
        return response()->json([
            'message' => 'List semua komentar',
            'data' => $comment
        ]);
    }
    // Menampilkan comment berdasarkan id comment
    public function showById($id)
    {
        // Mencari comment berdasarkan id
        $comment = Comment::find($id);
        // Memberikan response sukses atau gagal
        if ($comment) {
            return response()->json([
                'message' => 'Detail komentar',
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'message' => 'Komentar tidak ditemukan'
            ], 404);
        }
    }
    // Mengupdate comment berdasarkan id comment
    public function update(Request $request, Comment $comment, $id)
    {
        // Mencari comment berdasarkan id
        $comment = Comment::find($id);
        // Memvalidasi inputan user
        $validated = $request->validate([
            'content' => 'sometimes|required|string|min:5|max:255'
        ]);
        // Membuat update ke database
        $comment->update($validated);
        // Memberikan response sukses
        return response()->json([
            'message' => 'comment berhasil diupdate',
            'data' => $comment
        ], 201);
    }
    // Menghapus comment berdasarkan id comment
    public function destroy($id)
    {
        // Mencari comment sesuai id
        $comment = Comment::find($id);
        // Menghapus comment
        $comment->delete();
        // Memberikan response sukses
        return response()->json([
            'message' => 'Berhasil di hapus'
        ], 201);
    }
}
