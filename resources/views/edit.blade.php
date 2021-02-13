@extends('layouts.app')
@section('content')

<div class="container"></div>
<div class="row">
    <div class="col-md-6 offset-md-3">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                  <li>{{$error}}</li>
              @endforeach
            </ul>
        </div>
     @endif
        @foreach($posts as $post)
        <form action="{{ action('PostController@update',$post->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" name="name" type="name" value={{$post->name}} readonly/>
            </div>
            <div class="form-group">
                <label>Detail</label>
                <input class="form-control" name="detail" type="name" value={{$post->detail}} />
            </div>
            <div class="form-group">
                <label>Author</label>
                <input class="form-control" name="author" type="name" value={{$post->author}} />
            </div>
            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{action('PostController@index')}}" class="btn btn-default">Back</a>
        </form>
        @endforeach
    </div>
</div>
</div>
@endsection
