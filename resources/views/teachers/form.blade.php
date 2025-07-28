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
              action="{{ isset($teacher) ? route('teachers.update', $teacher->id) : route('teachers.store') }}"
              method="POST"
              enctype="multipart/form-data"
              style="width: 100%;">
            @csrf
            @if(isset($teacher))
                @method('PUT')
            @endif

            <!-- Скрытое поле для хранения teacher_id -->
            <input type="hidden" id="teacherId" value="{{ isset($teacher) ? $teacher->id : '' }}">

            <!-- Контейнер с двумя колонками -->
            <div class="row">
                <!-- Левая колонка с полями -->
                <div id="leftColumn" class="col-lg-6 col-md-12">
                    <!-- Фамилия -->
                    <div class="mb-3">
                        <label for="lastName" class="form-label">{{ __('teachers.surname') }}</label>
                        <input type="text" class="form-control" id="lastName" name="last_name"
                               value="{{ isset($teacher) ? $teacher->last_name : '' }}"
                               placeholder="{{ __('teachers.placeholderEnterSurname') }}">
                    </div>

                    <!-- Имя -->
                    <div class="mb-3">
                        <label for="firstName" class="form-label">{{ __('teachers.name') }}</label>
                        <input type="text" class="form-control" id="firstName" name="first_name"
                               value="{{ isset($teacher) ? $teacher->first_name : '' }}"
                               placeholder="{{ __('teachers.placeholderEnterName') }}">
                    </div>

                    <!-- Отчество -->
                    <div class="mb-3">
                        <label for="middleName" class="form-label">{{ __('teachers.patronymic') }}</label>
                        <input type="text" class="form-control" id="middleName" name="middle_name"
                               value="{{ isset($teacher) ? $teacher->middle_name : '' }}"
                               placeholder="{{ __('teachers.placeholderEnterPatronymic') }}">
                    </div>

                    <!-- Фотография -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">{{ __('teachers.photo') }}</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>

                    <!-- Страна -->
                    <div class="mb-3">
                        <label for="country" class="form-label">{{ __('teachers.country') }}</label>
                        <select class="form-select" id="country" name="country">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ isset($teacher) && $teacher->country->id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Поле для ввода информации о преподавателе -->
                    <div class="mb-3 mt-3">
                        <label for="about" class="form-label">{{ __('teachers.about') }}</label>
                        <textarea class="form-control" id="about" name="about" rows="5">{{ isset($teacher) ? $teacher->about : '' }}</textarea>
                    </div>
                </div>

                <!-- Правая колонка для предпросмотра карточки -->
                <div id="rightColumn" class="col-lg-6 col-md-12">
                    <h3 class="text-center mb-4">{{ __('teachers.cardPreview') }}</h3>
                    <div class="card p-2" style="border-radius: 10px; border: none; background-color: #f1f1f1;">
                        <div class="card-body">
                            <img src="{{ isset($teacher) ? asset('storage/' . $teacher->photo_path) : asset('storage/placeholder_person_photo.png') }}" class="img-fluid float-start me-2 mb-2" id="card-photo"
                                 style="object-fit: cover; width: 25%; aspect-ratio: 3 / 4; border-radius: 10px 10px 10px 10px; border: 1px solid #ccc;">
                            <h5 class="card-title">{{ isset($teacher) ? $teacher->first_name . ' ' . $teacher->last_name : __('teachers.name') . ' ' . __('teachers.surname')}}</h5>
                            <p class="card-text">{{ isset($teacher) ? $teacher->about : __('teachers.about') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Кнопка отправки -->
            <button type="submit" class="btn btn-lg btn-primary">{{ isset($teacher) ? __('teachers.update') : __('teachers.save') }}</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Получаем элементы формы
            const lastNameInput = document.getElementById('lastName');
            const firstNameInput = document.getElementById('firstName');
            const aboutInput = document.getElementById('about');
            const photoInput = document.getElementById('photo');

            // Получаем элементы карточки
            const cardTitle = document.querySelector('.card-title');
            const cardPhoto = document.getElementById('card-photo');
            const cardAbout = document.querySelector('.card-text');

            function updateTitle() {
                const lastName = lastNameInput.value;
                const firstName = firstNameInput.value;
                cardTitle.textContent = `${firstName} ${lastName}`;
            }

            lastNameInput.addEventListener('input', updateTitle);
            firstNameInput.addEventListener('input', updateTitle);

           // Обновляем заголовок карточки при вводе в поле "Название"
            aboutInput.addEventListener('input', function() {
                cardAbout.textContent = aboutInput.value ? aboutInput.value : '{{ __('teachers.about') }}';
            });

            // Обрабатываем выбор картинки для предварительного просмотра
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                const reader = new FileReader();

                // Когда файл загружен, обновляем логотип в карточке
                reader.onload = function(e) {
                    cardPhoto.src = e.target.result;
                };

                // Читаем содержимое файла как Data URL
                reader.readAsDataURL(file);
            }
        });
        });

    </script>

    <style>
        /* Переменные CSS для хранения высоты левой колонки */
        :root {
            --left-column-height: 0px;
        }

        #rightColumn {
            position: relative;
        }

        #imageWrapper {
            position: absolute;
            top: 0;
            right: 0;
            width: calc(0.75 * var(--left-column-height));
            height: var(--left-column-height);
        }

        #imagePreview {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #imagePreview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

@endsection
