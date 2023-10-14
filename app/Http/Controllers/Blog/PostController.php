<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::latest()->simplePaginate(10);

        if ($request->expectsJson()) {
            if ($posts->count() > 0) {
                $htmlPartial = view('posts.partials.index', compact('posts'))->render();
                return response()->json(['html' => $htmlPartial, 'lastPage' => false, 'count' => $posts->count()]);
            } else {
                return response()->json(['lastPage' => true, 'count' => $posts->count()]);
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
                ->addColumn('action', function ($row) {
                    $html = view('posts.partials.action', ['post' => $row])->render();
                    return $html;
                })
                ->rawColumns(['title', 'action'])
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

        return $this->redirectTo($post, 'Post added successfully!');
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

        return $this->redirectTo($affectedRow, 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $affectedRow = $post->delete();

        return $this->redirectTo($affectedRow, 'Post deleted successfully!');
    }

    /**
     * Redirect to the resource listing page with success/error message.
     *
     * @param  bool  $affectedRow
     * @param  string  $msg
     * @return RedirectResponse
     */
    protected function redirectTo(mixed $affectedRow, string $msg): RedirectResponse
    {
        if ($affectedRow) {
            return redirect()->route('post.index')->withSuccess($msg);
        }
        return redirect()->route('post.index')->withError('Something went wrong!');
    }
}
