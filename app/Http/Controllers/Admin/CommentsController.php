<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Comment;
use App\Models\Tag;
use \Illuminate\Support\Str;

class CommentsController extends Controller {

    public function index() {

        return view('admin.comments.index', [
        ]);
    }

    public function datatable(Request $request) {

        $searchFilters = $request->validate([
            'status' => ['nullable', 'in:0,1'],
            'blog_post_subject' => ['nullable', 'string', 'max:255'],
            'sender_nickname' => ['nullable', 'string', 'max:255'],
            'sender_email' => ['nullable', 'string', 'max:255'],
        ]);

        $query = Comment::query()
                ->with('blogPost')
                ->join('blog_posts', 'comments.blog_post_id', '=', 'blog_posts.id')
                ->select(['comments.*', 'blog_posts.subject AS blog_post.subject']);


        //Inicijalizacija datatables-a
        $dataTable = \DataTables::of($query);

        //Podesavanje kolona




        $dataTable
                ->addColumn('blog_post_subject', function ($comment) {
                    return optional($comment->blogPost)->subject;
                })
                ->addColumn('actions', function ($comment) {
                    return view('admin.comments.partials.actions', ['comment' => $comment]);
                })
                ->editColumn('id', function ($comment) {
                    return '#' . $comment->id;
                })
                ->editColumn('status', function ($comment) {

                    if ($comment->status == 1) {
                        return '<span class="text-success">Enabled</span>';
                    } else {
                        return '<span class="text-danger">Disabled</span>';
                    }
                })
                ->editColumn('created_at', function ($comment) {
                    return $comment->created_at->format('Y-m-d');
                })
                ->editColumn('body', function ($comment) {
                    return \Str::limit($comment->body, 50);
                });


        $dataTable->rawColumns(['status', 'blog_post_subject', 'id', 'actions', 'created_at', 'body']);

        $dataTable->filter(function ($query) use ($request, $searchFilters) {

            if (
                    $request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])
            ) {
                $searchTerm = $request->get('search')['value'];

                $query->where(function ($query) use ($searchTerm) {

                    $query->orWhere('comments.status', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('blog_posts.subject', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('comments.sender_nickname', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('comments.sender_email', '=', $searchTerm);
                });
            }



            if (isset($searchFilters['status'])) {
                $query->where('comments.status', 'LIKE', '%' . $searchFilters['status'] . '%');
            }

            /* if (isset($searchFilters['blog_post_id'])) {
              $query->where('comments.blog_post_id', '=', $searchFilters['blog_post_id']);
              } */

            if (isset($searchFilters['sender_name'])) {
                $query->where('sender_nickname', '=', $searchFilters['sender_nickname']);
            }
            if (isset($searchFilters['sender_email'])) {
                $query->where('sender_email', '=', $searchFilters['sender_email']);
            }
        });

        return $dataTable->make(true); //make - pravi json po specifikaciji DataTables.js plugin-a	
    }

    public function enable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:comments,id'],
        ]);

        $comment = Comment::findOrFail($formData['id']);
        $comment->status = Comment::STATUS_ENABLED;
        $comment->save();

        return response()->json([
                    'system_message' => __('Comment has been enabled')
        ]);
    }

    public function disable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:comments,id'],
        ]);

        $comment = Comment::findOrFail($formData['id']);
        $comment->status = Comment::STATUS_DISABLED;
        $comment->save();
        return response()->json([
                    'system_message' => __('Comment has been disabled')
        ]);
    }

}
