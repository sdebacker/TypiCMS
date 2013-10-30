<?php

class PostController extends BaseController {

    public function index()
    {
        $records = Post::with('translations')->get();
        return View::make('post.index')
            ->with('records', $records);
    }

    public function create()
    {
        return View::make('post.create');
    }

    public function store()
    {
        $record = new Post;
        if( $record->save() )
            return Redirect::to('posts');
    }

    public function show($id)
    {
        $record = Post::find($id);
        return View::make('post.show')
            ->with('record', $record);
    }

    public function edit($id)
    {
        $record = Post::find($id);
        return View::make('post.edit')
            ->with('record', $record);
    }

    public function update($id)
    {
        $record = Post::find($id);
        if( $record->save() )
            return Redirect::to('posts');
    }

    public function destroy($id)
    {
        $record = Post::find($id);
        if( $record->delete() )
			return Redirect::to('posts');
    }

}