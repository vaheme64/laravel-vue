@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{route('questions.create')}}" class="btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('layouts._messages')

                        @foreach($questions as $question)
                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    <div class="vote">
                                        <strong>{{ $question->votes_count }}</strong>{{Str::plural('vote',$question->votes_count)}}
                                    </div>
                                    <div class="status {{$question->status}}">
                                        <strong>{{ $question->answer_count }}</strong>{{Str::plural('answer',$question->answer_count)}}
                                    </div>
                                    <div class="view">
                                        {{ $question->views."  ".Str::plural('views',$question->views)}}
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{$question->url}}">{{$question->title}}</a></h3>
                                        <div class="ml-auto">

                                            {{--@if(Auth::user()->can('update-question',$question))--}}
{{--                                            @if(Auth::user()->can('update',$question))--}}
                                            @can('update',$question)
                                                <a href="{{route('questions.edit',$question->id)}}" class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan
{{--                                            @if(Auth::user()->can('update',$question))--}}
                                            @can('update',$question)
                                                <form class="form-delete" method="post" action="{{route('questions.destroy',$question->id)}}">
                                                    {{--                                               {{method_field('DELETE')}}--}}
                                                    {{--                                               {{csrf_token()}}--}}
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">delete</button>

                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <p class="lead">
                                        Asked by
                                        <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                        <small class="text-muted">{{$question->created_date}}</small>
                                    </p>
                                    {{Str::limit($question->body,250)}}
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        {{$questions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
