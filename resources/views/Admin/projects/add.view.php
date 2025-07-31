<?php setTitle("Add Project"); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Add Project</h1>
</div>

<div class="form-container">
    <form action="/admin/projects/store" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <?= setCsrf() ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="title" class="form-label required-field">Title</label>
                <input type="text" class="form-control" id="title" name="title"
                       value="<?php echo old('title') ?>"
                       required>
                <div class="form-error text-danger text-sm mt-1"><?= errors('title') ?></div>
            </div>

            <div class="col-md-6">
                <label for="category" class="form-label required-field">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Choose...</option>
                    <?php
                    $categories = ['Web Development', 'Mobile App', 'Desktop App', 'UI/UX Design', 'Other'];
                    foreach ($categories as $cat) {
                        $selected = (old('category') === $cat) ? 'selected' : '';
                        echo "<option value='$cat' $selected>$cat</option>";
                    }
                    ?>
                </select>
                <div class="form-error text-danger text-sm mt-1"><?= errors('category') ?></div>
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"
                          rows="4"><?php echo old('description') ?></textarea>
                <div class="form-error text-danger text-sm mt-1"><?= errors('description') ?></div>
            </div>

            <div class="col-md-6">
                <label for="host_url" class="form-label">Host URL</label>
                <input type="url" class="form-control" id="host_url" name="host_url"
                       value="<?php echo old('host_url') ?>" >
                <div class="form-error text-danger text-sm mt-1"><?= errors('host_url') ?></div>
            </div>

            <div class=" col-md-6">
                <label for="github_url" class="form-label">GitHub URL</label>
                <input type="url" class="form-control" id="github_url" name="github_url"
                       value="<?php echo old('github_url') ?>">
                <div class="form-error text-danger text-sm mt-1"><?= errors('github_url') ?></div>
            </div>

            <div class="col-12">
                <label for="technologies" class="form-label required-field">Technologies Used</label>
                <input type="text" class="form-control" id="technologies" name="technologies"
                       placeholder="e.g., HTML, CSS, JavaScript, PHP"
                       value="<?php echo old('technologies') ?>"
                       required>
                <div class="form-error text-danger text-sm mt-1"><?= errors('technologies') ?></div>
            </div>

            <div class="col-12" id="otherImages">
                <label for="images" class="form-label">Other Images</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/*"
                       multiple onchange="previewImages(this)">
                <div id="otherImagesPreview" class="mt-2 d-flex flex-wrap gap-2">
                    <?php
                    // Display previously uploaded images if form submission failed
                    if (isset($_FILES['images']) && !empty($images)) {
                        foreach ($images as $img) {
                            echo '<img src="../' . $img . '" class="preview-image" style="display:block;">';
                        }
                    }
                    ?>
                </div>
                <div class="form-error text-danger text-sm mt-1"><?= errors('images.0') ?></div>
            </div>

            <div class="col-12 mt-4 d-flex justify-content-between">
                <a href="/admin/projects" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Projects
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save
                </button>
            </div>
        </div>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()

    function previewImages(input) {
        const previewContainer = document.getElementById('otherImagesPreview');
        previewContainer.innerHTML = ''; // Clear existing previews

        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            const imgPreview = document.createElement('img');
            imgPreview.className = 'preview-image';

            reader.onload = function (e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
            }

            reader.readAsDataURL(file);
            previewContainer.appendChild(imgPreview);
        });
    }
</script>
