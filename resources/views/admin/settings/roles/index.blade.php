@extends('admin.layouts.main')


@section('content')
    <div class="content-wrapper" style="padding-top: 1rem">
        <!-- Content Header (Page header) -->
        <div class="row d-flex justify-content-between mr-3 ml-3">
            <div class="col-sm-6">
                <h1 class="">Управление ролями</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{route('admin.main.index')}}">Главная</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.settings.index')}}">Настройки</a></li>
                    <li class="breadcrumb-item active">Управление ролями</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row m-3">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class=" table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Разрешения</th>
                                <th colspan="2">Управление</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td class="d-flex flex-wrap">
                                        @foreach ($role->permissions as $permission)
                                            <span class="badge bg-info m-1">{{ $permission->readable_title }}</span>
                                        @endforeach
                                    </td>
                                    <td class="w-25">
                                        <div class="">
                                            <a href="{{ route('admin.settings.roles.edit', $role->id) }}"
                                               class="btn btn-block btn-success btn-sm ">Изменить</a>
                                        </div>
                                    </td>
                                    <td class="w-25">
                                        <form action="{{route('admin.settings.roles.destroy', $role->id)}} " method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-block btn-danger btn-sm">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td></td>
                                    <td>Таблица пуста</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="col-3 mt-3">
                    <a href="{{route('admin.settings.roles.create')}}"
                       class="btn btn-block btn-primary">Добавить</a>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

@endsection
