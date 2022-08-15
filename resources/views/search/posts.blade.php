@extends('layouts.main')

@section('content')
    <style>
        #img {
            width: 400px;
            height: 400px;
            margin-left: auto;
            margin-right: auto;
        }

    </style>

    <div class="container search-container">
        <p class="h1-content">Поиск по сайту</p>
        <form action="{{route('posts.search')}}" method="get"
              class="d-flex justify-content-between form-floating col-sm-12 col-md-12 col-lg-12">
            <input type="text" class="mr-3 form-control" name="search" value="{{request('search')}}"
                   placeholder="search">
            <label for="floatingInput">Введите текст</label>
            <button class=" search col-sm-12 col-md-2 col-lg-2">Искать</button>
        </form>
        <div class="mt-2">
            <a class="btn btn-primary" role="tab" href="{{route('search', ['search'=>request('search')])}}">Все</a>

            <a class="btn btn-primary" role="tab" href="{{route('exercises.search', ['search'=>request('search')])}}">Упражнения</a>

            <a class="btn btn-light" role="tab"
               href="{{route('posts.search', ['search'=>request('search')])}}">Новости</a>
        </div>
        <div class="search-content">
            <div class="row">
                @if($posts)
                    @forelse($posts as $post)
                        <a href="{{route('posts.show',$post->id)}}" class="col-sm-12 col-md-5 search-item"
                           style="text-decoration: none">
                            <span class="text-muted">Новость</span>
                            <p class="h1">{{$post->title}} </p>
                            <p>{!! str_replace("$search","<b>$search</b>", $post->body) !!}</p>
                        </a>

                    @empty
                        <p>Ничего не нашлось</p>
                    @endforelse
                @else
                    <img src="{{asset('storage/search/search.png')}}" class="mt-3" id="img" alt="Поиcк">
                @endif
            </div>
        </div>
        @if(isset($posts))
            <div class="card m-3 p-3">
                {{ $posts->withQueryString()->links() }}
            </div>
        @endif
    </div>

@endsection