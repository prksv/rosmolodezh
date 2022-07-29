@extends('admin.layouts.main')


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.main.index')}}">Главная</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.tracks.index')}}">Направления</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('admin.tracks.show', $track->id) }}">{{$track->title}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('admin.tracks.blocks.show',[$track->id, $block->id] )}}">{{$block->title}}</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                >{{$exercise->title}}</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class=" row align-items-center">

                            <h1 class="col-sm-12 col-lg-8">Упражнение: "{{ $exercise->title }}"</h1>
                            <div class="col-sm-12 col-lg-4 d-flex justify-content-md-end">

                                <a class="btn btn-info mr-2" href="{{route('admin.blocks.exercises.edit', [$block->id, $exercise->id])}}">Изменить <i
                                        class="fa fa-pen"></i></a>

                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#deleteTrack">Удалить
                                </button>

                            </div>
                            <x-modal name="Вы уверены что хотите удалить это упражнение?" type="delete"
                                     action="{{route('admin.blocks.exercises.destroy',[$block->id, $exercise->id])}}"
                                     targetid="deleteTrack">
                            </x-modal>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="block_name ">
                                    <h4>Траектория: "{{$track->title}}"</h4>
                                </div>
                                <div class="block_name  ">
                                    <h5>Блок: "{{$block->title}}"</h5>
                                </div>
                                <div>
                                    <span>Уровень освоения: </span>
                                    <h5 style="display: inline"><span
                                            title="Уровень:{{ $exercise->complexity->body }}"
                                            class="badge
                                                            @if ($exercise->complexity_id == 1) badge badge-primary @endif
                                                            @if ($exercise->complexity_id == 3) badge badge-warning @endif
                                                            @if ($exercise->complexity_id == 4) badge badge-danger @endif
                                                            @if ($exercise->complexity_id == 5) badge badge-danger @endif
                                                            @if ($exercise->complexity_id == 2) badge badge-success @endif
                                                            ">
                                        {{ $exercise->complexity->level }}
                                        </span>
                                    </h5>

                                </div>
                                <span> Время на выполнение:</span>
                                <h5 style="display: inline">
                                                        <span
                                                            class="
                                                        @if ($exercise->time <= 15) badge badge-primary
                                                        @elseif($exercise->time <= 30) badge badge-success
                                                        @elseif($exercise->time <= 60) badge badge-warning
                                                        @elseif($exercise->time <= 120) badge badge-danger
                                                        @elseif($exercise->time <= 240) badge badge-danger
                                                        @else badge badge-dark @endif
                                                        ">
                                                            {{ $exercise->time }} {{ $exercise->name_minute_count }}
                                                        </span>
                                </h5>
                                <div>

                                </div>
                            </div>
                            <table class="tack_text track_table">
                                <tr>
                                    <td>Куратор направления:</td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $track->curator_id) }}">{{
                                        $track->curator->all_names }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Всего обучающихся:</td>
                                    <td>{{ $track->users_count }} {{$track->name_users_count}}</td>
                                </tr>
                                <tr>
                                    <td>Ответов:</td>
                                    <td>
                                    {{ $exercise->answers_added_count }}/{{$track->users_count}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Оценено:</td>
                                    <td>{{$exercise->mark_count }}/{{ $track->users_count}}</td>
                                </tr>
                                <tr>
                                    <td>Успеваемость:</td>
                                    <td><span class="status_block status_success">{{ $exercise->academic_performance_percent }} %</span></td>
                                </tr>
                                <tr>

                                    <td>Средний балл:</td>
                                    <td><span class="status_block status_success">{{$exercise->average_score}}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <a class="btn btn-info mr-2" href="{{route('admin.exercises.answers.index', $exercise->id)}}">Ответы учеников <i
                            class="fa fa-eye"></i></a>

                </div>

            </div>

        </div>

        {{--        Body of exercise--}}

        <div class="p-2 p-md-4 card">
            <div class="card-body p-2 p-md-3">
                <div class="hexlet-markdown-body overflow-hidden">
                    <div class="mb-4 position-relative d-inline-block">
                        <h1 class="my-0 d-flex flex-column-reverse">
                            {{$exercise->title}}
                            <span class="sr-only">—</span>
                        </h1>
                    </div>
                    <div>
                        {!!$exercise->body!!}
                    </div>
                    <hr class="mt-5">
                    <div class="d-flex flex-wrap flex-lg-nowrap mt-md-4 pt-lg-2 align-items-start">

                        <div class="mt-3 mt-lg-0 w-100">
                            <h3 class=" fw-bold mb-0 lh-base">Ссылки к упражнению:</h3>
                        </div>
                    </div>
                    @forelse($exercise->links as $link)
                        <div>
                            <a href="{{$link->url}}">{{$link->name}}</a>
                        </div>
                    @empty
                        <div>Ссылок нет :(</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

