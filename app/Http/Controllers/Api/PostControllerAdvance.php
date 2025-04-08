<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\partida;
use App\Models\Post;
use App\Http\Resources\GameResource;
use Carbon\Carbon;

class PostControllerAdvance extends Controller
{
    public function index()
    {

//        $orderColumn = request('order_column', 'created_at');
//        if (!in_array($orderColumn, ['day', 'player'])) {
//            $orderColumn = 'fecha';
//        }
//        $orderDirection = request('order_direction', 'desc');
//        if (!in_array($orderDirection, ['asc', 'desc'])) {
//            $orderDirection = 'desc';
//        }
//
//        $partidas = Partida::
//        when(request('search_day'), function ($query) {
//            $query->where('fecha', request('search_day'));
//        });
//            ->when(request('search_player'), function ($query) {
//                $query->where('plazas', 'like', '%' . request('search_player') . '%');
//            })
//            ->when(request('search_shift'), function ($query) {
//                $query->where('shift', 'like', '%' . request('search_shift') . '%');
//            })
//            ->when(request('search_state'), function ($query) {
//                $query->where('cancelled', 'like', '%' . request('search_state') . '%');
//            })
//            ->when(request('search_global'), function ($query) {
//                $query->where(function ($q) {
//                    $q->where('fecha', request('search_global'))
//                        ->orWhere('plazas', 'like', '%' . request('search_global') . '%')
//                        ->orWhere('shift', 'like', '%' . request('search_global') . '%')
//                        ->orWhere('cancelled', 'like', '%' . request('search_global') . '%');
//                });
//            })
//            ->orderBy($orderColumn, $orderDirection)
//            ->paginate(10);

//        return Response()->json($partidas, 200);
//        return GameResource::collection($partidas);

        $actualDate = Carbon::now();
        $maxDate = $actualDate->addMonth(2)->endOfMonth();

        $partidas = Partida::where('fecha', '<=', $maxDate)->get();

//        return Response()->json($partidas, 200);

        return GameResource::collection($partidas);
    }

    public function store(StorePostRequest $request)
    {

        $this->authorize('post-create');

        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        $post = Post::create($validatedData);

        $categories = explode(",", $request->categories);
        $category = Category::findMany($categories);
        $post->categories()->sync($category);

        if ($request->hasFile('thumbnail')) {
            $post->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images');
        }

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        $this->authorize('post-edit');
        if ($post->user_id !== auth()->user()->id && !auth()->user()->hasPermissionTo('post-all')) {
            return response()->json(['status' => 405, 'success' => false, 'message' => 'You can only edit your own posts']);
        } else {
            return new PostResource($post);
        }
    }


    //NO edita imagen
    public function update(Post $post, StorePostRequest $request)
    {
        $this->authorize('post-edit');

        if ($post->user_id !== auth()->id() && !auth()->user()->hasPermissionTo('post-all')) {
            return response()->json(['status' => 405, 'success' => false, 'message' => 'You can only edit your own posts']);
        } else {
            $post->update($request->validated());

            $category = Category::findMany($request->categories);
            $post->categories()->sync($category);

            return new PostResource($post);
        }
    }

    public function destroy(Post $post)
    {
        $this->authorize('post-delete');
        if ($post->user_id !== auth()->id() && !auth()->user()->hasPermissionTo('post-all')) {
            return response()->json(['status' => 405, 'success' => false, 'message' => 'You can only delete your own posts']);
        } else {
            $post->delete();
            return response()->noContent();
        }
    }

    public function getPosts()
    {
        $posts = Post::with('categories')->with('media')->latest()->paginate();
        return PostResource::collection($posts);

    }

    public function getCategoryByPosts($id)
    {
        $posts = Post::whereRelation('categories', 'category_id', '=', $id)->paginate();

        return PostResource::collection($posts);
    }

    public function getPost($id)
    {
        return Post::with('categories', 'user', 'media')->findOrFail($id);
    }
}
