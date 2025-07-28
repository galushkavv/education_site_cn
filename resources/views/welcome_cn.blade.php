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
        <h3 class="mb-4">俄罗斯、 白俄罗斯及乌克兰出国留学的优势</h3>
        <h5 class="mb-3 fw-bold">入学优势:</h5>
        <p>高中毕业无需高考成绩也可申请, 申请入学前没有语音要求, 可零基础就读语音预科, 一年至一年半左右就
        可以顺利进入本科。</p>

          <h5 class="mb-3 fw-bold">学费优势:</h5>
          <p>除艺术类专业外, 大部分专业的学费在3-5W左右, 对比其他欧美国家的学费是其学费的四分之一还多。 除
              学费成本低以外, 生活消费水平也与国内基本相同, 每月生活开销在2000-3000 人民币左右。</p>
      </div>
      <div class="col-md-6">
          <img src="img/welcome1.png" class="img-fluid" alt="Welcome Image 1">
      </div>
      <div class="col-lg-12 col-xl-6">
          <h5 class="mb-3 fw-bold">学校性价比优势:</h5>
          <p>许多俄罗斯、 白俄罗斯和乌克兰大学, 都是世界级名校, 学历含金量高, 教师教学水平高</p>
      </div>
    </div>
    <div class="row my-4">
        <div class="col-md-4">
            <img src="img/welcome2.jpg" class="img-fluid" alt="Welcome Image 2">
        </div>
        <div class="col-md-8">
            <h5 class="mb-3 fw-bold">签证优势:</h5>
            <p>对比美国、 英国等国家, 去俄罗斯、 白俄罗斯和乌克兰等国家留学, 因为国际合作关系, 签证率高, 签证时间快。</p>
            <h5 class="mb-3 fw-bold">政策优势:</h5>
            <p>伴随着 “一带一路” 的提出我国政府、 大型企业在俄罗斯、 白俄罗斯及乌克兰等俄语国家建立的工厂、 办事
                处、 分支机构数量迅速增加, 其中中白工业园更是堪称丝绸之路经济带上的明珠, 人才需求方面潜力巨大。 同时
                我国教育部与俄罗斯、 白俄罗斯和乌克兰等国家实行了学历互认, 为回国就业提供保障。</p>
        </div>
    </div>
    <div class="row my-4">
      <div class="col-md-12">
      <img src="img/welcome4.jpg" class="img-fluid" alt="Welcome Image 4">
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
        <h1 class="mb-4">国际游学</h1>
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
