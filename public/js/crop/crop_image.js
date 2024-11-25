// public/js/photoUpload.js

setTimeout(function(){
    const uploadImage = document.getElementById('upload-image');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const preview = document.getElementById('preview');
    const cropButton = document.getElementById('crop-button');
    const cropArea = document.getElementById('crop-area');

    
    
    let CROP_SIZE = 200; // Изменяем на let для возможности изменения
    let img = new Image();
    let scaledWidth, scaledHeight; // Хранение масштабированных размеров изображения
    let startX, startY; // Позиция для обрезки
    let isDragging = false; // Флаг для отслеживания перетаскивания
    let offsetX, offsetY; // Смещения для перетаскивания
    let isResizing = false; // Флаг для отслеживания изменения размера
    var croppedCanvasForSave = null;
    
    uploadImage.addEventListener('change', function (event) {
        const files = event.target.files;
    
        if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
    
            reader.onload = function (event) {
                img.src = event.target.result;
                img.onload = function () {
                    // Масштабируем изображение
                    const maxWidth = 400; // Максимальная ширина для canvas
                    const maxHeight = 400; // Максимальная высота для canvas
                    const ratio = Math.min(maxWidth / img.width, maxHeight / img.height);
    
                    scaledWidth = img.width * ratio;
                    scaledHeight = img.height * ratio;
    
                    canvas.width = scaledWidth;
                    canvas.height = scaledHeight;
                    ctx.drawImage(img, 0, 0, scaledWidth, scaledHeight);
                    
                    cropButton.style.display = 'inline-block';
    
                    // Центрируем область обрезки
                    startX = (scaledWidth - CROP_SIZE) / 2; 
                    startY = (scaledHeight - CROP_SIZE) / 2; 
                    cropArea.style.left = `${startX}px`;
                    cropArea.style.top = `${startY}px`;
                    cropArea.style.width = `${CROP_SIZE}px`;
                    cropArea.style.height = `${CROP_SIZE}px`;
                    cropArea.style.display = 'block'; // Показываем область обрезки
    
                    drawCropCircle(startX, startY);
                };
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Рисование круговой области обрезки
    function drawCropCircle(x, y) {
        // Очистка canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Рисуем изображение
        ctx.drawImage(img, 0, 0, scaledWidth, scaledHeight);
        
        // Затемняем область вне круга
        ctx.fillStyle = 'rgba(0, 0, 0, 0.5)'; 
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Рисуем круг обрезки
        ctx.save(); // Сохраняем контекст
        ctx.beginPath();
        ctx.arc(x + CROP_SIZE / 2, y + CROP_SIZE / 2, CROP_SIZE / 2, 0, Math.PI * 2, true);
        ctx.clip(); // Клипаем только внутри круга
    
        // Отображаем изображение внутри круга
        ctx.drawImage(img, 0, 0, scaledWidth, scaledHeight);
        
        // Восстанавливаем контекст до клипа
        ctx.restore();
    
        // Рисуем рамку после обрезки
        ctx.beginPath();
        ctx.arc(x + CROP_SIZE / 2, y + CROP_SIZE / 2, CROP_SIZE / 2, 0, Math.PI * 2, false);
        ctx.lineWidth = 1;
        ctx.strokeStyle = 'white'; // Цвет обводки
        ctx.stroke();
    }
    
    // Обработка обрезки
    cropButton.addEventListener('click', function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, scaledWidth, scaledHeight);


        const croppedCanvas = document.createElement('canvas');
        const croppedCtx = croppedCanvas.getContext('2d');
    
        croppedCanvas.width = CROP_SIZE;
        croppedCanvas.height = CROP_SIZE;
    
        croppedCtx.beginPath();
        
        croppedCtx.rect(0, 0, scaledWidth, scaledHeight);
        croppedCtx.clip();
    
        croppedCtx.drawImage(canvas, startX, startY, CROP_SIZE, CROP_SIZE, 0, 0, CROP_SIZE, CROP_SIZE);
    
        const croppedImageUrl = croppedCanvas.toDataURL();
        preview.src = croppedImageUrl;
        preview.style.display = 'block'; // Показываем обрезанное изображение
        preview.style.borderRadius = '50%';
        croppedCanvasForSave = croppedCanvas;
        drawCropCircle(startX, startY);
    });

    document.getElementById('upload-button').addEventListener('click', function() {

        // Получаем данные изображения из canvas
        croppedCanvasForSave.toBlob(function(blob) {
            const formData = new FormData();
            formData.append('image', blob, 'cropped_image.png'); // Добавляем изображение в FormData
            
            fetch('https://swiftlylink.ru/api/upload_avatar', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => console.error('Error:', error));
        }, 'image/png'); // Указываем формат изображения
    });
    
    // Перетаскивание области обрезки
    cropArea.addEventListener('mousedown', function(e) {
        if (e.target.classList.contains('resize-handle')) {
            isResizing = true;
        } else {
            isDragging = true;
            const rect = cropArea.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;
        }
        document.addEventListener('mousemove', isResizing ? onResize : onMouseMove);
    });
    
    // Перетаскивание
    function onMouseMove(e) {
        if (isDragging) {
            startX = e.clientX - offsetX - canvas.getBoundingClientRect().left;
            startY = e.clientY - offsetY - canvas.getBoundingClientRect().top;
    
            // Ограничение по границам
            if (startX < 0) startX = 0;
            if (startY < 0) startY = 0;
            if (startX + CROP_SIZE > scaledWidth) startX = scaledWidth - CROP_SIZE;
            if (startY + CROP_SIZE > scaledHeight) startY = scaledHeight - CROP_SIZE;
    
            cropArea.style.left = `${startX}px`;
            cropArea.style.top = `${startY}px`;
            drawCropCircle(startX, startY); // Перерисовываем круг обрезки
        }
    }
    
    // Изменение размера
    function onResize(e) {
        const newSize = e.clientX - cropArea.getBoundingClientRect().left;
    
        // Ограничение размера по границам изображения
        if (newSize > 50 && newSize < Math.min(scaledWidth - startX, scaledHeight - startY)) {
            CROP_SIZE = newSize;
            cropArea.style.width = `${CROP_SIZE}px`;
            cropArea.style.height = `${CROP_SIZE}px`;
            drawCropCircle(startX, startY); // Перерисовываем круг обрезки
        }
    }
    
    // Отпускание мыши
    document.addEventListener('mouseup', function() {
        isDragging = false;
        isResizing = false;
        document.removeEventListener('mousemove', onResize); // Убираем обработчик
document.removeEventListener('mousemove', onMouseMove); 
    });
    
    // Создание ручки для изменения размера
    const resizeHandle = document.createElement('div');
    resizeHandle.className = 'resize-handle';
    cropArea.appendChild(resizeHandle);
    resizeHandle.style.width = '10px';
    resizeHandle.style.height = '10px';
    resizeHandle.style.backgroundColor = 'white'; // Цвет ручки для изменения размера
    resizeHandle.style.position = 'absolute';
    resizeHandle.style.bottom = '0';
    resizeHandle.style.right = '0';
    resizeHandle.style.cursor = 'nwse-resize'; // Курсор для изменения размера
}, 300);




