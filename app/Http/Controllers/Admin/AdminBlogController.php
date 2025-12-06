<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Cat;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class AdminBlogController extends Controller
{
    // ブログ一覧画面
    public function index()
    // {
    //     return view('admin.blogs.index');
    // }
    {
        // DBからブログ一覧を取得
        //$blogs = Blog::all();
        //$blogs = Blog::latest('updated_at')->limit(10)->get();
        //$user = Auth::user();
        //$user =  \Illuminate\Support\Facades\Auth::user();
        $blogs = Blog::latest('updated_at')->simplePaginate(10);
        // ビューに変数を渡す
        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    // ブログ投稿画面
    public function create()
    {
        return view('admin.blogs.create');
    }

    // ブログ投稿処理
    public function store()
    {
        $validated = $request->validated();
        $validated['iamge'] = $request->file('image')->store('blogs','public');
        //Blogクラスのfillableにimageを追加。
        Blog::create($validated);

        return to_route('admin.blogs.index')->with('success','ブログを投稿しました');
    }
    // 指定したIDのブログ編集画面
    public function edit(Blog $blog)
    {
        //$blog = Blog::find($id);
        //$blog = Blog::findOrFail($id);
        //dd($blog);
        //return view('admin.blogs.edit', compact('blog'));
        //$user = Auth::user();
        $categories = Category::all();
        $cats = Cat::all();
        return view('admin.blogs.edit',[
//            'user' => $user,
             'blog' => $blog,
             'categories' => $categories,
             'cats'=> $cats
        ]);
    }

    //　指摘したIDのブログ更新処理
    public function update(UpdateBlogRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        $updateData = $request->validated();

        // 画像を変更する場合
        if ($request->has('image')) {
            Storage::disk('public')->delete($blog->image);
            // 変更後の画像をアップロード、保存パスを更新対象データにセット
            $updateData['image'] = $request->file('image')->store('blogs', 'public');
        }
        $blog->category()->associate($updateData['category_id']);
        $blog->update($updateData);
        //$blog->cats()->attach($updateData['cats']);
        $blog->cats()->sync($updateData['cats'] ?? []);

        return to_route('admin.blogs.index')->with('success','ブログを更新しました');
    }

    // 指定したIDのブログの削除処理
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        Storage::disk('public')->delete($blog->image);

        return to_route('admin.blogs.index')->with('success','ブログを削除しました');
    }
}
