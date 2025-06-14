<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\food;
use App\Models\partida;
use App\Models\pedido;
use App\Models\Post;
use App\Http\Resources\GameResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PostControllerAdvance extends Controller
{
    public function index()
    {
        $actualDate = Carbon::now();
        $maxDate = $actualDate->addMonth(2)->endOfMonth();

        $partidas = Partida::where('fecha', '<=', $maxDate)->get();

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

    public function show($post)
    {

//        return $post;
//        $this->authorize('post-edit');
//        if ($post->user_id !== auth()->user()->id && !auth()->user()->hasPermissionTo('post-all')) {
//            return response()->json(['status' => 405, 'success' => false, 'message' => 'You can only edit your own posts']);
//        } else {
            $game = Partida::findOrFail($post);

            $playersList = $game->players;

            $players = $playersList->map(function ($player) {
                $pedidoId = $player->pivot->pedido_id;
                $income = $player->pivot->cost;
                $productName = null;
                if ($pedidoId) {
                    $pedido = pedido::find($pedidoId);
                    if ($pedido->food_id != null) {
                        $product = food::find($pedido->food_id);
                        $productName = $product->nombre;
                    } else {
                        $productName = 'Sin bocadillo';
                    }
                }

                $statusState = null;
                switch ($player->dentro) {
                    case 0:
                        $statusState = 'Fuera';
                        break;
                    case 1:
                        $statusState = 'Dentro';
                        break;
                    default:
                        $statusState = 'Si ves esto, avisa a los informaticos';
                        break;
                }

                return [
                    'player_id' => $player->id,
                    'DNI' => $player->DNI,
                    'name' => $player->nombrecompleto,
                    'phone' => $player->telefono,
                    'mail' => $player->email,
                    'food_name' => $productName,
                    'income' => $pedido->cost,
                    'team' => $player->team,
                    'status' => $statusState,
                ];
            });

            return response()->json(['status' => 200, 'players' => $players]);
//        }
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

    public  function  cancel($post)
    {
//        $this->authorize('post-cancell');
//        if ($post->user_id !== auth()->id() && !auth()->user()->hasPermissionTo('post-cancell')) {
//            return response()->json(['status' => 405, 'success' => false, 'message' => 'No tienes permisos para cancellar este post']);
//        } else {
//
//        }

        echo $post;

        $result = DB::table('partida')->where('id', $post)->update(['cancelled' => true]);
        if ($result) {
            return response()->json(['status' => 200, 'success' => true, 'message' => 'Se cancelo con exito']);
        } else {
            return response()->json(['status' => 405, 'success' => false, 'message' => 'No se pudo cancelar']);
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

    public function checkPlayer($ID,$DNI)
    {

        $game = Partida::findOrFail($ID);

        $playersList = $game->players->firstWhere('DNI', $DNI)->update(['dentro'=>true]);



        return $playersList;
    }
}
