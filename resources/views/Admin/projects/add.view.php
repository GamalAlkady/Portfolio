<?php setTitle(__("add_project")); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= __("add_project") ?></h1>
                </div>
                <div class="col-sm-6">
                    <!--                    <ol class="breadcrumb float-sm-right">-->
                    <!--                        <li class="breadcrumb-item"><a href="#">Home</a></li>-->
                    <!--                        <li class="breadcrumb-item active">Dashboard v2</li>-->
                    <!--                    </ol>-->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card p-5">
                        <div class="form-container">
                            <?php
                            $form = new FormHelper();
                            echo $form->openForm(['action' => route('storeProject'), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation', 'novalidate' => ''])->render();
                            $form->formGroupClass('col-md-6 mb-2');
                            echo setCsrf();
                            echo $form->input('title', __("title"), old('title'))->attrs(['required' => true, 'placeholder' => __("enter_project_title")])->render();

                            $categories = [__("web_development"), __("mobile_app"), __("desktop_app"), __("ui_ux_design"), __("other")];
                            echo $form->select(
                                'category',
                                $categories,
                                [],
                                __("choose_category")
                            )->selected(old('category'))
                                ->selectAttrs(['required' => 'true'])
                                ->selectClass('form-control mb-3')
                                ->render();

                            echo $form->textarea('description', __("Description"))
                                ->value(old('description'))
                                ->attrs(['rows' => 5])
                                ->formGroupClass('col-md-12 mb-3')
                                ->textareaClass('tinymce')
                                ->render();

                            echo $form->input('host_url', __("host_url"))
                                ->type('url')
                                ->value(old('host_url'))
                                ->formGroupClass('col-md-6')
                                ->render();

                            echo $form->input('github_url', __("github_url"))
                                ->type('url')
                                ->value(old('github_url'))
                                ->formGroupClass('col-md-6')
                                ->class('form-control')
                                ->render();

                            echo $form->input('technologies', __("technologies_used"))
                                ->type('text')
                                ->value(old('technologies'))
                                ->attrs([
                                    'placeholder' => __("tech_placeholder"),
                                    'required' => true
                                ])
                                ->formGroupClass('col-12')
                                ->class('form-control')
                                ->render();

                            echo $form->fileInput('images[]', __("images"))->placeHolder(__("choose_files"))
                                ->class('custom-file-input')
                                ->attrs([
                                    'placeholder' => __("choose_image"),
                                    'multiple' => '',
                                    'accept' => "image/*",
                                    'required' => true // إضافة سمة required هنا
                                ])
                                ->render();
                            ?>
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
                            <?php
                            echo $form->button(['type' => 'submit', 'class' => 'btn btn-primary mt-3'], __("save"), '<i class="fas fa-save mr-2"></i>')->render();
                            echo $form->closeForm()->render();
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    (function() {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        });

        var fileInput = document.querySelector('.custom-file-input');
        fileInput.addEventListener('change', function({
            target
        }) {
            console.log(target.files)
            const label = document.querySelector('.custom-file-label');
            label.innerHTML = target.files.length + " " + "<?= __("files") ?>";

            const previewContainer = document.getElementById('otherImagesPreview');
            previewContainer.innerHTML = ''; // Clear existing previews

            Array.from(target.files).forEach(file => {
                const reader = new FileReader();
                const imgPreview = document.createElement('img');
                imgPreview.className = 'preview-image';

                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                }

                reader.readAsDataURL(file);
                previewContainer.appendChild(imgPreview);
            });
        });

        function previewImages(input) {
            const previewContainer = document.getElementById('otherImagesPreview');
            previewContainer.innerHTML = ''; // Clear existing previews

            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                const imgPreview = document.createElement('img');
                imgPreview.className = 'preview-image';

                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                }

                reader.readAsDataURL(file);
                previewContainer.appendChild(imgPreview);
            });
        }
    })();
</script>