<?php setTitle("Details"); ?>

<!-- LightGallery CSS -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= /** @var array $project */
                        $project['title']?></h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="bg-white rounded shadow overflow-hidden">

                <!-- Product Header -->
                <div class="p-4 border-bottom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div>
                        <span class="badge bg-primary text-white rounded-pill mb-2">
                            <?= $project['category'] ?>
                        </span>
                            <h1 class="h2 fw-bold text-dark"><?= $project['title'] ?></h1>
                        </div>

                        <div>
                            <div class="d-flex justify-content-around mt-3 mt-md-0">
                                <a href="/admin/edit-project/<?php echo $project['id']; ?>"
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/admin/projects/<?php echo $project['id']; ?>/delete"
                                   class="btn btn-outline-danger"
                                   onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا المشروع؟')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>

                            <div class="mt-3 mt-md-0">
                                <span class="text-muted">Created: <?= $project['created_at'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Details -->
                <div class="p-4 border-bottom d-flex gap-3">
                    <div class="flex-grow-1">
                        <div class="bg-light p-4 rounded">
                            <h2 class="h4 fw-semibold mb-3">Project Details</h2>
                            <p class="text-muted mb-4"><?= $project['description'] ?></p>

                            <div class="mb-4">
                                <h3 class="fw-medium text-dark mb-2">Technologies Used</h3>
                                <p> <?= htmlspecialchars($project['technologies']) ?></p>

                            </div>


                        </div>
                    </div>

                    <div class="flex-shrink-0" style="width: 250px;">
                        <div class="d-flex flex-column gap-3">
                            <?php if (!empty($project['host_url'])): ?>
                                <a href="<?= $project['host_url'] ?>"
                                   class="btn btn-primary w-100"
                                   target="_blank">
                                    <i class="fas fa-external-link-alt me-2"></i> View Live Project
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($project['github_url'])): ?>
                                <a href="<?= $project['github_url'] ?>"
                                   class="btn btn-dark w-100"
                                >
                                    <i class="fab fa-github me-2"></i> View on GitHub
                                </a>
                            <?php endif; ?>


                        </div>
                    </div>
                </div>

                <!-- Product Content -->
                <div class="p-0">
                    <div id="dropzone-container" class="col-md-12"></div>

                    <div class="d-none flex-column flex-lg-row ">

                        <!-- Main Image -->
                        <div class="w-100">
                            <div class=" mb-3 w-100  mt-md-0">
                                <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal"
                                        data-bs-target="#addImageModal">
                                    <i class="fas fa-plus-circle "></i>
                                </button>
                            </div>

                            <div class="flex-grow-1 w-100 mb-3 p-2 ">
                                <!-- Gallery -->
                                <?php /** @var array $images */
                                if (count($images) > 0): ?>
                                    <div id="lightgallery" class="row g-3">
                                        <?php foreach ($images as $img): ?>
                                            <div class="col-md-3 col-sm-4 col-6">
                                                <div class="position-relative">
                                                    <a href="<?= assets($img['path']) ?>"
                                                       class="gallery-item"
                                                       data-sub-html="<h4>Project Image</h4>">
                                                        <img src="<?= assets($img['path']) ?>"
                                                             class="img-fluid rounded shadow-sm"
                                                             style="width: 100%; height: 150px; object-fit: cover;"
                                                             alt="Project Image">
                                                    </a>

                                                    <!-- Action Buttons Overlay -->
                                                    <div class="position-absolute fixed-top  p-2">
                                                        <div class="btn-group-vertical btn-group-sm">
                                                            <?php if (!$img['is_main']): ?>
                                                                <button type="button"
                                                                        class="btn btn-success btn-sm"
                                                                        onclick="setMainImage(<?= $img['id'] ?>)"
                                                                        title="Set as Main Image">
                                                                    <i class="fas fa-star"></i>
                                                                </button>
                                                            <?php else: ?>
                                                                <span class="badge bg-primary mb-1">
                                                <i class="fas fa-star"></i> Main
                                            </span>
                                                            <?php endif; ?>

                                                            <button type="button"
                                                                    class="btn btn-warning btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editImageModal"
                                                                    data-image-id="<?= $img['id'] ?>"
                                                                    data-image-path="<?= assets($img['path']) ?>"
                                                                    data-is-main="<?= $img['is_main'] ?>"
                                                                    title="Replace Image">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button"
                                                                    class="btn btn-danger btn-sm"
                                                                    onclick="deleteImage(<?= $img['id'] ?>)"
                                                                    title="Delete Image">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-5">
                                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No images available</h5>
                                        <p class="text-muted">Click "Add Image" to upload project images</p>
                                    </div>
                                <?php endif; ?>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Add Image Modal -->
                <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addImageModalLabel">
                                    <i class="fas fa-image me-2"></i>Add New Image
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form action="/admin/projects/<?php echo $project['id']; ?>/add" method="POST"
                                  enctype="multipart/form-data">
                                <?= setCsrf() ?>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">

                                        <div class="col-md-12 mb-3">
                                            <label for="project_image" class="form-label">
                                                <i class="fas fa-upload me-1"></i>Select Images
                                            </label>
                                            <input type="file" class="form-control" id="project_image" name="images[]"
                                                   accept="image/*" required multiple>
                                            <div class="form-text">Supported formats: JPG, PNG, GIF, WebP (Max size: 5MB
                                                per
                                                image)
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div id="imagePreviewContainer" class="row g-2">
                                                <!-- Preview images will be displayed here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Save Images
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Image Modal -->

                <div class="modal fade" id="editImageModal" tabindex="-1" aria-labelledby="editImageModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editImageModalLabel">
                                    <i class="fas fa-edit me-2"></i>Replace Image
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form id="editImageForm" method="POST" enctype="multipart/form-data"
                                  action="/admin/projects/images/<?= /** @var array $image */$image['id'] ?>/replace">
                                <?= setCsrf() ?>
                                <?= setMethod('PUT') ?>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="edit_image_file" class="form-label">
                                                    <i class="fas fa-upload me-1"></i>New Image
                                                </label>
                                                <input type="file" class="form-control" id="edit_image_file"
                                                       name="image"
                                                       accept="image/*" required>
                                                <div class="form-text">Select a new image to replace the current one
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           id="is_main_checkbox"
                                                           name="is_main" value="0">
                                                    <label class="form-check-label" for="is_main_checkbox">
                                                        <i class="fas fa-star me-1"></i>Set as main project image
                                                    </label>
                                                </div>
                                                <div class="form-text">Check this if you want this image to be the main
                                                    project
                                                    image
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="text-center">
                                                <h6 class="mb-3">Current Image</h6>
                                                <img id="currentImagePreview" src="" alt="Current Image"
                                                     class="img-fluid rounded shadow-sm"
                                                     style="max-height: 300px; max-width: 100%;">
                                            </div>

                                            <div class="mt-3" id="newImagePreviewContainer" style="display: none;">
                                                <h6 class="mb-3">New Image Preview</h6>
                                                <img id="newImagePreview" src="" alt="New Image Preview"
                                                     class="img-fluid rounded shadow-sm"
                                                     style="max-height: 200px; max-width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Replace Image
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?= assets('js/DropzoneCard.js') ?>"></script>




<script>
    const fileInput = document.getElementById("file-input");
    const dropzoneContainer = document.getElementById('dropzone-container');

    const existingImagesArray = <?= json_encode($images) ?>;
    // إنشاء كائن جديد من DropzoneCard
    const myDropzoneCard = new DropzoneCard(
        'تحميل الصور', // العنوان
        'اسحب وأفلت صورك هنا', // العنوان الفرعي
        'dropzone-container', // معرف Dropzone ID الفريد
        "<?=route('addImage',['project_id'=>$project['id']])?>", // **استبدل هذا بعنوان URL الخاص بخادمك لتحميل الملفات**
        true,existingImagesArray
    );

    // إدراج HTML الذي يولده الكلاس في DOM
    dropzoneContainer.innerHTML = myDropzoneCard.renderFileStartButton().getHtml();

    // Dropzone.autoDiscover = false;

    const projectId = <?=$project['id']?>; // عدل ID المشروع


</script>