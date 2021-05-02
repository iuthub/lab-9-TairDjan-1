<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostLab;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Session\Store;

class PostController extends Controller
{
    public function getIndex(Store $session)
    {
        $posts = PostLab::orderBy('created_at', 'desc') ->get();
        return view('blog.index', ['posts' => $posts]);

//        Store $session
//        $post = new Post();
//        $posts = $post->getPosts($session);
//        return view('blog.index', ['posts' => $posts]);
    }

    public function getAdminIndex(Store $session)
    {
        $posts = PostLab::orderBy('title', 'asc') ->get();
        return view('admin.index', ['posts' => $posts]);


//        $post = new Post();
//        $posts = $post->getPosts($session);
//        return view('admin.index', ['posts' => $posts]);
    }

    public function getPost($id)
    {
        $post = Post::where('id', $id)->first();
        return view('blog.post', ['post'=>$post]);
//        $post = new Post();
//        $post = $post->getPost($session, $id);
//        return view('blog.post', ['post' => $post]);
    }

    public function getAdminCreate()
    {
        return view('admin.create');
    }

    public function getAdminEdit($id)
    {
        $post = Post::find($id);
        return view('admin.edit', ['post' => $post, 'postID' => $id]);
//        $post = new Post();
//        $post = $post->getPost($session, $id);
//        return view('admin.edit', ['post' => $post, 'postId' => $id]);
    }

    public function postAdminCreate(Store $session, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = new Post();
        $post->addPost($session, $request->input('title'), $request->input('content'));
        return redirect()->route('admin.index')->with('info', 'Post created, Title is: ' . $request->input('title'));
    }

    public function postAdminUpdate(Store $session, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = new Post();
        $post->editPost($session, $request->input('id'), $request->input('title'), $request->input('content'));
        return redirect()->route('admin.index')->with('info', 'Post edited, new Title is: ' . $request->input('title'));
    }
}
