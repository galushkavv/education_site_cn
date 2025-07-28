@extends('layout')

@section('content')
    @if(!empty($warnings))
    <div class="alert alert-warning">
        <ul>
            @foreach ($warnings as $warning)
                <li>{{ $warning }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Заголовок страницы -->
    <h1 class="mb-4">{{ $major->name }}</h1>

    <!-- Строка с одним блоком для текста -->
    <div class="row mb-4">
        <div class="col">
            <p>{!! $major->introduction !!}</p>
        </div>
    </div>

    <!-- Карточки университетов -->
    <div class="row mb-4">
        @if($universities->isNotEmpty())
            @foreach($universities as $university)
                <div class="col-md-6 mb-4">
                    <div class="card" style="border-radius: 10px; border: none; background-color: #f1f1f1;">
                        <div class="card-body p-3">
                            <img src="{{ asset('storage/' . $university->logo_path) }}" class="img-fluid float-start me-3 mb-3"
                                 style="object-fit: cover; width: 25%; aspect-ratio: 1;">
                            <h5 class="card-title">{{ $university->name }}</h5>
                            <p class="card-text">{{ $university->summary }}</p>
                        </div>
                        @if($university->picture_path != null)
                            <img src="{{ asset('storage/' . $university->picture_path) }}" class="card-img-bottom" alt="Product Image" style="object-fit: cover; height: 200px; border-radius: 0 0 10px 10px;">
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Четыре строки под секции текста -->
    <div class="row mb-4">
        <div class="col">
            <p>{!! $major->detailed_description !!}</p>
        </div>
    </div>

    <!-- Карточки преподавателей -->
    <div class="row mb-4">
        @if($teachers->isNotEmpty())
            @foreach($teachers as $teacher)
                <div class="col-md-6 mb-4">
                    <div class="card p-2" style="border-radius: 10px; border: none; background-color: #f1f1f1;">
                        <div class="card-body">
                            <img src="{{ asset('storage/' . $teacher->photo_path) }}" class="img-fluid float-start me-2 mb-2"
                                 style="object-fit: cover; width: 25%; aspect-ratio: 3 / 4; border-radius: 10px 10px 10px 10px; border: 1px solid #ccc;">
                            <h5 class="card-title">{{$teacher->first_name}} {{$teacher->last_name}}</h5>
                            <p class="card-text">{{$teacher->about}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="row mb-4">
        <div class="col">
            <p>{!! $major->subjects !!}</p>
        </div>
    </div>

    <!--div class="row mb-4">
        <div class="col">
            <p>Новости/события/реклама</p>
        </div>
    </div-->

    <style>
        .ratio-3x4 {
            position: relative;
            width: 100%;
            padding-top: 133.33%;
            overflow: hidden;
        }

        .ratio-3x4 > * {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .teacher-photo {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection
