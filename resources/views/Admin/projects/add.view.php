<?php setTitle("Add Project"); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
        <h1 class="h2">Add Project</h1>
    </div>

    <?php if (hasError()) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars(error()); ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form action="/admin/add-project" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <?=setCsrf()?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label required-field">Title</label>
                    <input type="text" class="form-control" id="title" name="title"
                           value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>"
                           required>
                </div>

                <div class="col-md-6">
                    <label for="category" class="form-label required-field">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="">Choose...</option>
                        <?php
                        $categories = ['Web Development', 'Mobile App', 'Desktop App', 'UI/UX Design', 'Other'];
                        foreach ($categories as $cat) {
                            $selected = (isset($_POST['category']) && $_POST['category'] === $cat) ? 'selected' : '';
                            echo "<option value='$cat' $selected>$cat</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"
                              rows="4"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                </div>

                <div class="col-md-6">
                    <label for="host_url" class="form-label">Host URL</label>
                    <input type="url" class="form-control" id="host_url" name="host_url"
                           value="<?php echo isset($_POST['host_url']) ? htmlspecialchars($_POST['host_url']) : '' ?>"">
                </div>

                <div class=" col-md-6">
                    <label for="github_url" class="form-label">GitHub URL</label>
                    <input type="url" class="form-control" id="github_url" name="github_url"
                           value="<?php echo isset($_POST['github_url']) ? htmlspecialchars($_POST['github_url']) : '' ?>">
                </div>

                <div class="col-12">
                    <label for="technologies" class="form-label required-field">Technologies Used</label>
                    <input type="text" class="form-control" id="technologies" name="technologies"
                           placeholder="e.g., HTML, CSS, JavaScript, PHP"
                           value="<?php echo isset($_POST['technologies']) ? htmlspecialchars($_POST['technologies']) : ''; ?>"
                           required>
                </div>

                <div class="col-12">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image"
                           accept="image/*" onchange="previewImage(this)">
                    <?php if (isset($_FILES['image']) && !empty($image_url)): ?>
                        <img src="../<?php echo $image_url; ?>" class="mt-2 preview-image" style="display:block;">
                    <?php else: ?>
                        <img id="preview" class="mt-2 preview-image">
                    <?php endif; ?>
                </div>

                <div class="col-12" id="otherImages">
                    <label for="other_images" class="form-label">Other Images</label>
                    <input type="file" class="form-control" id="other_images" name="other_images[]" accept="image/*"
                           multiple onchange="previewImages(this)">
                    <div id="otherImagesPreview" class="mt-2 d-flex flex-wrap gap-2">
                        <?php
                        // Display previously uploaded images if form submission failed
                        if (isset($_FILES['other_images']) && !empty($other_images)) {
                            foreach ($other_images as $img) {
                                echo '<img src="../' . $img . '" class="preview-image" style="display:block;">';
                            }
                        }
                        ?>
                    </div>
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
</main>


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

    // Image preview
    function previewImage(input) {
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

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
