<?php
$isEdit = isset($certificate) && !empty($certificate);
setTitle(__($isEdit ? "edit_certificate" : "add_certificate") ?? "إضافة شهادة") ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-plus-circle mr-2"></i><?= __($isEdit ? "edit_certificate" : "add_new_certificate") ?? "إضافة شهادة جديدة" ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>"><?= __("dashboard") ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= route('certificates') ?>"><?= __("certificates") ?></a></li>
                        <li class="breadcrumb-item active"><?= __($isEdit ? "edit_certificate" : "add_certificate")  ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __("certificate_information") ?? "معلومات الشهادة" ?></h3>
                        </div>

                        <div class="card-body">
                            <?php
                            // var_dump(flushMessage()->get('errors'));
                            $form = new FormHelper();
                            echo $form->openForm(['action' => $isEdit ? route('certificate.update', ['id' => $certificate['id']]) : route('certificate.store'), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation', 'novalidate' => ''])->render();
                            $form->formGroupClass('col-md-6 mb-2');
                            echo setCsrf();
                            if ($isEdit) {
                                echo setMethod('PUT');
                            } else $certificate = null;

                            renderLangTabs('certificate', function ($lang) use ($form, $certificate) {
                                $input = $form->input('title[' . $lang . ']', __("title", [], $lang), old('title.' . $lang, $certificate['title_' . $lang] ?? ''))
                                    ->attrs(['placeholder' => __("enter_title", [], $lang)])
                                    ->errorMessage(errors('title.' . $lang))
                                    ->formGroupClass('col-md-6 mb-3');
                                if (locale() == $lang)    $input->required();
                                echo  $input->render();

                                $description = $form->textarea('description[' . $lang . ']', __("description", [], $lang))
                                    ->value(old('description.' . $lang, $certificate['description_' . $lang] ?? ''))
                                    ->attrs(['rows' => 5, 'placeholder' => __("enter_description", [], $lang)])
                                    ->errorMessage(errors('description.' . $lang))
                                    ->formGroupClass('col-md-12 mb-3')
                                    ->textareaClass('tinymce-' . $lang);
                                echo $description->render();
                            });
                            ?>

                            <!-- Common Fields -->
                            <div class="col-12 mt-3">
                                <h5 class="mb-3"><?= __("common_fields") ?></h5>
                                <div class="row">
                                    <?php
                                    echo $form->input('issuer', __("issuer"))
                                        ->type('text')
                                        ->attrs(['placeholder' => __("enter_issuer")])
                                        ->required()
                                        ->value(old('issuer', $isEdit ? $certificate['issuer'] : ''))
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->class('form-control')
                                        ->render();


                                    echo $form->select(
                                        'certificate_type',
                                        $certificateTypes,
                                        ['id', 'name'],
                                        __("certificate_type")
                                    )
                                        ->selected(old('certificate_type', $isEdit ? $certificate['certificate_type'] : ''))
                                        ->selectClass('form-control mb-3')
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->attrs(['required' => true])
                                        ->render();



                                    echo $form->input('issued_date', __("issued_date"))
                                        ->type('date')
                                        ->value(old('issued_date', $isEdit ? $certificate['issued_date'] : ''))
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->required()
                                        ->attrs(['placeholder' => __("enter_issued_date")])
                                        ->render();

                                    echo $form->input('expiry_date', __("expiry_date"))
                                        ->type('date')
                                        ->value(old('expiry_date', $isEdit ? $certificate['expiry_date'] : ''))
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->attrs(['placeholder' => __("enter_expiry_date")])
                                        ->class('form-control')
                                        ->smallText(__("leave_empty_if_no_expiry"))
                                        ->render();

                                    echo $form->input('verification_url', __("verification_url"))
                                        ->type('url')
                                        ->value(old('verification_url', $isEdit ? $certificate['verification_url'] : ''))
                                        ->attrs(['placeholder' => __("enter_verification_url")])
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->smallText(__("verification_url_help"))
                                        ->render();

                                    echo $form->input('skills_related', __("skills_related"))
                                        ->type('text')
                                        ->value(old('skills_related', $isEdit ? $certificate['skills_related'] : ''))
                                        ->attrs(['placeholder' => __("enter_skills_related")])
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->smallText(__("skills_help"))
                                        ->render();
                                    ?>

                                    <!-- File Upload -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="certificate_file"><?= __("certificate_file") ?? "ملف الشهادة" ?></label>

                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="certificate_file"
                                                        name="certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="certificate_file"><?= __("choose_file") ?? "اختر ملف" ?></label>
                                                </div>

                                                <small class="form-text text-muted">
                                                    <?= __("file_types_allowed", ['files' => ': PDF, JPG, JPEG, PNG']) ?> (<?= __("max_size", ['size' => '5MB']) ?>)
                                                </small>
                                            </div>

                                        </div>

                                        <div class="col-md-2 form-group">
                                            <label for="certificate_file" style="visibility: hidden;"><?= __("current_file")  ?></label>
                                            <?php if ($isEdit and $certificate['certificate_file']): ?>
                                                <div class="px-2 pt-1 mb-2">
                                                    <a href="<?= assets($certificate['certificate_file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary w-100 ml-2">
                                                        <?= __("current_file") ?>
                                                        <i class="fas fa-external-link-alt ml-1"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="display_order"><?= __("display_order") ?? "ترتيب العرض" ?></label>
                                                <input type="number" class="form-control" id="display_order" name="display_order"
                                                    value="<?=old('display_order',$isEdit?$certificate['display_order']:'')?>" min="0">
                                                <small class="form-text text-muted"><?= __("display_order_help") ?></small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Settings -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status"><?= __("status") ?? "الحالة" ?></label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="<?=old('status',$isEdit?$certificate['status']:'active')?>"><?= __("active") ?? "نشط" ?></option>
                                                    <option value="inactive"><?= __("inactive") ?? "غير نشط" ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group pt-4">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" <?= old('is_featured', $isEdit ? $certificate['is_featured'] : 0) ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="is_featured">
                                                        <i class="fas fa-star text-warning mr-1"></i><?= __("featured_certificate") ?? "شهادة مميزة" ?>
                                                    </label>
                                                </div>
                                                <small class="form-text text-muted"><?= __("featured_help") ?? "الشهادات المميزة تظهر في المقدمة" ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fas fa-eye mr-2"></i><?= __("preview") ?? "معاينة" ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="certificate-preview">
                                                <h6 id="preview-title" class="font-weight-bold text-primary">
                                                    <?= __("certificate_title_will_appear_here") ?? "عنوان الشهادة سيظهر هنا" ?>
                                                </h6>
                                                <p id="preview-issuer" class="text-muted mb-1">
                                                    <i class="fas fa-building mr-1"></i><span><?= __("issuer_name") ?? "اسم الجهة المانحة" ?></span>
                                                </p>
                                                <p id="preview-date" class="text-muted mb-1">
                                                    <i class="fas fa-calendar mr-1"></i><span><?= __("issue_date") ?? "تاريخ المنح" ?></span>
                                                </p>
                                                <p id="preview-type" class="mb-2">
                                                    <span class="badge badge-primary" id="preview-type-badge"><?= __("certificate_type") ?? "نوع الشهادة" ?></span>
                                                </p>
                                                <p id="preview-description" class="text-muted">
                                                    <?= __("certificate_description") ?? "وصف الشهادة سيظهر هنا" ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    // Live Preview Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const currentLang = '<?= locale() ?>';

        // Title Preview
        const titleAr = document.getElementById('title[ar]');
        const titleEn = document.getElementById('title[en]');
        const previewTitle = document.getElementById('preview-title');

        function updateTitlePreview() {
            const title = currentLang === 'ar' ? titleAr.value : titleEn.value;
            previewTitle.textContent = title || '<?= __("certificate_title_will_appear_here") ?? "عنوان الشهادة سيظهر هنا" ?>';
        }

        titleAr.addEventListener('input', updateTitlePreview);
        titleEn.addEventListener('input', updateTitlePreview);

        // Issuer Preview
        const issuer = document.getElementById('issuer');
        const previewIssuer = document.getElementById('preview-issuer').querySelector('span');

        issuer.addEventListener('input', function() {
            previewIssuer.textContent = this.value || '<?= __("issuer_name") ?? "اسم الجهة المانحة" ?>';
        });

        // Date Preview
        const issuedDate = document.getElementById('issued_date');
        const previewDate = document.getElementById('preview-date').querySelector('span');


        issuedDate.addEventListener('input', function() {
            previewDate.textContent = this.value || '<?= __("issue_date") ?? "تاريخ المنح" ?>';
        });


        // Type Preview
        const certificateType = document.getElementById('certificate_type');
        const previewTypeBadge = document.getElementById('preview-type-badge');

        certificateType.addEventListener('change', function() {
            const typeText = this.options[this.selectedIndex].text;
            previewTypeBadge.textContent = typeText || '<?= __("certificate_type") ?? "نوع الشهادة" ?>';

            // Change badge color based on type
            previewTypeBadge.className = 'badge badge-' +
                (this.value === 'certificate' ? 'primary' :
                    this.value === 'award' ? 'success' :
                    this.value === 'course' ? 'info' : 'warning');
        });


        // Description Preview
        const descriptionAr = document.getElementById('description[ar]');
        const descriptionEn = document.getElementById('description[en]');
        const previewDescription = document.getElementById('preview-description');

        function updateDescriptionPreview() {
            const description = currentLang === 'ar' ? descriptionAr.value : descriptionEn.value;
            previewDescription.textContent = description || '<?= __("certificate_description") ?? "وصف الشهادة سيظهر هنا" ?>';
        }

        descriptionAr.addEventListener('input', updateDescriptionPreview);
        descriptionEn.addEventListener('input', updateDescriptionPreview);

        // File input label update
        const fileInput = document.getElementById('certificate_file');
        const fileLabel = document.querySelector('.custom-file-label');

        fileInput.addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : '<?= __("choose_file") ?? "اختر ملف" ?>';
            fileLabel.textContent = fileName;
        });
    });
</script>

<style>
    #certificate-preview {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        background: white;
    }

    .form-group label {
        font-weight: 600;
    }

    .text-danger {
        font-weight: bold;
    }

    .custom-file-label::after {
        content: "<?= __("browse") ?? "تصفح" ?>";
    }
</style>