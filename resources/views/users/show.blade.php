<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>

    </style>
</head>

<body>

    @extends('layouts.app')

    @section('content')
        <div class="name-chat">
            <h2>{{ $receiver->name }}</h2>
        </div>

        <section class="section-chat">
            @forelse ($chats as $message)
                <div class="{{ $message->user_id === auth()->id() ? 'sent' : 'received' }}">
                    @if ($message->file_path)
                        @if (Str::startsWith($message->file_path, 'uploads'))
                            <!-- Если это изображение -->
                            @if (Str::endsWith($message->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                                <img src="{{ asset('storage/' . $message->file_path) }}" alt="Image" onclick="openImage('{{ asset('storage/' . $message->file_path) }}')" />
                            @else
                                <!-- Если это PDF -->
                                @if (Str::endsWith($message->file_path, ['.pdf']))
                                    <iframe src="{{ asset('storage/' . $message->file_path) }}" width="100%" height="500px"></iframe>
                                @else
                                    <!-- Если это другой файл -->
                                    <div class="file-avatar">
                                        @php
                                            // Получаем расширение файла
                                            $extension = pathinfo($message->file_path, PATHINFO_EXTENSION);
                                            // Массив сопоставления расширений и соответствующих классов Font Awesome
                                            $iconMap = [
                                                'pdf' => 'fa-file-pdf',
                                                'doc' => 'fa-file-word',
                                                'docx' => 'fa-file-word',
                                                'xls' => 'fa-file-excel',
                                                'xlsx' => 'fa-file-excel',
                                                'zip' => 'fa-file-archive',
                                                'rar' => 'fa-file-archive',
                                                // Добавьте другие расширения по мере необходимости
                                            ];
                                            // Определение класса иконки на основе расширения файла
                                            $iconClass = $iconMap[$extension] ?? 'fa-file';
                                        @endphp
                                        <i class="fas {{ $iconClass }}"></i>
                                        <span class="file-name">{{ basename($message->file_path) }}</span>
                                        <!-- Иконка скачивания -->
                                        <a href="{{ asset('storage/' . $message->file_path) }}" download>
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <!-- Иконка расширения -->
                                    </div>
                                @endif
                            @endif
                        @else
                            <!-- Если это файл -->
                            <div class="file-avatar">
                                @php
                                    // Получаем расширение файла
                                    $extension = pathinfo($message->file_path, PATHINFO_EXTENSION);
                                    // Определение класса иконки на основе расширения файла
                                    $iconClass = $iconMap[$extension] ?? 'fa-file';
                                @endphp
                                <i class="fas {{ $iconClass }}"></i>
                                <span class="file-name">{{ basename($message->file_path) }}</span>
                                <!-- Иконка скачивания -->
                                <a href="{{ asset('storage/' . $message->file_path) }}" download>
                                    <i class="fas fa-download"></i>
                                </a>
                                <!-- Иконка расширения -->
                            </div>
                        @endif
                    @endif
                    <p>{{ $message->content }}</p>
                </div>
            @empty
                <p style="color:#fff;">Нет сообщений в чате.</p>
            @endforelse

            <form method="post" action="{{ route('users.store', $receiver->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="custom-input">
                <input type="text" name="message" placeholder="Введите сообщение" autocomplete="off">
                <label for="file" class="file-icon">
                    <i class="fas fa-paperclip"></i>
                </label>
                <input id="file" type="file" name="file" accept="image/*, application/pdf, application/msword, application/vnd.ms-excel" style="display:none;" />
                <button type="submit"><i class="fas fa-paper-plane"></i></button>
            </div>
        </form>
    </section>

    @endsection


    <!-- <script src="{{ asset('js/app.js') }}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="{{ asset('js/message-interface.js') }}"></script>
<script src="{{ asset('js/update-interface.js') }}"></script> -->
<script src="{{ asset('js/image-zoom.js') }}"></script>



</body>

</html>
