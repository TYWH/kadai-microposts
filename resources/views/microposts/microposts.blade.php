<ul class="media-list">
    @foreach ($microposts as $micropost)
        <li class="media mb-3">
            <img class="mr-2 rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
            {{-- Gravatar::srcの50の意味は、画像サイズ50*50のことっぽい --}}
            <div class="media-body">
                <div>
                    {!! link_to_route("users.show",$micropost->user->name,["id" => $micropost->user->id]) !!} <span class="text-muted">posted ad {{ $micropost->created_at }}</span>
                </div>
                <div>
                    <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                    {{-- eはechoのラッパー関数 --}}
                </div>
                <div>
                    @include("favorite.favorite_button",["micropost" => $micropost])
                    @if (Auth::id() == $micropost->user_id)
                        {!! Form::open(["route" => ["microposts.destroy",$micropost->id],"method" => "delete"]) !!}
                            {!! Form::submit("Delete",["class" => "btn btn-danger btn-sm"]) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
{{ $microposts->render("pagination::bootstrap-4") }}