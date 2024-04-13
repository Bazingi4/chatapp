function sendMessage() {
    var formData = new FormData(document.getElementById('messageForm'));
    var route = document.querySelector('[data-route]').dataset.route;

    $.ajax({
        url: route,
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log('Message sent successfully:', data);
            // Обновление интерфейса для отображения нового сообщения
        },
        error: function (error) {
            console.error('Error sending message:', error);
        }
    });
}
