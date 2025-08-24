<?php setTitle(__('certificate_details')); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= __('certificate_details') ?></h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Certificate Header -->
                        <div class="p-4 border-bottom">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                <div>
                                          <span class="badge bg-primary text-white rounded-pill mb-2">
                                        <?=
                                        /** @var array $certificate */
                                        __($certificate['certificate_type']) ?>
                                    </span>
                                    <h1 class="h2 fw-bold"><?= $certificate['title'] ?></h1>
                                    <span class="text-muted"><?= __('issued_by') ?>: <?= $certificate['issuer'] ?></span>
                                </div>

                                <div>
                                    <div class="d-flex justify-content-around mt-3 mt-md-0">
                                        <a href="/admin/certificates/<?php echo $certificate['id']; ?>/edit" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" 
                                                onclick="confirmDelete('<?= getCsrf() ?>','<?= route('certificate.delete', ['id' => $certificate['id']]) ?>','<?= route('certificates') ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <div class="mt-3">
                                        <span class="text-muted"><?= __('issue_date') ?>: <?= $certificate['issued_date'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Certificate Details -->
                        <div class="card-body border-bottom">

                            <div class="p-4">
                                <div class="mb-4">
                                    <h2 class="h4 fw-semibold mb-3"><?= __('certificate_description') ?></h2>
                                    <p class="text-muted"><?= $certificate['description'] ?></p>
                                </div>

                                <div class="mb-4">
                                    <h3 class="fw-medium mb-2"><?= __('skills_related') ?></h3>
                                    <p><?= htmlspecialchars($certificate['skills_related']) ?></p>
                                </div>

                                <?php if (!empty($certificate['verification_url'])): ?>
                                <div class="mt-4">
                                    <a href="<?= $certificate['verification_url'] ?>" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-external-link-alt me-2"></i> <?= __('verify_certificate') ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Certificate Image -->
                        <?php if (!empty($certificate['image_path'])): ?>
                        <div class="card-body">
                            <div class="text-center">
                                <img src="<?= $certificate['image_path'] ?>" alt="<?= $certificate['title'] ?>" 
                                     class="img-fluid rounded shadow-sm" style="max-height: 500px;">
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>