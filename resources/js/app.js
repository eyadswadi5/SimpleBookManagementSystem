import './bootstrap';

const fileInput = document.getElementById('bookCover');
const fileName = document.getElementById('fileName');
const previewImage = document.getElementById('previewImage');

fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        fileName.textContent = file.name;
        
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = 'none';
        }
    } else {
        fileName.textContent = 'No file selected';
        previewImage.style.display = 'none';
    }
});

const fileInputLabel = document.querySelector('.file-input-label');

fileInputLabel.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileInputLabel.style.borderColor = '#3498db';
    fileInputLabel.style.backgroundColor = '#f0f8ff';
});

fileInputLabel.addEventListener('dragleave', () => {
    fileInputLabel.style.borderColor = '#ddd';
    fileInputLabel.style.backgroundColor = '#f9f9f9';
});

fileInputLabel.addEventListener('drop', (e) => {
    e.preventDefault();
    fileInputLabel.style.borderColor = '#ddd';
    fileInputLabel.style.backgroundColor = '#f9f9f9';
    
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        const event = new Event('change');
        fileInput.dispatchEvent(event);
    }
});