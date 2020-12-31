<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\User;
use App\Notifications\NewComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
        /**
     * Require authentication to browse posts.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }

    public function apiComments($post_id){
        return Post::findOrFail($post_id)->comments->load('comments');
    }

    // authenticated by auth:api
    public function apiCommentCreate($post_id, Request $request){
        $validatedData = $request->validate([
            'text' => 'required',
            'commentableType' => 'required',
            'commentableId' => 'required',
        ]);

        // being authenticated by the middleware guarantees that said commenter exists
        $token = $request->bearerToken();
        $commenter = User::where('api_token', $token)->first();

        $post = Post::findOrFail($post_id);

        $commentableId = 0;
        $commentableType = '';

        if(strtolower($validatedData['commentableType']) == 'comment'){
            $commentableId = Comment::findOrFail(intval($validatedData['commentableId']))->id;
            $commentableType = Comment::class;
        } else {
            $commentableId = $post->id;
            $commentableType = Post::class;
        }

        $comment = new Comment;
        $comment->text = $request['text'];
        $comment->commentable_id = $commentableId;
        $comment->commentable_type = $commentableType;
        $comment->user_id = $commenter->id;
        // Set to '1' as this is how laravel saves booleans in the database.
        // Otherwise, the frontend sometimes receives true and sometimes '1'.
        $comment->editable_by_user = '1';
        $comment->save();

        if($post->author->id != $commenter->id){
            $post->author->notify(new NewComment($comment, $post));
        }

        return $comment->load('author');
    }

    public function apiCommentUpdate($comment_id, Request $request){
        $validatedData = $request->validate([
            'text' => 'required',
        ]);

        $comment = Comment::findOrFail($comment_id);

        // being authenticated by the middleware guarantees that said sender exists
        $token = $request->bearerToken();
        $sender = User::where('api_token', $token)->first();

        if(Gate::forUser($sender)->denies('api-update-comment', $comment)){
            abort(403);
        }

        $comment->text = $validatedData['text'];

        // A comment modified by an admin will not be changeable by the user anymore.
        if($sender->isAdmin()){
            $comment->editable_by_user = false;
        }

        $comment->save();
        return $comment->load('author');
    }
}
