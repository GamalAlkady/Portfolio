<?php setTitle("Edit Project"); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
        <h1 class="h2">Edit Project</h1>
<!--        <a href="/admin/works" class="btn btn-secondary">-->
<!--            <i class="fas fa-arrow-left me-2"></i>Back to Projects-->
<!--        </a>-->
    </div>



    <?php if (hasError()) : ?>
        <div class="toast align-items-center text-white bg-danger border-0 show w-100 mb-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo htmlspecialchars(error()); ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <?php if ($project) : ?>
        <div class="form-container">
            <form action="/admin/update-project" method="POST" enctype="multipart/form-data">
                <?=setCsrf()?>
                <input type="hidden" name="id" value="<?=$project['id']?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Project Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="<?php echo htmlspecialchars($project['title'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Web Development" <?php echo (($project['category'] ?? '') == 'Web Development') ? 'selected' : ''; ?>>
                                Web Development
                            </option>
                            <option value="Mobile Development" <?php echo (($project['category'] ?? '') == 'Mobile Development') ? 'selected' : ''; ?>>
                                Mobile Development
                            </option>
                            <option value="Desktop Application" <?php echo (($project['category'] ?? '') == 'Desktop Application') ? 'selected' : ''; ?>>
                                Desktop Application
                            </option>
                            <option value="Data Science" <?php echo (($project['category'] ?? '') == 'Data Science') ? 'selected' : ''; ?>>
                                Data Science
                            </option>
                            <option value="Other" <?php echo (($project['category'] ?? '') == 'Other') ? 'selected' : ''; ?>>
                                Other
                            </option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                                  required><?php echo htmlspecialchars($project['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="host_url" class="form-label">Host URL (Optional)</label>
                        <input type="url" class="form-control" id="host_url" name="host_url"
                               value="<?php echo htmlspecialchars($project['host_url'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="github_url" class="form-label">GitHub URL (Optional)</label>
                        <input type="url" class="form-control" id="github_url" name="github_url"
                               value="<?php echo htmlspecialchars($project['github_url'] ?? ''); ?>">
                    </div>
                    <div class="col-12">
                        <label for="technologies" class="form-label">Technologies (Comma separated)</label>
                        <input type="text" class="form-control" id="technologies" name="technologies"
                               value="<?php echo htmlspecialchars($project['technologies'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <input type="hidden" name="old_image" value="<?=$project['image']?>">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                        <?php if (isset($_FILES['image']) || !empty($project['image'])): ?>
                            <img src="<?php echo assets($project['image']); ?>" class="mt-2 preview-image" style="display:block;">
                        <?php else: ?>
                            <img id="preview" class="mt-2 preview-image">
                        <?php endif; ?>
                    </div>

<!--                    TODO: create gallery for images and remove theme  -->
<!--                    <div class="col-md-6">-->
<!--                        <input type="hidden" name="old_other_images" value="--><?//=$project['other_images']?><!--">-->
<!--                        <label for="other_images" class="form-label">Other Images (Multiple)</label>-->
<!--                        <input type="file" class="form-control" id="other_images" name="other_images[]" accept="image/*"-->
<!--                               multiple>-->
<!--                        <div class="image-preview-container" id="other-images-preview">-->
<!--                            --><?php
//                            $existing_other_images = json_decode($project['other_images'] ?? '[]', true);
//                            if (is_array($existing_other_images)) {
//                                foreach ($existing_other_images as $index => $image_path) {
//                                    echo '<div class="other-image-item" data-index="' . $index . '">';
//                                    echo '<img src="..\\' . htmlspecialchars($image_path) . '" alt="Other Image Preview" class="image-preview">';
//                                    echo '<button type="button" class="delete-btn" data-path="' . htmlspecialchars($image_path) . '">X</button>';
//                                    echo '</div>';
//                                }
//                            }
//                            ?>
<!--                        </div>-->
<!--                    </div>-->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update Project</button>
                    </div>
                </div>
            </form>
        </div>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">
            Project not found or an error occurred.
        </div>
    <?php endif; ?>
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

