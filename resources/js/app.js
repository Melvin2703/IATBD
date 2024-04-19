import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.getElementById('popupButton').addEventListener('click', function() {
    document.getElementById('popup').style.display = 'block';
});

document.getElementById('closePopup').addEventListener('click', function() {
    document.getElementById('popup').style.display = 'none';
});

document.querySelector('form').addEventListener('submit', function(event) {
    const photoInput = document.getElementById('photo');
    const videoInput = document.getElementById('video');

    if (photoInput.files.length > 0) {
        const photoExtension = photoInput.files[0].name.split('.').pop().toLowerCase();
        if (!['jpeg', 'jpg', 'png', 'gif'].includes(photoExtension)) {
            event.preventDefault();
            alert('Fout: Ongeldig bestandstype voor foto. Toegestane types zijn: JPEG, JPG, PNG, GIF');
            return;
        }
    }

    if (videoInput.files.length > 0) {
        const videoExtension = videoInput.files[0].name.split('.').pop().toLowerCase();
        if (!['mp4', 'avi', 'mov', 'wmv'].includes(videoExtension)) {
            event.preventDefault();
            alert('Fout: Ongeldig bestandstype voor video. Toegestane types zijn: MP4, AVI, MOV, WMV');
            return;
        }
    }
});