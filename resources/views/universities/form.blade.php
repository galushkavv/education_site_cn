@extends('layout')

@section('content')
    @if ($errors->any())
        <!-- Место для вывода сообщений об ошибках -->
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
              action="{{ isset($university) ? route('universities.update', $university->id) : route('universities.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="university_form">
            @csrf
            @if(isset($university))
                @method('PUT')
            @endif

            <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <!-- Название -->
                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('universities.name') }}</label>
                        <input type="text" class="form-control" id="title" name="name"
                               value="{{ isset($university) ? $university->name : old('name') }}"
                               placeholder="{{ __('universities.placeholderEnterName') }}">
                    </div>

                    <!-- Страна -->
                    <div class="mb-3">
                        <label for="country" class="form-label">{{ __('universities.country') }}</label>
                        <select class="form-select" id="country" name="country">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ isset($university) && $university->country->id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Краткое описание для карточки -->
                    <div class="mb-3">
                        <label for="shortDescription" class="form-label">{{ __('universities.shortDescription') }}</label>
                        <textarea class="form-control" id="shortDescription" name="short_description" rows="6" placeholder="{{ __('universities.placeholderEnterShortDescription') }}">{{ isset($university) ? $university->summary : old('short_description') }}</textarea>
                    </div>

                    <!-- Логотип -->
                    <div class="mb-3">
                        <label for="image" class="form-label">{{ __('universities.logo') }}</label>
                        <input type="file" class="form-control" id="logo" name="logo">
                    </div>

                    <!-- Дополнительное фото -->
                    <div class="mb-3">
                        <label for="additional_image" class="form-label">{{ __('universities.picture') }}</label>
                        <input type="file" class="form-control" id="picture" name="picture">
                    </div>
                </div>
                <!-- Правая колонка с предпросмотром карточки университета -->
                <div class="col-lg-6 col-md-12">
                    <h3 class="text-center mb-4">{{ __('universities.cardPreview') }}</h3>
                    <div class="card align-items-start">
                        <div class="card-body">
                            <img src="{{ isset($university) ? asset('storage/'. $university->logo_path) : asset('storage/images/placeholder_university_logo.png') }}" class="img-fluid float-start me-3 mb-3"
                                 style="object-fit: cover; width: 25%; aspect-ratio: 1;" id="pic_logo" alt="Teacher photo">
                            <h5 class="card-title"><b>{{ isset($university) ? $university->name : '' }}</b></h5>
                            <p class="card-text">{{ isset($university) ? $university->summary : '' }}</p>
                        </div>
                        <img src="{{ isset($university) ? asset('storage/' . $university->picture_path) : asset('storage/images/placeholder_university_picture.png') }}" class="card-img-bottom" alt="University Image" style="object-fit: cover; height: 200px;">
                    </div>
                </div>
            </div>

            <!-- Статья -->
            <div class="mb-3">
                <label for="detailed_description" class="form-label">{{ __('universities.detailedDescription') }}</label>
                <textarea class="form-control" id="detailed_description" name="detailed_description">{!! isset($university) ? $university->article : old('detailed_description') !!}</textarea>
            </div>

            <!-- Кнопка отправки -->
            <button type="submit" class="btn btn-lg btn-primary">{{ isset($university) ? __('universities.update') : __('universities.save') }}</button>
        </form>
    </div>

    <!-- Подключение TinyMCE -->
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>

    <script>
        // Перенос текста из полей ввода и загрузки файлов в предпросмотр карточки университета
        document.addEventListener('DOMContentLoaded', function()
        {
            const titleInput = document.getElementById('title');
            const shortDescriptionInput = document.getElementById('shortDescription');
            const logoInput = document.getElementById('logo');
            const pictureInput = document.getElementById('picture');

            const cardTitle = document.querySelector('.card-title');
            const cardText = document.querySelector('.card-text');
            const cardLogo = document.getElementById('pic_logo');
            const cardBottomPicture = document.querySelector('.card-img-bottom');

            titleInput.addEventListener('input', function()
            {
                cardTitle.textContent = titleInput.value ? titleInput.value : 'Название продукта';
            });

            shortDescriptionInput.addEventListener('input', function()
            {
                cardText.textContent = shortDescriptionInput.value ? shortDescriptionInput.value : 'Описание продукта';
            });

            // Обработка выбора картинки логотипа
            logoInput.addEventListener('change', function(event)
            {
                const file = event.target.files[0];
                if (file)
                {
                    const reader = new FileReader();
                    reader.onload = function(e)
                    {
                        cardLogo.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Обработка выбора дополнительной картинки
            pictureInput.addEventListener('change', function(event)
            {
                const file = event.target.files[0];
                if (file)
                {
                    const reader = new FileReader();
                    reader.onload = function(e)
                    {
                        cardBottomPicture.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
/*
        document.getElementById('university_form').addEventListener('submit', function (e)
        {
            e.preventDefault(); // Предотвращает стандартное поведение

            var content = tinymce.get('detailed_description').getContent();

            var formData = new FormData(this);
            formData.set('detailed_description', content);

            fetch(this.action, {
                method: this.method,
                body: formData,
                headers: {'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value},
                credentials: 'same-origin'
            })
            .then(response =>
            {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Ошибка при отправке данных');
            })
            .then(data =>
            {
                if (data.success)
                {
                    window.location.href = data.redirect_url;
                }
            })
            .catch(error =>
            {
                console.error('Произошла ошибка:', error);
            });
        });
*/
        // Инициализация tinyMCE
        tinymce.init({
            selector: '#detailed_description',
            height: 1000,
            plugins: 'image table paste preview',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image table preview',
            contextmenu: 'image',
            branding: false,
            content_style: 'body { padding: 10px; }',
            content_css: '/css/bootstrap.min.css',

            setup: function (editor)
            {
                editor.on('NodeChange', function (e)
                {
                    if (e.element.nodeName === 'IMG')
                    {
                        e.element.classList.add('me-3', 'mb-3');
                    }
                });

                editor.on('Change KeyUp', function ()
                {
                    const content = editor.getContent();
                    localStorage.setItem('tinymceContent', content);
                });
            },
        });
    </script>

@endsection
