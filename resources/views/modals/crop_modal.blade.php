<link rel="stylesheet" href="css/crop/crop.css">

<div id="new-modal" class="modal">
    <div class="modal-content">
        <div class="title-block">
            <span class="modal-title">Загрузка и обрезка фото</span>
            <span class="material-symbols-outlined modal-close" onclick="closeModal(this)">close</span>
        </div>
        
        
        <input type="file" id="upload-image" accept="image/*">
        <div style="position: relative;">
            <canvas id="canvas"></canvas>
            <div class="overlay" id="overlay"></div>
            <div class="crop-area" id="crop-area"></div>
        </div>
        <img id="preview" alt="Cropped Image" style="display: none;">
        <div>
            <div><button id="crop-button" style="display: none;">Crop Image</button></div>
            <div><button id="upload-button">Save</button></div>
        </div>
    </div>
</div>