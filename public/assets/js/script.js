// Form validation and handling



document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('productForm');

    // const imagesInput = document.getElementById('images');
    // const imagesDropzone = document.getElementById('imagesDropzone');
    //
    // // Set up dropzone event listeners
    // if (imagesDropzone) {
    //     setupDropzone(imagesDropzone, imagesInput);
    //     imagesInput.addEventListener('change', function () {
    //         previewImage(this, 'imagesPreview', false);
    //     });
    // }

    // Form submission
    form.addEventListener('submit', function (e) {
        console.log('sss')
            e.preventDefault();
        if (!validateForm()) {
        }
    });
});


// Set up drag and drop functionality
function setupDropzone(dropzone, input) {
    dropzone.addEventListener('click', () => input.click());

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropzone.classList.add('border-primary', 'bg-blue-50');
    }

    function unhighlight() {
        dropzone.classList.remove('border-primary', 'bg-blue-50');
    }

    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        input.files = files;

        previewImage(input, 'imagesPreview', false);

    }
}

// Preview selected image
function previewImage(input, previewId, isMain) {
    const preview = document.getElementById(previewId);

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            if (isMain) {
                preview.innerHTML = `<img src="${e.target.result}" class="mx-auto max-h-40 rounded-lg" alt="Preview">`;
            } else {
                preview.innerHTML = `<img src="${e.target.result}" class="mx-auto max-h-40 rounded-lg" alt="Preview">`;
                preview.innerHTML += `<p class="text-gray-600 mt-2">${input.files.length} image(s) selected</p>`;
            }
        }

        reader.readAsDataURL(input.files[0]);
    } else if (input.files && input.files.length > 1) {
        preview.innerHTML = `<p class="text-gray-600">${input.files.length} images selected</p>`;
    } else {
        if (isMain) {
            preview.innerHTML = `
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Click to upload main image</p>
                        <p class="text-gray-500 text-sm mt-1">PNG, JPG, GIF up to 5MB</p>
                    `;
        } else {
            preview.innerHTML = `
                        <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Click to upload additional images</p>
                        <p class="text-gray-500 text-sm mt-1">Select multiple images (up to 5)</p>
                    `;
        }
    }
}

// Validate form
function validateForm() {
    let isValid = true;

    // Reset errors
    document.querySelectorAll('.form-error').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });

    // Validate title
    const title = document.getElementById('title').value.trim();
    if (!title) {
        showError('titleError', 'Product title is required');
        isValid = false;
    } else if (title.length < 3) {
        showError('titleError', 'Title must be at least 3 characters');
        isValid = false;
    }

    // Validate description
    const description = document.getElementById('description').value.trim();
    if (!description) {
        showError('descriptionError', 'Description is required');
        isValid = false;
    } else if (description.length < 10) {
        showError('descriptionError', 'Description must be at least 10 characters');
        isValid = false;
    }

    // Validate category
    const category = document.getElementById('category').value;
    if (!category) {
        showError('categoryError', 'Please select a category');
        isValid = false;
    }

    // Validate technologies
    const technologies = document.getElementById('technologies').value.trim();
    if (!technologies) {
        showError('technologiesError', 'Technologies are required');
        isValid = false;
    } else if (technologies.split(',').length < 1) {
        showError('technologiesError', 'Please enter at least one technology');
        isValid = false;
    }

    // Validate URLs
    const hostUrl = document.getElementById('hostUrl').value.trim();
    const githubUrl = document.getElementById('githubUrl').value.trim();

    if (hostUrl && !isValidUrl(hostUrl)) {
        showError('hostUrlError', 'Please enter a valid URL');
        isValid = false;
    }

    if (githubUrl && !isValidUrl(githubUrl)) {
        showError('githubUrlError', 'Please enter a valid GitHub URL');
        isValid = false;
    }

    // Validate additional images
    const images = document.getElementById('images').files;
    // console.log(images)
    if (images.length === 0) {
        showError('imagesError', 'You must insert at least one image.');
        isValid = false;
    } else if (images.length > 5) {
        showError('imagesError', 'You can upload maximum 5 additional images');
        isValid = false;
    }

    for (let i = 0; i < images.length; i++) {
        if (images[i].size > 5 * 1024 * 1024) {
            showError('imagesError', 'Each image size must be less than 5MB');
            isValid = false;
            break;
        }
    }

    return isValid;
}

// Show error message
function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = message;
    errorElement.classList.remove('hidden');
}

// Validate URL format
function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

// Reset form
function resetForm() {
    document.getElementById('productForm').reset();

    // Reset previews
    document.getElementById('mainImagePreview').innerHTML = `
                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                <p class="text-gray-600">Click to upload main image</p>
                <p class="text-gray-500 text-sm mt-1">PNG, JPG, GIF up to 5MB</p>
            `;

    document.getElementById('imagesPreview').innerHTML = `
                <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                <p class="text-gray-600">Click to upload additional images</p>
                <p class="text-gray-500 text-sm mt-1">Select multiple images (up to 5)</p>
            `;

    // Reset errors
    document.querySelectorAll('.form-error').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
}