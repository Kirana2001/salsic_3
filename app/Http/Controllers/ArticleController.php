<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('articles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'author' => 'required',
            'content' => 'required',
            'image' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/article-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Artikel gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Article::create($data);

        if (!$ok) {
            return redirect()->back()->with('error', 'Artikel gagal disimpan');
        }

        return redirect('/articles')->with('success', 'Artikel berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['article'] = Article::find($id);

        return view('articles.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['article'] = Article::find($id);

        return view('articles.edit', $datas);
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
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'author' => 'required',
            'content' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/article-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Artikel gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Article::find($id)->update($data);

        if (!$ok) {
            return redirect()->back()->with('error', 'Artikel gagal disimpan');
        }

        return redirect('/articles')->with('success', 'Artikel berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = Article::find($id)->delete();

        if (!$ok) {
            return redirect()->back()->with('error', 'Artikel gagal dihapus');
        }

        return redirect()->back()->with('success', 'Artikel berhasil dihapus');
    }

    public function articleDatatable()
    {
        $articles = Article::orderBy('id', 'desc')->get();

        return datatables()->of($articles)->addIndexColumn()->toJson();
    }
}
