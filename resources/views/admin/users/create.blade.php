@extends('admin.layouts.main')


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Новости</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.main.index')}}">Главная</a></li>
                            <li class="breadcrumb-item active">Создание пользователя</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-12">
                    <form action="{{route('admin.users.store')}}" method="post" >
                        @csrf
                        <div class="form-group w-50">
                            <input type="text" class="form-control " name="login" placeholder="Логин" value="{{old('login')}}">
                            @error('login')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group w-50">
                            <input type="text" class="form-control " name="first_name" placeholder="Имя" value="{{old('first_name')}}">
                            @error('first_name')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group w-50">
                            <input type="text" class="form-control " name="last_name" placeholder="Название" value="{{old('last_name')}}">
                            @error('last_name')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group w-50">
                            <input type="text" class="form-control " name="father_name" placeholder="Название" value="{{old('father_name')}}">
                            @error('father_name')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>



                        <select class="form-control" name="role_id">
                            @foreach($roles as $role)
                            <option value="{{$role->id}}
                            {{$role->id==old('role_id') ?'selected':''}}">{{$role->title}}</option>
                            @endforeach
                        </select>
                        <input type="submit" class="btn btn-primary" value="Добавить">
                    </form>
                    </div>


                </div>
                <!-- /.row -->

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
    </div>


@endsection
