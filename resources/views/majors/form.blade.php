@extends('layout')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-4">
        <form class="mb-4"
              action="{{ isset($major) ? route('majors.update', $major->id) : route('majors.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="major_form">
            @csrf
            @if(isset($major))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <!-- Название -->
                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('majors.title') }}</label>
                        <input type="text" class="form-control" id="title" name="name"
                               value="{{ isset($major) ? $major->name : '' }}"
                               placeholder="{{ __('majors.placeholderEnterTitle') }}">
                    </div>

                    <!-- Краткое описание -->
                    <div class="mb-3">
                        <label for="shortDescription" class="form-label">{{ __('majors.shortDescription') }}</label>
                        <textarea class="form-control" id="shortDescription" name="short_description" rows="3" placeholder="{{ __('majors.placeholderEnterShortDescription') }}">{{ isset($major) ? $major->summary : '' }}</textarea>
                    </div>

                    <!-- Картинка -->
                    <div class="mb-3">
                        <label for="image" class="form-label">{{ __('majors.picture') }}</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <!-- Университеты (выпадающий список для выбора нескольких) -->
                    <div class="mb-3">
                        <label for="universities" class="form-label">{{ __('majors.universities') }}</label>
                        <select class="form-select" id="universities" name="universities[]" multiple>
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}" {{ in_array($university->id, $major->university_ids ?? []) ? 'selected' : '' }}>
                                    {{ $university->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">{{ __('majors.hint') }}</small>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <h3 class="text-center mb-4">{{ __('majors.cardPreview') }}</h3>
                    <div class="card" style="border-radius: 10px; border: none; overflow: hidden; background-color: #f1f1f1;">
                            <!-- Часть 1: Картинка -->
                            <img src="{{ isset($major) ? asset('storage/' . $major->image_path) : asset('storage/images/placeholder_major_image.gif') }}" class="card-img-top" alt="Major image" style="object-fit: cover; height: 200px;">
                            <!-- Часть 2: Название и краткая характеристика -->
                            <div class="card-body">
                                <h4 class="card-title"><b>{{ isset($major) ? $major->name : __('majors.title') }}</b></h4>
                                <p class="card-text">{{ isset($major) ? $major->summary : __('majors.shortDescription') }}</p>
                            </div>
                        <!-- Часть 3: Дополнительная информация -->
                        <div class="card-body position-relative" style="background-color: #e0e0e0;">
                            <h5>{{ __('majors.studyIn') }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Вступление -->
            <div class="mb-3">
                <label for="introduction" class="form-label">{{ __('majors.introduction') }}</label>
                <textarea class="form-control" id="introduction" name="introduction" rows="3" placeholder="{{ __('majors.placeholderEnterIntroduction') }}">{{ isset($major) ? $major->introduction : '' }}</textarea>
            </div>

            <!-- Подробное описание с TinyMCE -->
            <div class="mb-3">
                <label for="detailed_description" class="form-label">{{ __('majors.detailedDescription') }}</label>
                <textarea class="form-control" id="detailed_description" name="detailed_description">{{ isset($major) ? $major->detailed_description : '' }}</textarea>
            </div>

            <!-- Преподаватели (выпадающий список для выбора нескольких) -->
            <div class="mb-3">
                <label for="teachers" class="form-label">{{ __('majors.teachers') }}</label>
                <select class="form-select" id="teachers" name="teachers[]" multiple>
                    @foreach ($teachers as $teacher)
                    <option value="{{$teacher->id}}" {{ in_array($teacher->id, $major->teacher_ids ?? []) ? 'selected' : '' }}>
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">{{ __('majors.hint') }}</small>
            </div>

            <!-- Список предметов с TinyMCE -->
            <div class="mb-3">
                <label for="subjects" class="form-label">{{ __('majors.subjects') }}</label>
                <textarea class="form-control" id="subjects" name="subjects">{{ isset($major) ? $major->subjects : '' }}</textarea>
            </div>

            <!-- Кнопка отправки -->
            <button type="submit" class="btn btn-lg btn-primary">{{ isset($major) ? __('majors.update') : __('majors.save') }}</button>
        </form>
    </div>

    <!-- Подключение TinyMCE -->
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        // Перенос текста из полей ввода и загрузки файлов в предпросмотр карточки образоватлеьной программы
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            const shortDescriptionInput = document.getElementById('shortDescription');
            const imageInput = document.getElementById('image');
            const universitiesInput = document.getElementById('universities');

            const cardTitle = document.querySelector('.card-title');
            const cardText = document.querySelector('.card-text');
            const cardImage = document.querySelector('.card-img-top');
            const cardBottom = document.getElementById('universities_logo');

            titleInput.addEventListener('input', function() {
                cardTitle.textContent = titleInput.value ? titleInput.value : '{{ __('majors.title') }}';
            });

            shortDescriptionInput.addEventListener('input', function() {
                cardText.textContent = shortDescriptionInput.value ? shortDescriptionInput.value : '{{ __('majors.shortDescription') }}';
            });

            // Обработка выбора картинки
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        cardImage.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                }
            });
        });

        // Общая функция для инициализации TinyMCE
        function initializeTinyMCE(selector, options = {}) {
            tinymce.init(Object.assign({
                selector: selector,
                plugins: 'lists preview',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | preview',
                branding: false,
                height: 400,
                content_style: 'body { padding: 10px; }',
                content_css: '/css/bootstrap.min.css'
            }, options));
        }

        // Подключение TinyMCE к полям ввода без картинок
        initializeTinyMCE('#introduction');
        initializeTinyMCE('#subjects');

        // Подключение TinyMCE к полям ввода со вставкой изображений
        initializeTinyMCE('#detailed_description', {
            plugins: 'image table paste preview',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview',

            setup: function (editor) {
                editor.on('NodeChange', function (e) {
                    if (e.element.nodeName === 'IMG') {
                        e.element.classList.add('img-fluid', 'me-3', 'mb-3');  // Добавление классов Bootstrap с отступами к вставленной картинке
                    }
                });
            }
        });

        /*
        document.getElementById('major_form').addEventListener('submit', function (e) {
            e.preventDefault(); // Предотвращает стандартное поведение

            tinymce.triggerSave();

            var content = tinymce.get('detailed_description').getContent();

            var formData = new FormData(this);
            formData.set('detailed_description', content); // Обновляем поле с контентом из TinyMCE

            // Отправляем данные на сервер
            fetch(this.action, {
                method: this.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                credentials: 'same-origin' // Включаем отправку куки при необходимости
            })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Ошибка при отправке данных');
                })
                .then(data => {
                    console.log('Успех:', data)
                    if (data.success) {
                        window.location.href = data.redirect_url;
                    }
                })
                .catch(error => {
                    console.error('Произошла ошибка:', error);
                });
        });
        */
    </script>
@endsection
