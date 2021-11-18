<?php

namespace App\Http\Controllers\Back;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\File;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'ASC')->get();
        return view('back.articles.index', compact('articles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return  view('back.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
           'title' => 'min:3',
           'image' => 'required|image|mines:jpeg,png,jpg|max:2048',
        ]);
        //dd($request->post());
        $article=new Article;
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $article->image='/uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Başarılı', 'Makale başarılı şekilde oluşturuldu.');
        return redirect()->route('admin.makaleler.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /** php artisan make:controller Back\ArticleController --resource

     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories=Category::all();
        return  view('back.articles.update', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'title' => 'min:3',
            'image' => 'image|mines:jpeg,png,jpg|max:2048',
        ]);
        //dd($request->post());
        $article=Article::findOrFail($id);
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $article->image='/uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Başarılı', 'Makale başarılı şekilde güncellendi.');
        return redirect()->route('admin.makaleler.index');
    }
    public function switch(Request $request)
    {
        $article =Article::findOrFail($request->id);
        $article->status = $request->statu=="true" ? 1 : 0;
        $article->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        Article::find($id)->delete();
        toastr()->success('Makale, silinen makalelere taşındı.');
        return  redirect()->route('admin.makaleler.index');
    }

    public function trashed()
    {
        $article = Article::onlyTrashed()->orderBy('deleted_at', 'DESC')->get();
        return view('back.articles.trashed', ['articles'=>$article]);
    }
    public function recover($id)
    {
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Makale başarıyla kurtarıldı.');
        return  redirect()->back();
    }
    public function hardDelete($id)
    {
        $article = Article::onlyTrashed()->find($id);
        if (File::exists($article->image)) {
            File::delete(public_path($article->image));
        }
        $article->forceDelete();
        toastr()->success('Makale başarıyla silindi.');
        return  redirect()->route('admin.makaleler.index');
    }

//    public function destroy($id)
//    {
//        return  $id;
//    }
}
