<?php
$isEdit = isset($project) && !empty($project);
setTitle(__($isEdit ? "edit_project" : "add_project")); ?>

<!-- إضافة الترجمات للـ JavaScript -->
<?= renderTranslations(locale(), [
    'at_least_one_language_required',
    'validation_errors',
    'loading',
    'save',
    'cancel',
    'error',
    'success',
    'warning',
    'confirm_delete',
    'delete_warning',
    'yes_delete',
    'deleted_successfully',
    'delete_failed'
]) ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= __($isEdit ? "edit_project" : "add_project") ?></h1>
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
                            <!-- عرض الأخطاء -->

                            <!-- ملاحظة متعددة اللغات -->
                            <div class="toast align-items-center  alert-info w-100" style="max-width: none;" aria-live="assertive" aria-atomic="true" id='toast'>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="toast-body">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Hello, world! This is a toast message.
                                    </div>
                                    <button type="button" class="btn-close mx-2" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <?= __('multilingual_note') ?>
                            </div>

                            <?php
                            $form = new FormHelper();
                            echo $form->openForm(['action' => $isEdit ? route('project.update', ['id' => $project['id']]) : route('project.store'), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation', 'novalidate' => ''])->render();
                            $form->formGroupClass('col-md-6 mb-2');
                            echo setCsrf();
                            if ($isEdit) {
                                echo setMethod('PUT');
                            } else $project = null;

                            renderLangTabs('project', function ($lang) use ($form, $project) {
                                // var_dump($project);
                                $input = $form->input('title[' . $lang . ']', __("title", [], $lang), old('title.' . $lang, $project['title_' . $lang] ?? ''))
                                    ->attrs(['placeholder' => __("enter_title", [], $lang)])
                                    ->errorMessage(errors('title.' . $lang))
                                    ->formGroupClass('col-md-6 mb-3');
                                if (locale() == $lang)    $input->required();
                                echo  $input->render();

                                $description = $form->textarea('description[' . $lang . ']', __("description", [], $lang))
                                    ->value(old('description.' . $lang, $project['description_' . $lang] ?? ''))
                                    ->attrs(['rows' => 5, 'placeholder' => __("enter_description", [], $lang)])
                                    ->errorMessage(errors('description.' . $lang))
                                    ->formGroupClass('col-md-12 mb-3')
                                    ->textareaClass('tinymce-' . $lang);
                                if (locale() == $lang)    $description->required();
                                echo $description->render();
                            });
                            ?>


                            <!-- Common Fields -->
                            <div class="col-12 mt-3">
                                <h5 class="mb-3"><?= __("common_fields") ?></h5>
                                <div class="row">
                                    <?php

                                    echo $form->select(
                                        'category',
                                        $categories,
                                        ['id', 'name'],
                                        __("choose_category")
                                    )
                                        ->selected(old('category', $isEdit ? $project['category'] : ''))
                                        ->selectClass('form-control mb-3')
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->attrs(['required' => true])
                                        ->render();

                                    echo $form->input('technologies', __("technologies_used"))
                                        ->type('text')
                                        ->attrs(['placeholder' => __("tech_placeholder")])
                                        // ->required()
                                        ->value(old('technologies', $isEdit ? $project['technologies'] : ''))
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->class('form-control')
                                        ->render();

                                    echo $form->input('host_url', __("host_url"))
                                        ->type('url')
                                        ->value(old('host_url', $project['host_url'] ?? ''))
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->attrs(['placeholder' => __("enter_host_url")])
                                        ->render();

                                    echo $form->input('github_url', __("github_url"))
                                        ->type('url')
                                        ->value(old('github_url', $isEdit ? $project['github_url'] : ''))
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->attrs(['placeholder' => __("enter_github_url")])
                                        ->class('form-control')
                                        ->render();
                                    ?>
                                </div>
                            </div>

                            <?php
                            if (!$isEdit) {
                                echo $form->fileInput('images[]', __("images"))->placeHolder(__("choose_files"))
                                    ->class('custom-file-input')
                                    ->attrs([
                                        'placeholder' => __("choose_image"),
                                        'multiple' => '',
                                        'accept' => "image/*",
                                    ])
                                    ->errorMessage(errors('images'))
                                    ->render();
                            }
                            ?>
                            <div id="otherImagesPreview" class="mt-2 d-flex flex-wrap gap-2">
                                <?php
                                if (isset($_FILES['images']) && !empty($_FILES['images']['tmp_name'][0])) {
                                    foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                                        if (is_uploaded_file($tmpName)) {
                                            $mimeType = mime_content_type($tmpName);
                                            if (strpos($mimeType, 'image/') === 0) {
                                                $base64 = base64_encode(file_get_contents($tmpName));
                                                echo '<img src="data:' . $mimeType . ';base64,' . $base64 . '" class="preview-image" style="display:block;">';
                                            }
                                        }
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
        // التحقق من وجود محتوى بلغة واحدة على الأقل
        function validateLanguageContent() {
            const titleAr = document.querySelector('input[name="title[ar]"]');
            const titleEn = document.querySelector('input[name="title[en]"]');
            const descAr = document.querySelector('textarea[name="description[ar]"]');
            const descEn = document.querySelector('textarea[name="description[en]"]');

            const hasArabic = (titleAr && titleAr.value.trim()) || (descAr && descAr.value.trim());
            const hasEnglish = (titleEn && titleEn.value.trim()) || (descEn && descEn.value.trim());

            if (!hasArabic && !hasEnglish) {
                showLanguageError();
                return false;
            }

            hideLanguageError();
            return true;
        }

        function showLanguageError() {
            let errorDiv = document.querySelector('.language-error');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-warning language-error';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' +
                    '<?= __("at_least_one_language_required") ?>';
                const form = document.querySelector('.needs-validation');
                form.insertBefore(errorDiv, form.firstChild);
            }
        }

        function hideLanguageError() {
            const errorDiv = document.querySelector('.language-error');
            if (errorDiv) {
                errorDiv.remove();
            }
        }

        // التحقق عند تغيير المحتوى
        document.addEventListener('DOMContentLoaded', function() {
            const titleAr = document.querySelector('input[name="title[ar]"]');
            const titleEn = document.querySelector('input[name="title[en]"]');
            const descAr = document.querySelector('textarea[name="description[ar]"]');
            const descEn = document.querySelector('textarea[name="description[en]"]');

            [titleAr, titleEn, descAr, descEn].forEach(field => {
                if (field) {
                    field.addEventListener('input', validateLanguageContent);
                }
            });
        });
        <?php
        if (!$isEdit) {
        ?>


            previewImages('.custom-file-input', 'otherImagesPreview');

            function previewImages(fileInput, containerImagesId) {
                var fileInput = (typeof(fileInput) == 'string') ? document.querySelector(fileInput) : fileInput;
                fileInput.addEventListener('change', function({
                    target
                }) {
                    const label = document.querySelector('.custom-file-label');
                    label.innerHTML = target.files.length + " " + "<?= __("files") ?>";

                    const previewContainer = document.getElementById(containerImagesId);
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
            }

        <?php } ?>
    })();
</script>