@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">{{__('menu.teachers')}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
            <a href="{{ route('teachers.create') }}" class="text-decoration-none text-dark">
                <div class="card">
                    <div class="row g-0">
                        <!-- Колонка с иконкой добавления -->
                        <div class="col-3 col-md-2">
                            <div class="ratio ratio-3x4 position-relative">
                                <div class="d-flex align-items-center justify-content-center h-100 w-100 bg-light">
                                    <i class="bi bi-plus-lg add-icon"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Колонка с текстом -->
                        <div class="col-9 col-md-10 position-relative">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">{{ __('teachers.add') }}</h5>
                                <p class="card-text"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        @foreach ($teachers as $teacher)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card p-2" style="border-radius: 10px; border: none; background-color: #f1f1f1;">
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $teacher->photo_path) }}" class="img-fluid float-start me-2 mb-2"
                             style="object-fit: cover; width: 25%; aspect-ratio: 3 / 4; border-radius: 10px 10px 10px 10px; border: 1px solid #ccc; max-width: 150px;">
                        <h5 class="card-title">
                            {{$teacher->first_name}} {{$teacher->last_name}}
                            @if($teacher->translation_locale != app()->getLocale())
                                [{{ $teacher->translation_locale }}]
                            @endif
                        </h5>
                        <p class="card-text">{{$teacher->about}}</p>
                    </div>
                    <!-- Кнопки в верхнем правом углу -->
                    <div class="btn-group position-absolute top-0 end-0 p-1" role="group">
                        <!-- Редактирование -->
                        <form action="{{ route('teachers.edit', $teacher->id) }}" method="GET" style="display: inline-block; margin: 0;" class="btn-group">
                            <button type="submit" class="btn btn-sm btn-outline-primary px-2" title="{{ __('menu.edit') }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </form>
                        <!-- Удаление -->
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="btn-group" onsubmit="return confirm('{{ __('teachers.confirmDelete') }}');" style="display: inline-block; margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger px-2" title="{{ __('menu.delete') }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        {{ $teachers->links('pagination::bootstrap-5') }}
    </div>

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

        .add-icon {
            font-size: 4rem; /* Размер иконки */
            color: #6c757d;  /* Серый цвет иконки */
        }

        @media (max-width: 767.98px) {
            .add-icon {
                font-size: 2rem; /* Уменьшаем размер иконки на узких экранах */
            }
        }
    </style>

@endsection
