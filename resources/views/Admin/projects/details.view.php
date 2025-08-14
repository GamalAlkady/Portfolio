<?php setTitle(__('project_details')); ?>

<!-- LightGallery CSS -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?=__('project_details')?> </h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
            <div class="card">

                <!-- Product Header -->
                <div class="p-4 border-bottom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div>
                        <span class="badge bg-primary text-white rounded-pill mb-2">
                            <?= /** @var array $project */
                            $project['category'] ?>
                        </span>
                            <h1 class="h2 fw-bold"><?= $project['title'] ?></h1>
                        </div>

                        <div>
                            <div class="d-flex justify-content-around mt-3 mt-md-0">
                                <a href="/admin/projects/<?php echo $project['id']; ?>/edit"
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button
                                   class="btn btn-outline-danger"
                                   onclick="confirmDelete('<?=getCsrf()?>','<?= route('deleteProject',['id'=>$project['id']]) ?>','<?=route('projects')?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <div class="mt-3 mt-md-0">
                                <span class="text-muted"><?=__('created').': '. $project['created_at'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Details -->
              <div class="card-body border-bottom">
                  <div class=" p-4 d-flex gap-3">
                      <div class="flex-grow-1">
                          <div class=" p-4 rounded">
                              <h2 class="h4 fw-semibold mb-3"><?=__('project_details')?></h2>
                              <p class="text-muted mb-4"><?= $project['description'] ?></p>

                              <div class="mb-4">
                                  <h3 class="fw-medium  mb-2"><?=__('technologies_used')?></h3>
                                  <p> <?= htmlspecialchars($project['technologies']) ?></p>

                              </div>


                          </div>
                      </div>

                      <div class="flex-shrink-0 shadow" style="width: 250px;height: fit-content">
                          <div class="d-flex flex-column gap-3">
                              <?php if (!empty($project['host_url'])): ?>
                                  <a href="<?= $project['host_url'] ?>"
                                     class="btn btn-primary w-100" target="_blank">
                                      <i class="fas fa-external-link-alt me-2"></i> <?=__('view_live_project')?>
                                  </a>
                              <?php endif; ?>

                              <?php if (!empty($project['github_url'])): ?>
                                  <a href="<?= $project['github_url'] ?>"
                                     class="btn btn-dark w-100"
                                  >
                                      <i class="fab fa-github me-2"></i> <?=__('view_on_github')?>
                                  </a>
                              <?php endif; ?>


                          </div>
                      </div>
                  </div>
              </div>

                <div class="card-footer">
                    <!-- Product Content -->
                    <div class="p-0">

                        <div class="d-flex flex-column flex-lg-row">

                            <!-- Main Image -->
                            <div class="w-100">
                                <div class=" mb-3 w-100  mt-md-0">
                                    <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal"
                                            data-bs-target="#addImageModal">
                                        <i class="fas fa-plus-circle "></i>
                                    </button>
                                </div>

                                <div class="flex-grow-1 w-100 mb-3 p-2">
                                    <!-- Gallery -->
                                    <?php /** @var array $images */
                                    if (count($images) > 0): ?>
                                        <div id="lightgallery" class="row g-3">
                                            <?php foreach ($images as $img): ?>
                                                <div class="col-md-3 col-sm-4 col-6">
                                                    <div class="position-relative">
                                                        <a href="<?= assets($img['path']) ?>"
                                                           class="gallery-item"
                                                           data-sub-html="<h4><?= __("project_image") ?></h4>">
                                                            <img src="<?= assets($img['path']) ?>"
                                                                 class="img-fluid rounded shadow-sm"
                                                                 style="width: 100%; height: 150px; object-fit: cover;"
                                                                 alt="<?= __("project_image") ?>">
                                                        </a>

                                                        <!-- Action Buttons Overlay -->
                                                        <div class="position-absolute fixed-top  p-2">
                                                            <div class="btn-group-vertical btn-group-sm">
                                                                <?php if (!$img['is_main']): ?>
                                                                    <button type="button"
                                                                            class="btn btn-success btn-sm"
                                                                            onclick="setMainImage(<?= $img['id'] ?>)"
                                                                            title="<?= __("set_as_main_image") ?>">
                                                                        <i class="fas fa-star"></i>
                                                                    </button>
                                                                <?php else: ?>
                                                                    <span class="badge bg-primary mb-1">
                                                                    <i class="fas fa-star"></i> <?= __("main") ?>
                                                                </span>
                                                                <?php endif; ?>

                                                                <button type="button"
                                                                        class="btn btn-warning btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editImageModal"
                                                                        data-image-id="<?= $img['id'] ?>"
                                                                        data-image-path="<?= assets($img['path']) ?>"
                                                                        data-is-main="<?= $img['is_main'] ?>"
                                                                        title="<?= __("replace_image") ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <?php if (!$img['is_main']): ?>
                                                                    <button type="button"
                                                                            class="btn btn-danger btn-sm"
                                                                            onclick="confirmDelete('<?=getCsrf()?>','<?= route('deleteImage',['id'=>$img['id']]) ?>')"
                                                                            title="<?= __("delete_image") ?>">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-5">
                                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted"><?= __("no_images_available") ?></h5>
                                            <p class="text-muted"><?= __("click_add_image_to_upload") ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>


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
                                    <i class="fas fa-image me-2"></i><?= __("add_new_image") ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="<?= __("close") ?>"></button>
                            </div>
                            <form action="/admin/projects/images/<?php echo $project['id']; ?>/add" method="POST"
                                  enctype="multipart/form-data">
                                <?= setCsrf() ?>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">

                                        <div class="col-md-12 mb-3">
                                            <label for="project_image" class="form-label">
                                                <i class="fas fa-upload me-1"></i><?= __("select_images") ?>
                                            </label>
                                            <input type="file" class="form-control" id="project_image" name="images[]"
                                                   accept="image/*" required multiple>
                                            <div class="form-text"><?= __("supported_formats_info") ?>
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
                                        <i class="fas fa-times me-1"></i><?= __("cancel") ?>
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i><?= __("save_images") ?>
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
                                    <i class="fas fa-edit me-2"></i><?= __("replace_image") ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form id="editImageForm" method="POST" enctype="multipart/form-data"
                                  action="/admin/projects/images/<?= /** @var array $image */ $image['id'] ?>/replace">
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
            </div>
        </div>
    </section>
</div>
<!-- LightGallery JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/lightgallery.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/plugins/zoom/lg-zoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/plugins/thumbnail/lg-thumbnail.min.js"></script>
<!--<script src="--><?php // echo assets('js/DropzoneCard.js') ?><!--"></script>-->

<script>
    // Initialize LightGallery
    const gallery = lightGallery(document.getElementById('lightgallery'), {
        plugins: [lgZoom, lgThumbnail],
        speed: 500,
        download: true,
        counter: true,
        showThumbByDefault: false,
        toggleThumb: true,
        showZoomInOutIcons: true,
        actualSize: false,
        allowZoom: true,
        zoomFromOrigin: true,
        allowMediaOverlap: true,
        getCaptionFromTitleOrAlt: true,
        // Custom settings
        mode: 'lg-fade',
        cssEasing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        startAnimationDuration: 400,
        closable: true,
        loop: true,
        escKey: true,
        keyPress: true,
        trapFocus: true,
        controls: true,
        slideEndAnimation: true,
        hideControlOnEnd: false,
        mousewheel: true,
        appendSubHtmlTo: '.lg-sub-html',
        subHtmlSelectorRelative: false,
        preload: 1,
        showAfterLoad: true,
        selector: '.gallery-item',
        dynamic: false,
        dynamicEl: [],
        index: 0,
        iframeMaxWidth: '100%',
        downloadURL: true,
        downloadFileName: 'lightgallery',
        mobileSettings: {
            controls: true,
            showCloseIcon: true,
            download: true,
            rotate: false
        }
    });

    // Multiple image preview functionality
    document.getElementById('project_image').addEventListener('change', function (e) {
        const files = e.target.files;
        const container = document.getElementById('imagePreviewContainer');
        container.innerHTML = '';

        if (files.length > 0) {
            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'col-md-3 col-sm-4 col-6';
                        previewDiv.innerHTML = `
                            <div class="position-relative">
                                <img src="${e.target.result}"
                                     class="img-fluid rounded shadow-sm"
                                     style="width: 100%; height: 120px; object-fit: cover;"
                                     alt="Preview ${index + 1}">
                                <div class="position-absolute top-0 end-0 p-1">
                                    <span class="badge bg-primary">${index + 1}</span>
                                </div>
                            </div>
                        `;
                        container.appendChild(previewDiv);
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    // Reset modal when closed
    document.getElementById('addImageModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('project_image').value = '';
        document.getElementById('imagePreviewContainer').innerHTML = '';
    });

    // Edit Image Modal Functionality
    document.getElementById('editImageModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const imageId = button.getAttribute('data-image-id');
        const imagePath = button.getAttribute('data-image-path');
        const isMain = button.getAttribute('data-is-main');

        // Set form action
        document.getElementById('editImageForm').action = `/admin/projects/images/${imageId}/replace`;

        // Fill form fields
        document.getElementById('edit_image_file').value = ''; // Clear previous file input
        document.getElementById('is_main_checkbox').checked = (isMain === '1'); // Set checkbox
        document.getElementById('currentImagePreview').src = imagePath;

        // Reset new image preview
        document.getElementById('newImagePreviewContainer').style.display = 'none';
    });

    // New image preview in edit modal
    document.getElementById('edit_image_file').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('newImagePreview');
        const container = document.getElementById('newImagePreviewContainer');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            container.style.display = 'none';
        }
    });

    // Reset edit modal when closed
    document.getElementById('editImageModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('edit_image_file').value = '';
        document.getElementById('is_main_checkbox').checked = false;
        document.getElementById('newImagePreviewContainer').style.display = 'none';
    });

    function deleteImage(imageId) {
        const formData = new FormData();
        formData.append('csrf', "<?=getCsrf()?>");
        formData.append('_method', 'DELETE');

        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'لن تتمكن من التراجع عن هذا الإجراء!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/projects/images/${imageId}/delete`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('تم الحذف!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('خطأ!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('خطأ!', "Error deleting image. Please try again.", 'error');

                    });
            }
        });
    }

    // Set Main Image Function
    function setMainImage(imageId) {
        if (confirm('Are you sure you want to set this image as the main project image?')) {
            const formData = new FormData();
            formData.append('csrf', "<?=getCsrf()?>");
            formData.append('image_id', imageId);

            fetch(`/admin/projects/images/${imageId}/set-main`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error('Error updating main image: ' + data.message)
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('Error updating main image. Please try again.');
                });
        }
    }

    // Refresh LightGallery after adding new images (if needed)
    function refreshGallery() {
        if (gallery) {
            gallery.refresh();
        }
    }

    // Add hover effects for action buttons
    document.addEventListener('DOMContentLoaded', function () {
        const imageContainers = document.querySelectorAll('.position-relative');

        imageContainers.forEach(container => {
            const actionButtons = container.querySelector('.btn-group-vertical');

            if (actionButtons) {
                // Hide buttons by default
                actionButtons.style.opacity = '0';
                actionButtons.style.transition = 'opacity 0.3s ease';

                // Show on hover
                container.addEventListener('mouseenter', function () {
                    actionButtons.style.opacity = '1';
                });

                // Hide on mouse leave
                container.addEventListener('mouseleave', function () {
                    actionButtons.style.opacity = '0';
                });
            }
        });
    });
</script>

