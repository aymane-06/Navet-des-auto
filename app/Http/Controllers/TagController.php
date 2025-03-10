<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use League\CommonMark\Normalizer\SlugNormalizer;
use Str;
use Symfony\Component\String\Slugger\SluggerInterface;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags=Tag::paginate(10);
        return view("Tags.index",compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        $tag=new Tag();
        $tag->name=$request->name;
        $tag->slug=Str::slug($request->name);
        $tag->save();
        return redirect()->route('admin.tags');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        // dd($tag);
        $tag->name=$request->name;
        $tag->slug=Str::slug($request->name);
        $tag->save();
        return redirect()->route('admin.tags');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // dd($tag);
        $tag->delete();
        return response()->json('deleted!');
    }
}
