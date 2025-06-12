<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ], [
            'content.required' => 'O conteúdo do comentário é obrigatório.',
            'content.max' => 'O comentário não pode ter mais de 1000 caracteres.',
        ]);

        $task->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Comentário adicionado com sucesso!');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        // Only the comment author can delete their comment
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para excluir este comentário.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comentário excluído com sucesso!');
    }
}
