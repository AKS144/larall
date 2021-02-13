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
        <form action="{{action('PostController@store')}}" method="post">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" type="name" name="name" placeholder="Name"/>
            </div>
            <div class="form-group">
                <label>Detail</label>
                <input class="form-control" name="detail" type="name" placeholder="Detail"/>
            </div>
            <div class="form-group">
                <label>Author</label>
                <input class="form-control" name="author" type="name" placeholder="Penlink"/>
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
</div>
</div>
@endsection
