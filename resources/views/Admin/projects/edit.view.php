<?php setTitle("Edit Project"); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Project</h1>
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
                            /** @var array $project */
                            echo $form->openForm(['action' => route('updateProject',['id'=>$project['id']]), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation', 'novalidate' => ''])->render();
                            $form->formGroupClass('col-md-6 mb-2');
                            echo setCsrf();
                            echo setMethod('PUT');
                            echo $form->input('title', 'Title', old('title',$project['title']))->attrs(['required' => true, 'placeholder' => 'Enter project title'])->render();

                            $categories = ['Web Development', 'Mobile App', 'Desktop App', 'UI/UX Design', 'Other'];
                            // استخدام Select مع المصفوفة البسيطة مباشرةً
                            echo $form->select(
                                'category', // اسم حقل الـ select
                                $categories, // المصفوفة البسيطة مباشرةً
                                [], // لا حاجة لتحديد option_attrs إذا كانت بسيطة (ستفترض 'id' و 'name' بنفس القيمة)
                                'Choose category...' // تسمية الحقل
                            )->selected(old('category',$project['category'])) // اختيار قيمة افتراضية (يجب أن تتطابق مع قيمة في المصفوفة الأصلية)
                            ->selectAttrs(['required' => 'true']) // سمات إضافية
                            ->selectClass('form-control mb-3')
                                ->render();

                            echo $form->textarea('description', 'Description')
                                ->value(old('description',$project['description']))
                                ->attrs(['rows' => 5])
                                ->formGroupClass('col-md-12 mb-3')
                                ->textareaClass('tinymce ') // إذا كنت تستخدم TinyMCE
                                ->render();

                            echo $form->input('host_url', 'Host URL')
                                ->type('url')
                                ->value(old('host_url',$project['host_url']))
                                ->formGroupClass('col-md-6')
                                ->render();

                            echo $form->input('github_url', 'GitHub URL')
                                ->type('url')
                                ->value(old('github_url',$project['github_url']))
                                ->formGroupClass('col-md-6')
                                ->class('form-control')
                                ->render();

                            echo $form->input('technologies', 'Technologies Used')
                                ->type('text')
                                ->value(old('technologies',$project['technologies']))
                                ->attrs([
                                    'placeholder' => 'e.g., HTML, CSS, JavaScript, PHP',
                                    'required' => true // إضافة سمة required هنا
                                ])
                                ->formGroupClass('col-12')
                                ->class('form-control')
                                ->render();

                            echo $form->button(['type' => 'submit', 'class' => 'btn btn-primary mt-3'], 'Save', '<i class="fas fa-save mr-2"></i>')->render();

                            echo $form->closeForm()->render();
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?= assets('plugins/select2/js/select2.full.min.js') ?>"></script>
<script src="<?= assets('js/DropzoneCard.js') ?>"></script>

<script>
    // Form validation
    (function () {
        'use strict'

        $('.select2').select2()

        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        });

    })()
</script>


