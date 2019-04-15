@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Your Blog Posts</h3>
                    @if(@count($posts) > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th></th>
                                    <th></th>                            
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{$post->title}}</td>
                                    <td class="text-center"><a href="/posts/{{$post->id}}/edit" 
                                        class="btn btn-outline-dark">Edit</a>
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open(['action' => ['PostsController@destroy', $post->id],
                                                'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-outline-danger'])}}
                                        {!! Form::close() !!}    
                                    </td>                            
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p>No posts created yet.</p>
                        <a href="posts/create" class="btn btn-outline-primary btn-lg">Create Your First Post</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
