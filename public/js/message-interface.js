window.Echo.channel('chat.{{ $chat->id }}')
    .listen('MessageSent', (event) => {
        console.log('New message:', event.message);
        // Обновление интерфейса для отображения нового сообщения
    });
