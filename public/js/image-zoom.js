function openImage(imageUrl) {
    // Создаем элемент изображения для открытия
    var fullSizeImage = document.createElement('img');
    fullSizeImage.src = imageUrl;
    fullSizeImage.style.maxWidth = '100%';
    fullSizeImage.style.maxHeight = '80%';
    fullSizeImage.style.margin = 'auto';
    fullSizeImage.style.display = 'block';

    // Создаем модальное окно
    var modal = document.createElement('div');
    modal.className = 'modal';
    modal.appendChild(fullSizeImage);

    // Добавляем модальное окно в body
    document.body.appendChild(modal);

    // Закрытие модального окна при клике
    modal.addEventListener('click', function () {
        document.body.removeChild(modal);
    });
}

// app.js