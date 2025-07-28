@extends('layout')

@section('content')
    <div class="row mt-4 mb-4">
        @if($canEdit)
            <div class="col-xl-4 col-lg-6 col-md-12 mb-4">
                <div class="card" style="border-radius: 10px; border: none; overflow: hidden; background-color: #f1f1f1;">
                    <a href="{{route('majors.create')}}" class="text-decoration-none text-dark">
                        <!-- Часть 1: Картинка -->
                        <img src="/storage/images/new2.jpg" class="card-img-top" alt="Product Image" style="object-fit: cover; height: 200px;">
                        <!-- Часть 2: Название и краткая характеристика -->
                        <div class="card-body">
                            <h4 class="card-title"><b>{{ __('majors.add') }}</b></h4>
                        </div>
                    </a>
                    <!-- Часть 3: Дополнительная информация -->
                    <div class="card-body position-relative" style="background-color: #e0e0e0;">
                        <h5></h5>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($majors as $major)
            @if(!$major->hidden or $canEdit)
                <div class="col-xl-4 col-lg-6 col-md-12 mb-4">
                    <div class="card" style="border-radius: 10px; border: none; overflow: hidden; background-color: #f1f1f1;">
                        @if($canEdit)
                        <!-- Кнопки в верхнем правом углу -->
                        <div class="position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                            <a href="{{ route('majors.edit', $major->id) }}" class="btn btn-primary btn-sm me-1" title="{{ __('menu.edit') }}">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($major->hidden)
                                <form action="{{ route('majors.unhide', $major->id) }}" method="POST" style="display: inline-block; margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-light btn-sm me-1" title="{{ __('menu.show') }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('majors.hide', $major->id) }}" method="POST" style="display: inline-block; margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-dark btn-sm me-1" title="{{ __('menu.hide') }}">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('majors.destroy', $major->id) }}" method="POST" onsubmit="return confirm('{{ __('majors.confirmDelete') }}');" style="display: inline-block; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="{{ __('menu.delete') }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif

                        <a href="{{route('majors.show', $major->id)}}" class="text-decoration-none text-dark">
                        <!-- Часть 1: Картинка -->
                        <img src="{{ asset('storage/' . $major->image_path) }}" class="card-img-top" alt="Product Image" style="object-fit: cover; height: 200px;">
                        <!-- Часть 2: Название и краткая характеристика -->
                        <div class="card-body">
                            <h4 class="card-title">
                                {{$major->name}}
                                    @if($major->translation_locale != app()->getLocale())
                                        [{{ $major->translation_locale }}]
                                    @endif
                                </h4>
                            <p class="card-text">{{$major->summary}}</p>
                        </div>
                        </a>
                        <!-- Часть 3: Дополнительная информация -->
                        <div class="card-body position-relative" style="background-color: #e0e0e0;">
                            @if($major->universities->isNotEmpty())
                            <h5>{{ __('majors.studyIn') }}</h5>
                            <!-- Маленькие квадратные изображения -->
                            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                @foreach($major->universities as $university)
                                <a href="{{route('universities.show', $university->id)}}"><img src="{{ asset('storage/' . $university->logo_path) }}" class="img-fluid me-2"
                                         style="object-fit: cover; width: 50px; height: 50px;"
                                         alt="University Logo"></a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    {{ $majors->links('pagination::bootstrap-5') }}
@endsection
