<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Chat App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Ваши дополнительные стили здесь -->
</head>
<body>

    <nav>
        <ul>
            <!-- <li><a href="{{ route('users.index') }}">Список пользователей</a></li> -->

            @if(Auth::check())
                @if(Auth::user()->role_id == 1)
                    <!-- Вкладки для пользователя -->
                    <li><a href="{{ route('requests.create') }}">Отправить заявку</a></li>
                    <li><a href="{{ route('requests.user_index') }}">История заявок</a></li>
                    <li><a href="{{ route('account') }}">Мой аккаунт</a></li>
                    <li><a href="{{ route('users.my_chats') }}">Мои чаты</a></li>
                @elseif(Auth::user()->role_id == 2)
                    <!-- Вкладки для менеджера -->
                    <li><a href="{{ route('users.my_chats') }}">Мои чаты</a></li>
                    <li><a href="{{ route('manager-requests') }}">все заявки</a></li>
                @elseif(Auth::user()->role_id == 3)
                    <!-- Вкладки для администратора -->
                    <li><a href="{{ route('users.index') }}">Пользователи</a></li>
                    <!-- <li><a href="{{ route('backup') }}">Бэкап</a></li> -->
                    <li><a href="{{ route('statistics.index') }}">Статистика</a></li>
                    <li><a href="{{ route('logs.index') }}">Логи</a></li>

                    
                @endif
            @endif

            @guest
                <li><a href="{{ route('login') }}">Вход</a></li>
                <li><a href="{{ route('register') }}">Регистрация</a></li>

            @else
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </ul>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <!-- Ваши дополнительные скрипты здесь -->

</body>
</html>
