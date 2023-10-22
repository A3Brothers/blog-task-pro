<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::orderByDesc('id')->cursorPaginate(10);

        if ($request->expectsJson()) {
            if ($posts->count()) {
                $htmlPartial = view('posts.partials.index', compact('posts'))->render();
                return response()->json(['html' => $htmlPartial, 'lastPage' => false, 'nextPageUrl' => $posts->nextPageUrl()]);
            } else {
                return response()->json(['lastPage' => true]);
            }
        }

        return view('posts.index', compact('posts'));
    }

    /**
     * Display a listing of the resource created by currently logged in user.
     */
    public function userPosts(Request $request)
    {

        if ($request->expectsJson()) {
            $posts = auth()->user()->posts;

            return DataTables::collection($posts)
                ->addIndexColumn()
                ->setRowId('id')
                ->addColumn('index', function ($row) {
                    static $i = 1;
                    return $i++;
                })
                ->editColumn('title', function ($row) {
                    $url = route('post.show', ['post' => $row->slug]);
                    $html = <<<HTML
                    <a href="{$url}" class="text-red-300 hover:text-blue-500">$row->title</a>
                    HTML;
                    return $html;
                })
                ->editColumn('content', '{{words($content, stripHtml: true)}}')
                ->editColumn('published_at', '{{date("d-M-Y", strtotime($published_at))}}')
                ->editColumn('view', function ($row) {
                    $url = route('post.show', ['post' => $row->slug]);
                    $imgUrl = asset('assets/image/icons8-view-50.png');
                    $html = <<<HTML
                    <p><a href="{$url}"><img class="w-6" src="$imgUrl" alt="view"></a></p>
                    HTML;
                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $html = view('posts.partials.action', ['post' => $row])->render();
                    return $html;
                })
                ->rawColumns(['title', 'action', 'view'])
                ->toJson();
        }
        return view('posts.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->all());

        return redirectTo($post, 'Post added successfully!', 'post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $affectedRow = $post->update($request->all());

        return redirectTo($affectedRow, 'Post updated successfully!', 'post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('update', $post);

        $affectedRow = $post->delete();

        return redirectTo($affectedRow, 'Post deleted successfully!', 'post.index');
    }
}
