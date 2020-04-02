<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $answerCount." ".Str::plural('Answer',$answerCount) }}</h2>
                </div>
                <hr>
                @include('layouts._messages')
                @foreach($answers as $answer)
                    {{--                            {{dd($answer)}}--}}
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a href="" title="This Answer is useful" class="vote-up {{Auth()->guest() ? 'off' : ''}}"
                               onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{$answer->id}}').submit();">
                                <i class="fa fa-caret-up fa-3x"></i>
                            </a>
                            <form method="post" id='up-vote-answer-{{$answer->id}}' action="/answers/{{ $answer->id }}/vote" style="display: none;">
                                @csrf
                                <input type="hidden" name="vote" value="1">
                            </form>
                            <span class="votes-count">{{$answer->votes_count}}</span>
                            <a class="vote-down {{Auth()->guest() ? 'off' : ''}}" title="This Question is not useful"
                               onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{$answer->id}}').submit();">
                                <i class="fa fa-caret-down fa-3x"></i>
                            </a>
                            <form method="post" id='down-vote-answer-{{$answer->id}}' action="/answers/{{ $answer->id }}/vote" style="display: none;">
                                @csrf
                                <input type="hidden" name="vote" value="-1">
                            </form>
                            @can('accept',$answer)
                                <a title="Mark this answer as best answer" class="{{$answer->status}} mt-2"
                                   onclick="event.preventDefault(); document.getElementById('answer-accepted-{{$answer->id}}').submit();">
                                    <i class="fa fa-check fa-2x"></i>
                                </a>
                                    <form method="post" id='answer-accepted-{{$answer->id}}' action="{{route('answer.accept',$answer->id)}}" style="display: none;">@csrf</form>
                            @else
                                @if($answer->is_best)
                                    <a title="The question owner accepted this answer as best answer" class="{{$answer->status}} mt-2">
                                        <i class="fa fa-check fa-2x"></i>
                                    </a>
                                @endif
                            @endcan
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
                            {{--                                    {{ $answer->body_html }}--}}
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        @can('update',$answer)
                                            <a href="{{route('questions.answers.edit',[$question->id,$answer->id])}}" class="btn btn-sm btn-outline-info">Edit</a>
                                        @endcan
                                        @can('update',$answer)
                                            <form class="form-delete" method="post" action="{{route('questions.answers.destroy',[$question->id,$answer->id])}}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <span class="text-muted">Answered {{$answer->created_date}}</span>
                                    <div class="media mt-2">
                                        <a href="{{$answer->user->url}}" class="pr-2">
                                            <img src="{{$answer->user->avatar}}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $answer->user->url }}">{{$answer->user->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>