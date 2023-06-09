@extends('admin.layouts.main')


@push('style')

    <link rel="stylesheet" href="{{ asset('css/simple-adaptive-slider.min.css') }}">
@endpush

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header m-3">
            <section>
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h1 class="m-0"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('admin.main.index')}}">Главная</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.settings.slider.index')}}">Слайдер</a></li>
                                <li class="breadcrumb-item active">Создание слайда</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    @if (session('success'))
                    <div class="m-3 alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3>Создание слайда</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.settings.slider.store')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- fillable inputs --}}

                                    <div class="col-sm-12 col-md-8">
                                        <div class="form-group">
                                            <label for="name">Название слайда</label>
                                            <input type="text" class="form-control " name="title"
                                                   placeholder="Название"
                                                   id="name" value="{{old('title')}}">
                                            @error('title')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Текст кнопки</label>
                                            <input type="text" class="form-control " name="button_name"
                                                   placeholder="Название"
                                                   id="name" value="{{old('button_name')}}">
                                            @error('button_name')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">

                                            <label for="location_url">url кнопки</label>
                                            <input type="text" class="form-control " name="button_link"
                                                   value="{{old('button_link')}}">
                                            @error('button_link')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    {{-- preview image(s) --}}
                                    <div class="col-sm-12 col-md-4">
                                        <div class="previews-container">
                                            <label>Превью загруженной картинки</label>
                                            <div class="image_container text-right mb-2">
                                                <div class="myslider">
                                                    <div class="slider__wrapper">
                                                        <div class="slider__items">
                                                            <div class="slider__item">
                                                                <div>
                                                                    <img src="" class="d-block w-100" alt="..."
                                                                         height="250"
                                                                         style="object-fit: cover">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <span class="image-text text-muted"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image"
                                                           id="image"
                                                           value="{{old('image')}}">
                                                    <label class="custom-file-label" for="exampleInputFile">Выберите
                                                        картинку</label>
                                                </div>
                                            </div>

                                            @error('image')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="  col-sm-12 col-md-12">

                                    <div class="form-group">
                                        <label for="summernote">Текст слайда</label>
                                        <textarea id="summernote" name="body">{{old('body')}}</textarea>
                                        @error('body')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>

                                <input type="submit" class="col-sm-12 col-md-6 col-lg-3 btn btn-primary"
                                       value="Добавить">
                            </form>
                        </div>


                    </div>
                </div>
            </section>
        </div>

        @endsection

        @push('script')
            <script src="{{  asset('scripts/simple-adaptive-slider.min.js') }}"></script>
            <script>
                let input = document.querySelector('.custom-file-input');
                let theSlider = document.querySelector('.myslider');
                input.addEventListener('change', function (event) {
                    if (event.target.files.length > 0) {
                        let imageText = document.querySelector('.image-text');
                        let slideWrapper = document.querySelector('.slider__wrapper');
                        slideWrapper.innerHTML = '';
                        imageText.innerHTML = '* Загруженное изображение';

                        const element = event.target.files[0];

                        let sliderItem = document.createElement('div');
                        sliderItem.classList.add('slider__item');
                        slideWrapper.appendChild(sliderItem);

                        let innerSlider = document.createElement('div');
                        sliderItem.appendChild(innerSlider);

                        let sliderImage = document.createElement('img');
                        sliderImage.classList.add('d-block');
                        sliderImage.classList.add('w-100');
                        sliderImage.height = 400;
                        sliderImage.style.objectFit = 'cover';
                        innerSlider.appendChild(sliderImage);

                        let src = URL.createObjectURL(element);
                        sliderImage.src = src;
                        sliderImage.style.display = "block";
                    }
                })
            </script>
    @endpush

