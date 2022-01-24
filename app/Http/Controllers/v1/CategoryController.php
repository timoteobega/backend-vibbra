<?php

namespace App\Http\Controllers\v1;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all('id','name','description');
        if ($categories->isEmpty())
        {
            return response()->json(['error' => 'Not found'],404);
        }
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        try
        {
            $category = new Category;
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            if($category->save())
            {
                return response()->json(['category_id' => $category->id],201);
            }
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function show($id)
    {
        $category = Category::all('id','name','description')->where('id','=',$id);
        if ($category->isEmpty())
        {
            return response()->json(['error' => 'Not found'],404);
        }
        return response()->json($category->first());
    }

    public function update(Request $request, $id)
    {
        try
        {
            $category = Category::find($id);
            if (is_null($category))
            {
                return response()->json(['error' => 'Not found'],404);
            }
            $category->name = is_null($request->input('name')) ? $category->name : $request->input('name');
            $category->description = is_null($request->input('description')) ? $category->description : $request->input('description');
            $category->save();
            return response('',200);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (is_null($category))
        {
            return response()->json(['error' => 'Not found'],404);
        }
        $category->delete();
        return response('',204);
    }

    public function search($key,$value)
    {
        try {
            $categories = Category::query()->where($key, 'like', "%{$value}%")->get(['id','name','description']);
            if ($categories->isEmpty())
            {
                return response()->json(['error' => 'Not found'],404);
            }
            return response()->json([
                "count" => $categories->count(),
                "categories" => $categories->all()
            ]);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }
}
