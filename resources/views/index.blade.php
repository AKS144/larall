@extends('layouts.app')
@section('content')

<div class="container">

@if($message = Session::get('success'))
    <div class="alert alert-success">
         <p>{{ $message }}</p>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <h1>Crud Laravel</h1>
    </div>
    <div class="col-md-4">
        <form action="/search" method="get">
            <div class="input-group">
                <input type="search" name="search" placeholder="Search" class="form-control">
                <span class="input-group-prepend">
                    <button type="submit" class="btn btn-primary">Search</button>
                </span>
            </div>
        </form>
    </div>
    <div class="col-md-2 test-right">
        <a href="{{ action('PostController@create') }}" class="btn btn-primary float-right">Add</a>
    </div>
</div>


<form action="/deleteall" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete All Selected</button>
<table class="table table-bordered">
    <thead>
        <tr>
            <th><input type="checkbox" class="selectall"></th>
            <th>Name</th>
            <th>Detail</th>
            <th>Author</th>
            <th width="230">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <td><input type="checkbox" name="ids[]" class="selectbox" value="{{ $post->id }}" /></td>
            <td>{{ $post->name }}</td>
            <td>{{ $post->detail }}</td>
            <td>{{ $post->author }}</td>
            <td>
                <a href="{{ action('PostController@show',$post->id) }}" class="btn btn-info">Show</a>
                <a href="{{ action('PostController@edit',$post->id) }}" class="btn btn-warning">Edit</a>
                @csrf
                @method('DELETE')
                <button formaction="{{ action('PostController@destroy',$post->id) }}" type="submit" class="btn btn-danger">Delete</button>
            </form>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th><input type="checkbox" class="selectall2"></th>
            <th>Name</th>
            <th>Detail</th>
            <th>Author</th>
            <th width="230">Action</th>
        </tr>
    </tfoot>
</table>
</form>
{{$posts->links()}}
<div class="container">
@endsection

<script type="text/javascript">
	$('.selectall').click(function(){
		$('.selectbox').prop('checked', $(this).prop('checked'));
		$('.selectall2').prop('checked', $(this).prop('checked'));
	})
	$('.selectall2').click(function(){
		$('.selectbox').prop('checked', $(this).prop('checked'));
		$('.selectall').prop('checked', $(this).prop('checked'));
	})
	$('.selectbox').change(function(){
		var total = $('.selectbox').length;
		var number = $('.selectbox:checked').length;
		if(total == number){
			$('.selectall').prop('checked', true);
			$('.selectall2').prop('checked', true);
		}else{
			$('.selectall').prop('checked', false);
			$('.selectall2').prop('checked', false);
		}
	})
</script>
