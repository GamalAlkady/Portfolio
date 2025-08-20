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
                        echo $form->openForm(['action' => route('skill.update',['id'=>$skill['id']]), 'method' => 'post', 'enctype' => "multipart/form-data", 'class' => 'row needs-validation', 'novalidate' => ''])->render();
                        $form->formGroupClass('col-md-6 mb-2');
                        echo setCsrf();
                        echo setMethod('PUT');

                        $activeEn=session()->get('activeEn')??true;
                         ?>

                    <!-- Language Tabs -->
                    <div class="col-12 mb-4">
                        <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?=($activeEn?'active':'')?>" id="english-tab" data-bs-toggle="tab"
                                    data-bs-target="#english" type="button" role="tab">
                                    <i class="fas fa-globe me-2"></i><?= __("english") ?>
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?=($activeEn?'':'active')?>" id="arabic-tab" data-bs-toggle="tab"
                                    data-bs-target="#arabic" type="button" role="tab">
                                    <i class="fas fa-globe me-2"></i><?= __("arabic") ?>
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content border border-top-0 p-3" id="languageTabsContent">
                            <!-- English Content -->
                            <div class="tab-pane fade <?=($activeEn?' show active':'')?>" id="english" role="tabpanel">
                                <div class="row">
                                    <?php
                                    $input = $form->input('name[en]', __("name") . ' (' . __("english") . ')', old('name.en',$skill['name_en']))
                                        ->attrs(['placeholder' => __("enter_name")])
                                        ->errorMessage(errors('name.en'))
                                        ->formGroupClass('col-md-6 mb-3');
                                    if (locale() == 'en')    $input->required();
                                    echo  $input->render();

                                    $description = $form->textarea('description[en]', __("description") . ' (' . __("english") . ')')
                                        ->value(old('description.en',$skill['description_en']))
                                        ->attrs(['rows' => 5, 'placeholder' => __("enter_description")])
                                        ->errorMessage(errors('description.en'))
                                        ->formGroupClass('col-md-12 mb-3')
                                        ->textareaClass('tinymce-en');
                                    if (locale() == 'en')    $description->required();
                                    echo $description->render();
                                    ?>
                                </div>
                            </div>

                            <!-- Arabic Content -->
                            <div class="tab-pane fade <?=($activeEn?'':' show active')?>" id="arabic" role="tabpanel">
                                <div class="row">
                                    <?php
                                    $input = $form->input('name[ar]', __("name") . ' (' . __("arabic") . ')', old('name.ar',$skill['name_ar']))
                                        ->attrs(['placeholder' => __("enter_name")])
                                        ->formGroupClass('col-md-6 mb-3')
                                        ->errorMessage(errors('name.ar'));
                                    if (locale() == 'ar')    $input->required();
                                    echo  $input->render();

                                    $description =  $form->textarea('description[ar]', __("description") . ' (' . __("arabic") . ')')
                                        ->value(old('description.ar',$skill['description_ar']))
                                        ->attrs(['rows' => 5, 'placeholder' => __("enter_description")])
                                        ->errorMessage(errors('description.ar'))
                                        ->formGroupClass('col-md-12 mb-3')
                                        ->textareaClass('tinymce-ar');
                                    if (locale() == 'ar')    $description->required();
                                    echo $description->render();
                                    ?>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!-- Common Fields -->
                    <div class="col-12">
                        <h5 class="mb-3"><?= __("common_fields") ?></h5>
                        <div class="row">
                            <?php

                            echo $form->select(
                                'category',
                                $categories,
                                ['id', 'name'],
                                __("choose_category")
                            )
                                ->selected(old('category',$skill['category']))
                                ->selectClass('form-control mb-3')
                                ->formGroupClass('col-md-12 mb-3')
                                ->attrs(['required' => true])
                                ->render();
                            ?>
                        </div>
                    </div>

                        <div class="col-12 mt-4 d-flex justify-content-between">
                            <div>
                                <button onclick="history.back()" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i><?=__('back')?>
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
