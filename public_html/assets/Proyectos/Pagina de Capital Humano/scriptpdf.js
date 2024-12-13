// script.js
const dragArea = document.getElementById('dragArea');
const pdfFileInput = document.getElementById('pdfFile');
const filePreview = document.getElementById('filePreview');

dragArea.addEventListener('click', () => {
    pdfFileInput.click();
});

pdfFileInput.addEventListener('change', (event) => {
    handleFiles(event.target.files);
});

dragArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    dragArea.classList.add('dragging');
});

dragArea.addEventListener('dragleave', () => {
    dragArea.classList.remove('dragging');
});

dragArea.addEventListener('drop', (event) => {
    event.preventDefault();
    dragArea.classList.remove('dragging');
    handleFiles(event.dataTransfer.files);
});

function handleFiles(files) {
    if (files.length) {
        pdfFileInput.files = files;
        showFilePreview(files[0]);
    }
}

function showFilePreview(file) {
    const fileType = file.type;
    const validTypes = ['application/pdf'];

    if (validTypes.includes(fileType)) {
        const reader = new FileReader();
        reader.onload = function (e) {
            filePreview.innerHTML = `
                <p><strong>Nombre del archivo:</strong> ${file.name}</p>
                <p><strong>Tamaño:</strong> ${(file.size / 1024).toFixed(2)} KB</p>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        filePreview.innerHTML = `<p>Por favor, selecciona un archivo PDF.</p>`;
    }
}

