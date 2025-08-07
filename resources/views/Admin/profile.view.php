<?php use Devamirul\PhpMicro\core\Foundation\Session\Session;

setTitle("Profile"); ?>
<?php //$user = auth()->user(); ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <form action="<?=route('updateProfile')?>" method="post" enctype="multipart/form-data">
                    <div class="card-body box-profile row">
                        <div class="col-md-3">

                            <!-- Profile Image -->
                            <!--                    <div class="card card-primary card-outline">-->
                            <div class="text-center">
                                <img id="myImage" class="profile-user-img img-fluid img-circle"
                                     src="<?= (!empty($user['image']))?assets($user['image']):assets('images/user.png') ?>"
                                     alt="Click to change image">
                                <input type="file" id="fileInput" name="image" accept="image/*" style="display: none;">
                                <input type="text" id="oldFileInput" name="image" value="<?=$user['image']?>" accept="image/*" style="display: none;">
                            </div>


                        </div>


                        <!-- /.col -->
                        <div class="col-md-9">

                            <div class="tab-content">

                                <div class="active tab-pane" id="settings">
                                    <?php
                                    $form = new FormHelper();
                                    echo $form->openForm(['action' => route('updateProfile'), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation form-horizontal', 'novalidate' => ''])->render();
                                    $form->formGroupClass('row');

                                    echo $form->input('name', 'Name', old('name', $user['name']))
                                        ->labelClass('col-sm-2 col-form-label')->controlsClass('col-sm-10')->render();

                                    echo $form->input('email', 'Email', old('email', $user['email']))
                                        ->labelClass('col-sm-2 col-form-label')->controlsClass('col-sm-10')->render();

                                    echo $form->input('specialization', 'Specialization', old('specialization', $user['specialization']))
                                        ->labelClass('col-sm-2 col-form-label')->controlsClass('col-sm-10')->render();

                                    echo $form->input('location', 'Location', old('location', $user['location']))
                                        ->labelClass('col-sm-2 col-form-label')->controlsClass('col-sm-10')->render();
                                    ?>
                                    <?php echo setCsrf() ?>
                                    <?php echo setMethod("PUT") ?>


                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10 text-end">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                    <?php echo $form->closeForm()->render(); ?>
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
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Description</strong>


                            <div class="mt-3">
                                <div id="description"><?php echo ($user['description']) ?></div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="descriptionEdit" class="btn btn-info" type="button">Edit</button>
                                <button id="descriptionSave" class="btn btn-primary" type="button">Save</button>
                            </div>
                            <hr>

                            <strong><i class="fas fa-book mr-1"></i> Education</strong>


                            <div class="mt-3">
                                <div id="education"><?php echo htmlspecialchars_decode($user['education']) ?></div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="educationEdit" class="btn btn-info" type="button">Edit</button>
                                <button id="educationSave" class="btn btn-primary" type="button">Save</button>
                            </div>
                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Experience</strong>

                            <div class="mt-3">
                                <div id="experience"><?= htmlspecialchars_decode($user['experience']) ?></div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="experienceEdit" class="btn btn-info" type="button">Edit</button>
                                <button id="experienceSave" class="btn btn-primary" type="button">Save</button>
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
<!-- Summernote -->
<script src="<?= assets('plugins/summernote/summernote-bs4.min.js') ?>"></script>
<script>
    $(function () {
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

    });
    const editSave = (fieldName) => {
        const saveBtn = $(`#${fieldName}Save`);
        const editBtn = $(`#${fieldName}Edit`);
        saveBtn.toggleClass("d-none");

        editBtn.on("click", function () {
            $(`#${fieldName}`).summernote({focus: true});
            saveBtn.toggleClass("d-none");
            editBtn.toggleClass("d-none");
        });

        saveBtn.on("click", function () {
           var editorContent  = $(`#${fieldName}`).summernote('code');
            $(`#${fieldName}`).summernote('destroy');
            const formData = new FormData();
            formData.append('csrf', "<?=getCsrf()?>");
            formData.append(fieldName, editorContent);
            formData.append('_method', 'PUT');
            fetch("<?=route('updateProfile')?>", {
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
</script>
