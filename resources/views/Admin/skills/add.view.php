<?php
$isEdit = isset($skill);
setTitle(__(($isEdit ? 'edit_skill' : 'add_skill')));
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= __($isEdit ? 'edit_skill' : 'add_skill') ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>"><?= __('dashboard') ?></a></li>
                        <li class="breadcrumb-item active"><?= __($isEdit ? 'edit_skill' : 'add_skill') ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card p-5">
                <div class="form-container">

                    <?php
                    $form = new FormHelper();
                    echo $form->openForm(['action' => ($isEdit ? route('skill.update', ['id' => $skill['id']]) : route('skill.store')), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation', 'novalidate' => ''])->render();
                    echo setCsrf();
                    if ($isEdit) {
                        echo setMethod('PUT');
                    } else $skill = null;
                    ?>
                    <!-- Language Tabs -->
                    <?php
                    renderLangTabs('skill', function ($lang) use ($form, $skill) {
                        $form->formGroupClass('col-md-6 mb-2');
                        $activeEn = session()->get('activeEn') ?? true;
                        $input = $form->input('name[' . $lang . ']', __("name", [], $lang), old('name.' . $lang, isset($skill) ? $skill['name_' . $lang] : ''))
                            ->attrs(['placeholder' => __("enter_name", [], $lang)])
                            ->errorMessage(errors('name.' . $lang))
                            ->formGroupClass('col-md-6 mb-3');
                        if (locale() == $lang)    $input->required();
                        echo  $input->render();

                        $description = $form->textarea('description[' . $lang . ']', __("description", [], $lang))
                            ->value(old('description.' . $lang, isset($skill) ? $skill['description_' . $lang] : ''))
                            ->attrs(['rows' => 5, 'placeholder' => __("enter_description", [], $lang)])
                            ->errorMessage(errors('description.' . $lang))
                            ->formGroupClass('col-md-12 mb-3')
                            ->textareaClass('tinymce-' . $lang);
                        if (locale() == $lang)    $description->required();
                        echo $description->render();
                    }, function () use ($form,$skill,$categories){ 

                                echo $form->select( 
                                    'category',
                                    $categories,
                                    ['id', 'name'],
                                    __("choose_category")
                                )
                                    ->selected(old('category', isset($skill) ? $skill['category'] : ''))
                                    ->selectClass('form-control mb-3')
                                    ->formGroupClass('col-md-12 mb-3')
                                    ->attrs(['required' => true])
                                    ->render();
                         
                });
                    ?>



                    <div class="col-12 mt-4 d-flex justify-content-between">
                        <div>
                            <button onclick="history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-<?= locale() == 'ar' ? 'right' : 'left' ?> mx-2"></i><?= __('back') ?>
                            </button>
                        </div>
                        <?php echo $form->button(['type' => 'submit', 'class' => 'btn btn-primary mt-3'], __('save'), '<i class="fas fa-save mr-2"></i>')->render(); ?>
                    </div>
                    <?php echo $form->closeForm()->render(); ?>

                </div>
            </div>

        </div>
    </section>
</div>

<script>
    // Form validation
    (function() {
        'use strict'

        // التحقق من وجود محتوى بلغة واحدة على الأقل
        function validateLanguageContent() {
            const nameAr = document.querySelector('input[name="name[ar]"]');
            const nameEn = document.querySelector('input[name="name[en]"]');
            const descAr = document.querySelector('textarea[name="description[ar]"]');
            const descEn = document.querySelector('textarea[name="description[en]"]');

            const hasArabic = (nameAr && nameAr.value.trim()) || (descAr && descAr.value.trim());
            const hasEnglish = (nameEn && nameEn.value.trim()) || (descEn && descEn.value.trim());

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
            const nameAr = document.querySelector('input[name="name[ar]"]');
            const nameEn = document.querySelector('input[name="name[en]"]');
            const descAr = document.querySelector('textarea[name="description[ar]"]');
            const descEn = document.querySelector('textarea[name="description[en]"]');

            [nameAr, nameEn, descAr, descEn].forEach(field => {
                if (field) {
                    field.addEventListener('input', validateLanguageContent);
                }
            });
        });

    })()
</script>