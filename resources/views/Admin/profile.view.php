<?= setTitle(__('profile')) ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('profile') ?></h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <form action="<?= route('updateSetting') ?>" method="post" enctype="multipart/form-data">
                    <div class="card-body box-profile row">
                        <div class="col-md-3">

                            <!-- Profile Image -->
                            <div class="text-center">
                                <img id="myImage" class="profile-user-img img-fluid img-circle"
                                    src="<?= (!empty(setting('image'))) ? assets(setting('image')) : assets('images/user.png') ?>"
                                    alt="Click to change image">
                                <input type="file" id="fileInput" name="image" accept="image/*" style="display: none;">
                                <input type="hidden" id="oldFileInput" name="image" value="<?= setting('image') ?>" accept="image/*" style="display: none;">
                            </div>


                        </div>


                        <!-- /.col -->
                        <div class="col-md-9">

                            <div class="tab-content">

                                <div class="active tab-pane" id="settings">
                                    <?php
                                    $form = new FormHelper();
                                    echo $form->openForm(['action' => route('updateSetting'), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation form-horizontal', 'novalidate' => ''])->render();
                                    echo setCsrf();
                                    echo setMethod("PUT");
                                    $form->formGroupClass('row');

                                    echo $form->input('name', __('name'), old('name', setting('name')))
                                        ->labelClass('col-sm-2 col-form-label')->controlsClass('col-sm-10')->render();

                                    echo $form->input('email', __('name'), old('email', setting('email')))
                                        ->labelClass('col-sm-2 col-form-label')->controlsClass('col-sm-10')->render();

                                    echo $form->input('phone', __('phone'), old('phone', setting('phone')))
                                        ->labelClass('col-sm-2 col-form-label')->controlsClass('col-sm-10')->render();
                                    echo $form->button(['type' => 'submit', 'class' => 'btn btn-primary'], __('save'), '<i class ="fas fa-save mr-2"></i>', 'col-md-11 offset-sm-1 col-sm-10 d-flex justify-content-end')->render();
                                    echo $form->closeForm()->render();
                                    ?>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                        <!-- /.card -->
                    </div>
                </form>
            </div>
            <!-- /.col -->

            <div class="row">
                <div class="col-md-12">
                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?=__('about_me')?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php
                            echo $form->openForm(['action' => route('updateSetting'), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation form-horizontal', 'novalidate' => ''])->render();
                            echo setCsrf();
                            echo setMethod("PUT");
                            $form->formGroupClass('row col-md-11');

                            echo $form->input('specialization', __('specialization'), old('specialization', setting('specialization')))
                                ->placeHolder(__('specialization'))
                                ->labelClass('col-sm-2 col-form-label')->controlsClass('col-sm-10')->render();
                            echo $form->button(['type' => 'submit', 'class' => 'btn btn-primary'], __('save'), '<i class ="fas fa-save mr-2"></i>', 'col-md-1 text-right')->render();
                            echo $form->closeForm()->render();
                            ?>
                            <hr>

                            <?php
                            echo $form->openForm(['action' => route('updateSetting'), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation form-horizontal', 'novalidate' => ''])->render();
                            echo setCsrf();
                            echo setMethod("PUT");
                            $form->formGroupClass('row col-md-11');

                            echo $form->input('location', __('location'), old('location', setting('location')))
                                ->placeHolder(__('location'))
                                ->labelClass('col-sm-2 col-form-label')->controlsClass('col-sm-10')->render();
                            echo $form->button(['type' => 'submit', 'class' => 'btn btn-primary'], __('save'), '<i class ="fas fa-save mr-2"></i>', 'col-md-1 text-right')->render();
                            echo $form->closeForm()->render();
                            ?>
                            <hr>
                            <strong><i class="fas fa-book mr-1"></i> <?= __('description') ?></strong>
                            <div class="mt-3">
                                <div id="description"><?php echo setting('description') ?></div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="descriptionEdit" class="btn btn-info" type="button"><?=__('edit')?></button>
                                <button id="descriptionSave" class="btn btn-primary" type="button"><?=__('save')?></button>
                            </div>
                            <hr>

                            <strong><i class="fas fa-book mr-1"></i> <?=__('education')?></strong>
                            <div class="mt-3">
                                <div id="education"><?php echo setting('education') ?></div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="educationEdit" class="btn btn-info" type="button"><?=__('edit')?></button>
                                <button id="educationSave" class="btn btn-primary" type="button"><?=__('save')?></button>
                            </div>
                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> <?= __('experience') ?></strong>

                            <div class="mt-3">
                                <div id="experience"><?= setting('experience') ?></div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="experienceEdit" class="btn btn-info" type="button"><?=__('edit')?></button>
                                <button id="experienceSave" class="btn btn-primary" type="button"><?=__('save')?></button>
                            </div>
                            <hr>

                            <!-- CV/Resume PDF Section -->
                            <strong><i class="fas fa-file-pdf mr-1"></i> <?= __('cv_resume') ?></strong>
                            <div class="mt-3">
                                <?php if (!empty(setting('cv_pdf'))): ?>
                                    <div class="pdf-viewer-container">
                                        <div class="pdf-info mb-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="pdf-details">
                                                    <i class="fas fa-file-pdf text-danger mr-2" style="font-size: 1.5rem;"></i>
                                                    <span class="font-weight-bold"><?= basename(setting('cv_pdf')) ?></span>
                                                    <small class="text-muted d-block"><?= __('uploaded_on') ?>: <?= date('Y-m-d', filemtime(APP_ROOT . '/public/assets/' . setting('cv_pdf'))) ?></small>
                                                </div>
                                                <div class="pdf-actions">
                                                    <a href="<?= assets(setting('cv_pdf')) ?>" target="_blank" class="btn btn-sm btn-outline-primary mr-2">
                                                        <i class="fas fa-external-link-alt mr-1"></i><?= __('open_in_new_tab') ?>
                                                    </a>
                                                    <a href="<?= assets(setting('cv_pdf')) ?>" download class="btn btn-sm btn-outline-success mr-2">
                                                        <i class="fas fa-download mr-1"></i><?= __('download') ?>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletePDF()">
                                                        <i class="fas fa-trash mr-1"></i><?= __('delete') ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- PDF Viewer -->
                                        <div class="pdf-viewer" style="border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                                            <iframe src="<?= assets(setting('cv_pdf')) ?>"
                                                width="100%"
                                                height="600px"
                                                style="border: none;"
                                                title="<?= __('cv_preview') ?>">
                                                <p><?= __('pdf_not_supported') ?>
                                                    <a href="<?= assets(setting('cv_pdf')) ?>" target="_blank"><?= __('click_here_to_view') ?></a>
                                                </p>
                                            </iframe>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="no-pdf-message text-center py-4">
                                        <i class="fas fa-file-pdf text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-2"><?= __('no_cv_uploaded') ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- PDF Upload Form -->
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-info" onclick="showPDFUpload()">
                                    <i class="fas fa-upload mr-1"></i><?= __('upload_cv') ?>
                                </button>
                            </div>

                            <!-- Hidden PDF Upload Form -->
                            <div id="pdfUploadForm" class="mt-3" style="display: none;">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="<?= route('updateSetting') ?>" method="post" enctype="multipart/form-data" id="cvUploadForm">
                                            <?= setCsrf() ?>
                                            <?= setMethod("PUT") ?>

                                            <?php
                                            echo $form->input('cv_pdf', __('select_pdf_file'), setting('cv_pdf'), 'file')
                                                ->attrs(['accept' => '.pdf'])->formGroupClass('row col-md-12')->render();
                                            ?>

                                            <input type="hidden" class="custom-file-input" name="cv_pdf" value="<?= setting('cv_pdf') ?>">

                                            <small class="form-text text-muted">
                                                <?= __('pdf_upload_help') ?>
                                            </small>
                                            <div class="progress mt-2" id="uploadProgress" style="display: none;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                    role="progressbar" style="width: 0%"></div>
                                            </div>


                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-upload mr-1"></i><?= __('upload') ?>
                                                </button>
                                                <button type="button" class="btn btn-secondary ml-2" onclick="hidePDFUpload()">
                                                    <?= __('cancel') ?>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Custom CSS for PDF Section -->
<style>
    .pdf-viewer-container {
        /* background: #f8f9fa; */
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }

    .pdf-info {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .pdf-details {
        display: flex;
        align-items: center;
    }

    .pdf-actions .btn {
        margin-left: 5px;
    }

    .pdf-viewer iframe {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    .no-pdf-message {
        background: white;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        margin: 20px 0;
    }

    #pdfUploadForm .card {
        border: 1px solid #007bff;
        border-radius: 10px;
    }

    #pdfUploadForm .card-body {
        /* background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%); */
    }

    .custom-file-label::after {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .pdf-actions {
            margin-top: 10px;
        }

        .pdf-actions .btn {
            margin: 2px;
            font-size: 12px;
            padding: 5px 10px;
        }

        .pdf-viewer iframe {
            height: 400px !important;
        }

        .pdf-details {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    /* Loading animation */
    .btn:disabled {
        opacity: 0.7;
    }

    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<!-- Summernote -->
<script src="<?= assets('plugins/summernote/summernote-bs4.min.js') ?>"></script>
<script>
    $(function() {
        // Summernote
        // $('.summernote').summernote()

        const myImage = document.getElementById('myImage');
        const fileInput = document.getElementById('fileInput');

        myImage.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    myImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        editSave('description');
        editSave('education');
        editSave('experience');

        // PDF file input change handler
        $('#cv_pdf').on('change', function() {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // CV Upload form submission
        $('#cvUploadForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            const progressBar = $('#uploadProgress');
            const progressBarInner = progressBar.find('.progress-bar');

            // Validate file before upload
            const fileInput = $('#cv_pdf')[0];
            if (!fileInput.files.length) {
                toastr.error('<?= __("please_select_file") ?>');
                return;
            }

            const file = fileInput.files[0];
            if (file.type !== 'application/pdf') {
                toastr.error('<?= __("only_pdf_allowed") ?>');
                return;
            }

            if (file.size > 10 * 1024 * 1024) { // 10MB
                toastr.error('<?= __("file_too_large") ?>');
                return;
            }

            // Show loading state and progress bar
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i><?= __("uploading") ?>...');
            progressBar.show();
            progressBarInner.css('width', '0%');

            // Simulate progress (since we can't track real upload progress with fetch)
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 90) progress = 90;
                progressBarInner.css('width', progress + '%');
            }, 200);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    clearInterval(progressInterval);
                    progressBarInner.css('width', '100%');

                    setTimeout(() => {
                        if (data.success) {
                            toastr.success(data.message);
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            toastr.error(data.message);
                            submitBtn.prop('disabled', false).html(originalText);
                            progressBar.hide();
                        }
                    }, 500);
                })
                .catch(error => {
                    clearInterval(progressInterval);
                    console.error('Error:', error);
                    toastr.error('<?= __("upload_error") ?>');
                    submitBtn.prop('disabled', false).html(originalText);
                    progressBar.hide();
                });
        });

    });
    const editSave = (fieldName) => {
        const saveBtn = $(`#${fieldName}Save`);
        const editBtn = $(`#${fieldName}Edit`);
        saveBtn.toggleClass("d-none");

        editBtn.on("click", function() {
            $(`#${fieldName}`).summernote({
                focus: true
            });
            saveBtn.toggleClass("d-none");
            editBtn.toggleClass("d-none");
        });

        saveBtn.on("click", function() {
            var editorContent = $(`#${fieldName}`).summernote('code');
            $(`#${fieldName}`).summernote('destroy');
            const formData = new FormData();
            formData.append('csrf', "<?= getCsrf() ?>");
            formData.append(fieldName, editorContent);
            formData.append('_method', 'PUT');
            fetch("<?= route('updateSetting') ?>", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // location.reload();
                        toastr.success(data.message);
                        saveBtn.toggleClass("d-none");
                        editBtn.toggleClass("d-none");
                    } else {
                        // console.log(data.message)
                        toastr.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error("Error happened. Please try again.");
                    // Swal.fire('خطأ!', "Error deleting image. Please try again.", 'error');

                });

        });
    }

    // PDF Upload Functions
    function showPDFUpload() {
        $('#pdfUploadForm').slideDown();
        $('html, body').animate({
            scrollTop: $('#pdfUploadForm').offset().top - 100
        }, 500);
    }

    function hidePDFUpload() {
        $('#pdfUploadForm').slideUp();
        $('#cv_pdf').val('');
        $('.custom-file-label').html('<?= __("choose_file") ?>');
    }

    function deletePDF() {
        if (confirm('<?= __("confirm_delete_pdf") ?>')) {
            const formData = new FormData();
            formData.append('csrf', "<?= getCsrf() ?>");
            formData.append('cv_pdf', '');
            formData.append('delete_pdf', '1');
            formData.append('_method', 'PUT');

            fetch("<?= route('updateSetting') ?>", {
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
                        }, 1500);
                    } else {
                        toastr.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('<?= __("delete_error") ?>');
                });
        }
    }
</script>