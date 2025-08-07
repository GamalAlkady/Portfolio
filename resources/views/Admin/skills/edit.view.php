<?php setTitle("Edit Skill"); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Project</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card p-5">
                <?php if (isset($skill)) :?>
                    <div class="form-container">

                        <?php
                        $form = new FormHelper();
                        echo $form->openForm(['action' => route('storeSkill'), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation', 'novalidate' => ''])->render();
                        $form->formGroupClass('col-md-6 mb-2');
                        echo setCsrf();
                        echo $form->input('name', 'Name', old('name',$skill['name']))->attrs(['required' => true, 'placeholder' => 'Enter name'])->render();

                        $categories = ['Technical skills', 'Design skills', 'Personal skills', 'Other'];
                        // استخدام Select مع المصفوفة البسيطة مباشرةً
                        echo $form->select(
                            'category', // اسم حقل الـ select
                            $categories, // المصفوفة البسيطة مباشرةً
                            [], // لا حاجة لتحديد option_attrs إذا كانت بسيطة (ستفترض 'id' و 'name' بنفس القيمة)
                            'Choose category...' // تسمية الحقل
                        )->selected(old('category',$skill['category'])) // اختيار قيمة افتراضية (يجب أن تتطابق مع قيمة في المصفوفة الأصلية)
                        ->selectAttrs(['required' => 'true']) // سمات إضافية
                        ->selectClass('form-control mb-3')
                            ->render();

                        echo $form->textarea('description', 'Description')
                            ->value(old('description',$skill['description']))
                            ->attrs(['rows' => 5])
                            ->formGroupClass('col-md-12 mb-3')
                            ->textareaClass('tinymce ') // إذا كنت تستخدم TinyMCE
                            ->render();
                        ?>
                        <div class="col-12 mt-4 d-flex justify-content-between">
                            <div>
                                <button onclick="history.back()" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Skills
                                </button>
                            </div>
                            <?php echo $form->button(['type' => 'submit', 'class' => 'btn btn-primary mt-3'], 'Save', '<i class="fas fa-save mr-2"></i>')->render(); ?>
                        </div>
                        <?php echo $form->closeForm()->render(); ?>

                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
</div>

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
</script>
