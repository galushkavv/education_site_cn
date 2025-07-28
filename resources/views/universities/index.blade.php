@extends('layout')

@section('content')
    @isset($head)
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">{{ $head }}</h2>
        </div>
    </div>
    @endisset

    <div class="row">
        @if (isset($canEdit) && $canEdit === true)
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4">
                    <a href="{{ route('universities.create') }}" class="text-decoration-none text-dark">
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
                                        <h5 class="card-title fw-bold mb-3">{{ __('universities.add') }}</h5>
                                        <p class="card-text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif
        @foreach ($universities as $university)
            @if(!$university->hidden or $canEdit)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card align-items-start">
                    <a href="{{ route('universities.show', $university->id) }}" class="text-decoration-none text-dark">
                        <div class="card-body">
                            <img src="{{ asset('storage/' . $university->logo_path) }}" class="img-fluid float-start me-3 mb-3"
                                 style="object-fit: cover; width: 25%; aspect-ratio: 1; max-width: 150px;">
                            <h5 class="card-title"><b>{{ $university->name }}</b></h5>
                            <p class="card-text">{{ $university->summary }}</p>
                        </div>
                        @if($university->picture_path != null)
                        <img src="{{ asset('storage/' . $university->picture_path) }}" class="card-img-bottom" alt="Product Image" style="object-fit: cover; height: 200px;">
                        @endif
                    </a>
                    @if (isset($canEdit) && $canEdit === true)
                    <!-- Кнопки в верхнем правом углу -->
                    <div class="btn-group position-absolute top-0 end-0 p-1" role="group">
                        <!-- Редактирование -->
                        <form action="{{ route('universities.edit', $university->id) }}" method="GET" style="display: inline-block; margin: 0;" class="btn-group">
                            <button type="submit" class="btn btn-sm btn-outline-primary px-2" title="{{ __('menu.edit') }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </form>
                        <!-- Скрытие -->
                        @if($university->hidden)
                        <form action="{{ route('universities.unhide', $university->id) }}" method="POST" style="display: inline-block; margin: 0;" class="btn-group">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-info px-2" title="{{ __('menu.show') }}">
                                <i class="bi bi-eye"></i>
                            </button>
                        </form>
                        @else
                        <form action="{{ route('universities.hide', $university->id) }}" method="POST" style="display: inline-block; margin: 0;" class="btn-group">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-dark px-2" title="{{ __('menu.hide') }}">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </form>
                        @endif
                        <!-- Удаление -->
                        <form action="{{ route('universities.destroy', $university->id) }}" method="POST" class="btn-group" onsubmit="return confirm('{{ __('universities.confirmDelete') }}');" style="display: inline-block; margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger px-2" title="{{ __('menu.delete') }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        @endif
        @endforeach

        {{ $universities->links('pagination::bootstrap-5') }}
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
