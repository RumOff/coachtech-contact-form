<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo</title>
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
          Todo
          <!-- Attendance Management -->
          @else
          Todo
          @endauth
        </a>
        <nav>
          <ul class="header-nav">

            @guest
              <li class="header-nav__item">
                <a href="/categories" class="header-nav__link">カテゴリ一覧</a>
              </li>
            @endguest

            @auth
              <li class="header-nav__item">
                <a href="/categories" class="header-nav__link">カテゴリ一覧</a>
              </li>
              <li class="header-nav__item">
                <a class="header-nav__link" href="/mypage">マイページ</a>
              </li>
              <li class="header-nav__item">
                <form action="/logout" method="post">
                  @csrf
                  <button class="header-nav__button">ログアウト</button>
                </form>
              </li>
            @endauth

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