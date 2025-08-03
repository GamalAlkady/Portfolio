<?php setTitle("Add Project"); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Project</h1>
                </div><!-- /.col -->
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
                            echo '<input type="file" name="images[]" id="file-input" multiple hidden>';
                            echo $form->input('title', 'Title', old('title'))->attrs(['required' => true, 'placeholder' => 'Enter project title'])->render();

                            $categories = ['Web Development', 'Mobile App', 'Desktop App', 'UI/UX Design', 'Other'];
                            // استخدام Select مع المصفوفة البسيطة مباشرةً
                            echo $form->select(
                                'category', // اسم حقل الـ select
                                $categories, // المصفوفة البسيطة مباشرةً
                                [], // لا حاجة لتحديد option_attrs إذا كانت بسيطة (ستفترض 'id' و 'name' بنفس القيمة)
                                'Choose category...' // تسمية الحقل
                            )->selected(old('category')) // اختيار قيمة افتراضية (يجب أن تتطابق مع قيمة في المصفوفة الأصلية)
                            ->selectAttrs(['required' => 'true']) // سمات إضافية
                            ->selectClass('form-control mb-3')
                            ->render();

                            echo $form->textarea('description', 'Description')
                                ->value(old('description'))
                                ->attrs(['rows' => 5])
                                ->formGroupClass('col-md-12 mb-3')
                                ->textareaClass('tinymce ') // إذا كنت تستخدم TinyMCE
                                ->render();

                            echo $form->input('host_url', 'Host URL')
                                ->type('url')
                                ->value(old('host_url'))
                                ->formGroupClass('col-md-6')
                                ->render();

                            echo $form->input('github_url', 'GitHub URL')
                                ->type('url')
                                ->value(old('github_url'))
                                ->formGroupClass('col-md-6')
                                ->class('form-control')
                                ->render();

                            echo $form->input('technologies', 'Technologies Used')
                                ->type('text')
                                ->value(old('technologies'))
                                ->attrs([
                                    'placeholder' => 'e.g., HTML, CSS, JavaScript, PHP',
                                    'required' => true // إضافة سمة required هنا
                                ])
                                ->formGroupClass('col-12')
                                ->class('form-control')
                                ->render();

                            echo $form->fileInput('images','Images')->placeHolder('Choose files')
                                ->class('custom-file-input')
                                ->attrs([
                                    'placeholder' => 'Choose image',
                                    'multiple'=>'',
                                     'accept'=>"image/*",
                                    'required' => true // إضافة سمة required هنا
                                ])
                                ->render();
//                            echo '  <div id="dropzone-container" class="col-md-12"></div>';
                            ?>

                            <?php
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

        var fileInput = document.querySelector('.custom-file-input');
        fileInput.addEventListener('change',function ({target}){
            console.log(target.files)
            const label = document.querySelector('.custom-file-label');
            label.innerHTML = target.files.length +" files";

            const previewContainer = document.getElementById('otherImagesPreview');
            previewContainer.innerHTML = ''; // Clear existing previews

            Array.from(target.files).forEach(file => {
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
        });
        // DropzoneJS Demo Code End
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
    })();
</script>


