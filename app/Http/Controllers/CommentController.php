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
        return Post::findOrFail($post_id)->comments->load('author');
    }

    public function apiCommentCreate($post_id, Request $request){

        // todo1: data (text) validation
        $token = $request->bearerToken();

        $comment = new Comment;
        $comment->text = $request['text'];
        $comment->commentable_id = $post_id;
        $comment->commentable_type = Post::class;
        $comment->user_id = User::where('api_token', $token)->first()->id;
        $comment->save();
        return $comment->load('author');
    }

    public function apiCommentUpdate($comment_id, Request $request){
        // todo1: data (text) validation
        $comment = Comment::findOrFail($comment_id);

        $token = $request->bearerToken();
        $sender = User::where('api_token', $token)->first();

        if(Gate::forUser($sender)->denies('api-update-comment', $comment)){
            abort(403);
        }

        $comment->text = $request['text'];

        // A comment modified by an admin will not be changeable by the user anymore.
        if($sender->isAdmin()){
            $comment->editable_by_user = false;
        }

        $comment->save();
        return $comment->load('author');
    }

    public function apiNotifyNewComment(Request $request){
        $commentId = $request["commentId"];
        $comment = Comment::findOrFail($commentId);
        $postAuthor = $comment->commentable->author;
        $postAuthor->notify(new NewComment($comment));
    }
}
