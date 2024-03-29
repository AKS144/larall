<?php

namespace App\Http\Controllers;

use App\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct(){
       // $this->middleware('auth');
    }//added for auth controller

    public function index()
    {
        //$posts = DB::select('select * from posts');
        $posts = DB::table('posts')->latest('id')->paginate(10);
        return view('index',['posts'=> $posts]);
    }

    public function create()
    {
        return view('create');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $posts = DB::table('posts')->where('name', 'like', '%'.$search.'%')->paginate(2);
        return view('index', ['posts' => $posts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'author' => 'required'
        ]);

        $name = $request->get('name');
        $detail = $request->get('detail');
        $author = $request->get('author');
        $posts = DB::insert('insert into posts(name, detail, author) value(?,?,?)',[$name, $detail, $author]);
        if($posts){
            $red = redirect('posts')->with('success','Data has been added');
        }else{
            $red = redirect('posts/create')->with('danger','Input data failed, please try again');
        }
        return $red;
    }

    public function show($id)
    {
        $posts = DB::select('select * from posts where id=?',[$id]);
        return view('show', ['posts'=> $posts]);
    }

    public function edit($id)
    {
        $posts = DB::select('select * from posts where id=?',[$id]);
        return view('edit', ['posts' => $posts]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'author' => 'required'
        ]);

        $name = $request->get('name');
        $detail = $request->get('detail');
        $author = $request->get('author');
        $posts = DB::update('update posts set name=?, detail=?, author=? where id=?',[$name, $detail, $author, $id]);
        if($posts){
            $red = redirect('posts')->with('success','Data has been updated');
        } else{
            $red = redirect('posts/edit/'.$id)->with('danger','Error update please try again');
        }
        return $red;
    }

    public function destroy($id)
    {
        $posts = DB::delete('delete from posts where id=?',[$id]);
        return redirect('posts');
    }

    public function deleteAll(Request $request){
        $ids = $request->get('ids');
        //$ids = DB::table('posts')->whereIn('id', explode(',',$ids))->delete();
        $ids = DB::delete('delete from posts where id in ('.implode(",",$ids).')');
        return redirect('posts');
    }
}
