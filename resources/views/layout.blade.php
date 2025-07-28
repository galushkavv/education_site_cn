@php
    $currentLocale = App::getLocale();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{__('menu.title')}}</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">

  <link href="{{ asset('css/site.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100" style="min-width: 500px;">

  <!-- Header -->
  <div class="bg-light py-2">
    <div class="container-lg d-flex flex-column flex-md-row justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <img src="{{ asset('img/logo3.png') }}" alt="Logo" class="me-2" style="height: 60px;">
        <span class="navbar-brand d-block mb-0" style="color: #ee0000;">
          <div class="fs-3">河南海客出国留学服务有限公司</div>
          <div class="fs-5">Henan Haike overseas study Service Co., Ltd</div>
        </span>
      </div>
      <div class="d-flex flex-row ms-auto">
        <div class="d-flex flex-row text-end align-items-center text-nowrap">
          <span class="mb-2 mb-sm-0 fs-5">
            <i class="bi bi-clock fs-4"></i> {{__('menu.work_time')}}: 9:30 - 18:30
          </span>
          <span class="ms-4 fs-4">
            <i class="bi bi-telephone"></i> 15937920288
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-lg container-fluid text-nowrap">
            <a class="nav-link fs-5 text-white-50 d-lg-none" href="#">{{__('menu.home')}}</a>
            <div class="d-flex d-lg-none ms-auto align-items-center">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="me-2 mb-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                @endauth
                <div class="btn-group text-nowrap me-2">
                    <input type="radio" class="btn-check" name="btnradio-mobile" id="lang-cn-mobile" @if ($currentLocale == 'cn') checked @endif onclick="changeLanguage('cn')">
                    <label class="btn btn-outline-danger" for="lang-cn-mobile">中文</label>
                    <input type="radio" class="btn-check" name="btnradio-mobile" id="lang-en-mobile" @if ($currentLocale == 'en') checked @endif onclick="changeLanguage('en')">
                    <label class="btn btn-outline-primary" for="lang-en-mobile">&nbsp;EN&nbsp;</label>
                    <input type="radio" class="btn-check" name="btnradio-mobile" id="lang-ru-mobile" disabled>
                    <label class="btn btn-outline-success" for="lang-ru-mobile">&nbsp;РУ&nbsp;</label>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto fs-5">
                    <li class="nav-item">
                        <a class="nav-link{{ Request::is('/') ? ' bg-secondary text-white' : '' }}" href="/">{{__('menu.home')}}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle{{ Request::is('about*') ? ' bg-secondary text-white' : '' }}" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          {{__('menu.about')}}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark fs-5" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('about') }}">{{__('menu.company')}}</a></li>
                            <li><a class="dropdown-item" href="{{ route('contacts') }}">{{__('menu.contacts')}}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle{{ Request::is('universities*') ? ' bg-secondary text-white' : '' }}" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{__('menu.universities')}}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark fs-5" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('universities.byCountry', ['country' => 'china']) }}">{{__('menu.china')}}</a></li>
                            <li><a class="dropdown-item" href="{{ route('universities.byCountry', ['country' => 'russia']) }}">{{__('menu.russia')}}</a></li>
                            <li><a class="dropdown-item" href="{{ route('universities.byCountry', ['country' => 'belarus']) }}">{{__('menu.belarus')}}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ Request::is('majors*') ? ' bg-secondary text-white' : '' }}" href="/majors">{{__('menu.majors')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ Request::is('enrollment') ? ' bg-secondary text-white' : '' }}" href="/enrollment">{{__('menu.enrollment')}}</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link{{ Request::is('teachers*') ? ' bg-secondary text-white' : '' }}" href="{{ route('teachers.index') }}">{{__('menu.teachers')}}</a>
                    </li>
                    @endauth
                </ul>

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="me-2 mb-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                @endauth
                <div class="btn-group text-nowrap d-none d-lg-flex">
                    <input type="radio" class="btn-check" name="btnradio" id="lang-cn" @if ($currentLocale == 'cn') checked @endif onclick="changeLanguage('cn')">
                    <label class="btn btn-outline-danger" for="lang-cn">中文</label>
                    <input type="radio" class="btn-check" name="btnradio" id="lang-en" @if ($currentLocale == 'en') checked @endif  onclick="changeLanguage('en')">
                    <label class="btn btn-outline-primary" for="lang-en">&nbsp;EN&nbsp;</label>
                    <input type="radio" class="btn-check" name="btnradio" id="lang-ru" disabled>
                    <label class="btn btn-outline-success" for="lang-ru">&nbsp;РУ&nbsp;</label>
                </div>
            </div>
        </div>
    </nav>

  @yield('top_of_page')

  <!-- Content -->
  <div class="container-lg flex-grow-1 py-4 fs-5">
    @yield('content')
  </div>

  @yield('pre-footer')


 <!-- Footer -->
 <footer class="bg-secondary text-light py-4">
  <div class="container-lg">
    <div class="row">
      <div class="col-md-4">
        <h2>海客出国留学服务</h2>
        <h5 class="mb-4">Overseas study service of Haike</h5>
        <p>{!!__('footer.tagline')!!}</p>
      </div>
      <div class="col-md-4">
        <h5>{{__('footer.links')}}</h5>
        <ul class="list-unstyled">
          <li><a href="/about/company" class="text-light">{{__('footer.link_company')}}</a></li>
          <li><a href="/study/russia" class="text-light">{{__('footer.link_study_rus')}}</a></li>
          <li><a href="/study/belarus" class="text-light">{{__('footer.link_study_bel')}}</a></li>
          <li><a href="/enrollment" class="text-light">{{__('footer.enrollment')}}</a></li>
            <li><a href="{{ route('login') }}" class="text-light">[{{__('footer.login')}}]</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>{{__('footer.contacts')}}</h5>
        <p><i class="bi bi-telephone fs-5 me-2"></i> 15937920288</p>
        <p><i class="bi bi-clock fs-5 me-2"></i> {{__('menu.work_time')}}: 9:30 - 18:30</p>
        <p class="d-flex align-items-start"><i class="bi bi-geo-alt-fill fs-5 me-2"></i>
          <span class="flex-grow: 1;">
            河南省郑州市郑东新区郑开大道71号恒通国际广场4层410c-2号
          </span>
        </p>
      </div>
    </div>
  </div>
 </footer>

  <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script>
        $(document).ready(function(){
            $('#imageModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var imgSrc = button.attr('src');
                var modal = $(this);
                modal.find('.modal-body img').attr('src', imgSrc);
            });
        });

        function changeLanguage(locale) {
            window.location.href = `/change-language/${locale}`;
        }
    </script>
</body>
</html>
