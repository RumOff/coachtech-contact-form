<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>coachtech contant form</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
        <a class="header__logo" href="/">
          @auth
          FashionablyLate
          <!-- Attendance Management -->
          @else
          FashionablyLate
          @endauth
        </a>
        <nav>
          <ul class="header-nav">
            
            @if(request()->is('admin*'))
            @auth
            <li class="header-nav__item">
              <form action="/logout" method="post">
                @csrf
                <button class="header-nav__button">ログアウト</button>
              </form>
            </li>
            @else
            <li class="header-nav__item">
              <a href="/login" class="header-nav__button">ログイン</a>
            </li>
            @endauth
            @endif

          </ul>
        </nav>
      </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>