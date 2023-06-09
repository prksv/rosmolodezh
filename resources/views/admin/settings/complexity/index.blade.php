@extends('admin.layouts.main')

@push('style')
    @livewireScripts
    <style>
        .modal-dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            z-index: 2001;
            transform: translate(-50%, -50%);
        }
        .modal-bg {
            position: fixed;
            width: 100vw;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 2000;
            background: hsl(0 0% 0% /0.5)
        }
    </style>
@endpush

@section('content')

<div class="content-wrapper" style="padding-top: 1rem">
    <!-- Content Header (Page header) -->
    <div class="row d-flex justify-content-between mr-3 ml-3">
        <div class="col-sm-6">
            <h1 class="">Сложности и время на выполнение</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right ">
                <li class="breadcrumb-item"><a href="{{route('admin.main.index')}}">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.settings.index')}}">Настройки</a></li>
                <li class="breadcrumb-item active">Сложности и время на выполнение</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    <div class="col-12">
        @livewire('complexity-and-time-manage-component')
    </div>
</div>
@endsection

@push('script')
    @livewireScripts
@endpush
