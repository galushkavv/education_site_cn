@extends('layout')

@section('top_of_page')
  <!-- Карусель без отступов -->
  <div class="container-fluid p-0">
    <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/slide1.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/slide2.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/slide3.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/slide4.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/slide5.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/slide6.jpg" class="d-block w-100" alt="...">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

@endsection

@section('content')
    <!-- Контент: текст и картинки -->
    <div class="row my-4">
      <div class="col-md-6">
        <h3 class="mb-4">Advantages of studying abroad in Russia and Belarus</h3>
        <h5 class="mb-3 fw-bold">Admission Advantages:</h5>
        <p>High school graduates do not need college entrance exam scores to apply. There is no voice requirement before applying for admission. You can study voice preparatory courses with zero basic knowledge and enter the undergraduate program in about one to one and a half years.</p>
        <h5 class="mb-3 fw-bold">Cost-effectiveness of the school:</h5>
        <p>Many Russian, Belarusian and Ukrainian universities are world-class universities with high academic qualifications and high-level teaching staff.</p>
      </div>
      <div class="col-md-6">
         <img src="img/welcome1.png" class="img-fluid" alt="Welcome Image 1">
      </div>
      <div class="col-lg-12 col-xl-6">
          <h5 class="mb-3 fw-bold">Tuition Advantages:</h5>
          <p>Except for art majors, the tuition fees for most majors are around 30,000-50,000 yuan, which is more than a quarter of the tuition fees in other European and American countries. In addition to the low tuition cost, the living consumption level is basically the same as in China, with monthly living expenses of around 2,000-3,000 yuan.</p>
      </div>
    </div>
    <div class="row my-4">
        <div class="col-md-4">
            <img src="img/welcome2.jpg" class="img-fluid" alt="Welcome Image 2">
        </div>
        <div class="col-md-8">
            <h5 class="mb-3 fw-bold">Visa Advantages:</h5>
            <p>Compared with the United States, the United Kingdom and other countries, studying abroad in Russia, Belarus, Ukraine and other countries has a high visa rate and a fast visa processing time due to international cooperation.</p>
            <h5 class="mb-3 fw-bold">Political advantage:</h5>
            <p>With the introduction of the "Belt and Road Initiative", the number of factories, offices and branches established by the Chinese government and large enterprises in Russian-speaking countries such as Russia, Belarus and Ukraine has increased rapidly. Among them, the China-Belarus Industrial Park is the pearl of the Silk Road Economic Belt, with huge potential in terms of talent demand. At the same time, the Ministry of Education of my country has implemented academic qualifications recognition with Russia, Belarus and Ukraine to provide guarantees for employment after returning to China.</p>
        </div>
    </div>

@endsection


@section('pre-footer')
<div class="w-100 bg-light py-4">
  <div class="container-lg">
    <div class="row">
      <!-- Содержимое нового блока -->
      <div class="col-12">
            <!-- Название карусели -->
    <div class="row">
      <div class="col-md-12 text-center">
        <h1 class="mb-4">International Study Tour</h1>
      </div>
    </div>
    <!--Нижняя карусель с картинками-->
    <div id="multi-item-carousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
          <div class="row">
            <div class="col-md-4">
              <img class="d-block w-100" src="{{ asset('storage/photos/1.jpg') }}" alt="First slide" data-bs-toggle="modal" data-bs-target="#imageModal">
            </div>
            <div class="col-md-4">
              <img class="d-block w-100" src="{{ asset('storage/photos/2.jpg') }}" alt="First slide" data-bs-toggle="modal" data-bs-target="#imageModal">
            </div>
            <div class="col-md-4">
              <img class="d-block w-100" src="{{ asset('storage/photos/3.jpg') }}" alt="First slide" data-bs-toggle="modal" data-bs-target="#imageModal">
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="row">
            <div class="col-md-4">
              <img class="d-block w-100" src="{{ asset('storage/photos/4.jpg') }}" alt="Second slide" data-bs-toggle="modal" data-bs-target="#imageModal">
            </div>
            <div class="col-md-4">
              <img class="d-block w-100" src="{{ asset('storage/photos/5.jpg') }}" alt="Second slide" data-bs-toggle="modal" data-bs-target="#imageModal">
            </div>
            <div class="col-md-4">
              <img class="d-block w-100" src="{{ asset('storage/photos/6.jpg') }}" alt="Second slide" data-bs-toggle="modal" data-bs-target="#imageModal">
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="row">
            <div class="col-md-4">
              <img class="d-block w-100" src="{{ asset('storage/photos/7.jpg') }}" alt="Second slide" data-bs-toggle="modal" data-bs-target="#imageModal">
            </div>
            <div class="col-md-4">
              <img class="d-block w-100" src="{{ asset('storage/photos/8.jpg') }}" alt="Second slide" data-bs-toggle="modal" data-bs-target="#imageModal">
            </div>
            <div class="col-md-4">
              <img class="d-block w-100" src="{{ asset('storage/photos/9.jpg') }}" alt="Second slide" data-bs-toggle="modal" data-bs-target="#imageModal">
            </div>
          </div>
        </div>
        <!-- Дополнительные слайды -->
      </div>

      <!-- Элементы управления каруселью -->
      <button class="carousel-control-prev" type="button" data-bs-target="#multi-item-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#multi-item-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
      </button>
    </div>


      <!-- Модальное окно -->
      <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" id="modalImage" class="img-fluid" alt="Modal Image">
                </div>
            </div>
        </div>
    </div>
      </div>
    </div>
  </div>
</div>
@endsection
