@php
  function addActiveClass($link) {
    if(str_contains($link, Request::path())) return 'active';
  }
@endphp
<!doctype html>
<html lang="es" style="scroll-behavior: smooth;">
<head>
  <meta charset="utf-8">
  <title>Brayan Brush | Corporación Logística</title>
  <meta name="end-point" content="https://brayanbruhs.pe/"/>
  <link href="{{ asset('frontend/css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/revolution-slider.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/font-awesome.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/owl.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/style.css') }}" rel="stylesheet">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link href="{{ asset('frontend/css/bootstrap-margin-padding.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/icono.ico') }}">
  <link rel="icon" type="image/png" href="{{ asset('frontend/icono.ico') }}" sizes="32x32">
  <link rel="stylesheet" href="{{ asset('frontend/css/general-style.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset("vendor/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css">
  @yield('styles')
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="main-wrapper" id="app">
      <x-mary-socials-contact />

      <div class="clearfix"></div>

      <x-mary-navbar>
        <x-slot:logo>
          <a href="{{ url('/') }}"><img src="{{ asset('frontend/img/logo-1.png') }}" alt="" class="logo"></a>
        </x-slot:logo>
        <x-slot:menu>
          <ul>
            <li class="dib"><a href="{{ asset('/') }}" class="db {{ Request::path() == '/' ? 'active' : '' }}">Inicio</a></li>
            <li class="dib"><a href="{{ route('servicios') }}" class="db {{addActiveClass('servicios')}}">Servicios</a></li>
            <li class="dib"><a href="{{ route('contacto') }}" class="db {{addActiveClass('contacto')}}">Contacto</a></li>
          </ul>
        </x-slot:menu>
      </x-mary-navbar>

      @yield('content')

      <div class="clearfix"></div>

      <x-mary-footer>
        <x-slot:newsletter>
          <form action="javascript:;" onsubmit="subscribe()">
            <div class="pb-0 row">
              <div class="col-sm-12">
                <h3 class="format-title">Boletón de noticias</h3>
              </div>
            </div>
            <div class="pt-0 row d-flex">
              <div class="col-sm-8 col-md-10" style="padding-right: 0">
                <input type="email" placeholder="Correo electronico..." id="email-subscribe" autocomplete="email" class="form-control input-placeholder"
                style="border-radius: 30px 0 0 30px;">
              </div>
              <div class="col-sm-4 col-md-2" style="padding-left: 0">
                <button type="submit" class="button btn-block btn-sm button-custom-success"
                style="border-radius: 0 30px 30px 0;">Suscribirme</button>
              </div>
            </div>
          </form>
        </x-slot:newsletter>
        <x-slot:claim_book>
          <a href="{{ route('libro-de-reclamaciones') }}" class="container-claim-book">
            <img src="{{ asset('frontend/book.svg') }}" alt="Libro de reclamción">
            <h5>Libro de reclamos</h5>
          </a>
        </x-slot:claim_book>
        <x-slot:socials>
          <a href="https://www.facebook.com/BrayanBrushTransporte" class="text-white item-social"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/brayan_brush/" class="text-white item-social"><i class="fab fa-instagram"></i></a>
        </x-slot:socials>
      </x-mary-footer>

      <div class="clearfix"></div>

      <x-mary-scroll-to-top />

      <div class="clearfix"></div>

      <x-mary-hidden-bar>
        <x-slot:logo>
          <a href="{{ asset('/') }}">
            <img src="{{ asset('frontend/img/logo-1.png') }}" alt="">
          </a>
        </x-slot:logo>
        <x-slot:menu>
          <ul class="clearfix navigation">
            <li><a href="{{ asset('/') }}">Inicio</a></li>
            <li><a href="{{ route('servicios') }}">Servicios</a></li>
            <li><a href="{{ route('contacto') }}">Contacto</a></li>
          </ul>
        </x-slot:menu>
      </x-mary-hidden-bar>
    </div>

    <div class="preloader"></div>

    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/axios/axios.min.js') }}"></script>
    <script src="{{ asset('js/axios/config-axios.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/revolution.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.mixitup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/gmaps.min.js') }}"></script>
    <script src="{{ asset('frontend/js/map-helper.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}" defer></script>
    @yield('scripts')
    <script>
      async function subscribe() {
        try {
          const data = await axios.post('subscribe-newsletter', {
            email: document.getElementById('email-subscribe').value
          })
          Swal.fire({
            icon: 'success',
            title: 'Suscripción exitosa',
            text: 'Le enviaremos noticias y novedades a su correo.',
            confirmButtonText: '¡Confirmar!'
          })
        } catch (error) {
          const message = error.response.data.errors.email[0]
          Swal.fire({
            icon: 'warning',
            title: '¡Alerta!',
            html: `<b>${message}</b>`,
            confirmButtonText: '¡Corregir!'
          })
        }
      }
      const classShowContact = 'social-show';
      function chatHandleClick() {
        document.querySelector('#socials-contact').classList.toggle(classShowContact);
      }
      document.addEventListener('keyup',(e) => {
        if(e.code == 'Escape') {
          if(document.querySelector('#socials-contact').classList.contains(classShowContact)) {
            document.querySelector('#socials-contact').classList.remove(classShowContact);
          }
        }
      })
    </script>
</body>
</html>
