<?php setTitle(__("site_settings")); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= __("site_settings") ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>"><?= __("dashboard") ?></a></li>
                        <li class="breadcrumb-item active"><?= __("settings") ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- عرض الرسائل -->
            <?php if (hasSuccess()): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= success() ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (hasError()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= error() ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <!-- Tabs Navigation -->
                    <div class="card">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="settings-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" 
                                            data-bs-target="#general" type="button" role="tab">
                                        <i class="fas fa-cog me-2"></i><?= __("general_settings") ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" 
                                            data-bs-target="#contact" type="button" role="tab">
                                        <i class="fas fa-address-book me-2"></i><?= __("contact_info") ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="social-tab" data-bs-toggle="tab" 
                                            data-bs-target="#social" type="button" role="tab">
                                        <i class="fas fa-share-alt me-2"></i><?= __("social_media") ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="system-tab" data-bs-toggle="tab" 
                                            data-bs-target="#system" type="button" role="tab">
                                        <i class="fas fa-server me-2"></i><?= __("system_settings") ?>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="card-body">                                      
                            <form action="<?= route('updateSetting') ?>" method="POST" enctype="multipart/form-data">
                                <?= setCsrf() ?>
                                <?= setMethod('PUT') ?>
                                
                                <div class="tab-content" id="settings-tabs-content">
                                    
                                    <!-- General Settings Tab -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="site_name" class="form-label">
                                                        <i class="fas fa-globe me-1"></i><?= __("site_name") ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="site_name" name="site_name" 
                                                           value="<?= htmlspecialchars(setting('site_name')) ?>" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label for="site_logo" class="form-label">
                                                        <i class="fas fa-image me-1"></i><?= __("site_logo") ?>
                                                    </label>
                                                    <input type="file" class="form-control" id="site_logo" name="site_logo" accept="image/*">
                                                    <input type="hidden" class="form-control" id="old_site_logo" name="site_logo" value="<?=setting('site_logo')?>" accept="image/*">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-1">
                                                        <?php if (!empty(setting('site_logo'))): ?>
                                                        <div class="mt-2">
                                                            <img src="<?= assets(setting('site_logo')) ?>" alt="<?= __("current_logo") ?>" 
                                                                 class="img-thumbnail" style="max-height: 60px;">
                                                            <small class="text-muted d-block"><?= __("current_logo") ?></small>
                                                        </div>
                                                    <?php endif; ?>
                                            </div>

                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="site_description" class="form-label">
                                                        <i class="fas fa-align-left me-1"></i><?= __("site_description") ?>
                                                    </label>
                                                    <textarea class="form-control" id="site_description" name="site_description" 
                                                              rows="3" placeholder="<?= __("enter_site_description") ?>"><?= htmlspecialchars(setting('site_description')) ?></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="site_keywords" class="form-label">
                                                        <i class="fas fa-tags me-1"></i><?= __("site_keywords") ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="site_keywords" name="site_keywords" 
                                                           value="<?= htmlspecialchars(setting('site_keywords')) ?>"
                                                           placeholder="<?= __("keywords_placeholder") ?>">
                                                    <small class="form-text text-muted"><?= __("keywords_help") ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Contact Information Tab -->
                                    <div class="tab-pane fade" id="contact" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="site_email" class="form-label">
                                                        <i class="fas fa-envelope me-1"></i><?= __("email") ?>
                                                    </label>
                                                    <input type="email" class="form-control" id="site_email" name="site_email" 
                                                           value="<?= htmlspecialchars(setting('site_email')) ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="site_phone" class="form-label">
                                                        <i class="fas fa-phone me-1"></i><?= __("phone") ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="site_phone" name="site_phone" 
                                                           value="<?= htmlspecialchars(setting('site_phone')) ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="site_address" class="form-label">
                                                        <i class="fas fa-map-marker-alt me-1"></i><?= __("address") ?>
                                                    </label>
                                                    <textarea class="form-control" id="site_address" name="site_address" 
                                                              rows="3"><?= htmlspecialchars(setting('site_address')) ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Social Media Tab -->
                                    <div class="tab-pane fade" id="social" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="facebook_url" class="form-label">
                                                        <i class="fab fa-facebook me-1"></i><?= __("facebook_url") ?>
                                                    </label>
                                                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                                                           value="<?= htmlspecialchars(setting('facebook_url')) ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="twitter_url" class="form-label">
                                                        <i class="fab fa-twitter me-1"></i><?= __("twitter_url") ?>
                                                    </label>
                                                    <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                                                           value="<?= htmlspecialchars(setting('twitter_url')) ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="linkedin_url" class="form-label">
                                                        <i class="fab fa-linkedin me-1"></i><?= __("linkedin_url") ?>
                                                    </label>
                                                    <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" 
                                                           value="<?= htmlspecialchars(setting('linkedin_url')) ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="github_url" class="form-label">
                                                        <i class="fab fa-github me-1"></i><?= __("github_url") ?>
                                                    </label>
                                                    <input type="url" class="form-control" id="github_url" name="github_url" 
                                                           value="<?= htmlspecialchars(setting('github_url')) ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="instagram_url" class="form-label">
                                                        <i class="fab fa-instagram me-1"></i><?= __("instagram_url") ?>
                                                    </label>
                                                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" 
                                                           value="<?= htmlspecialchars(setting('instagram_url')) ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="youtube_url" class="form-label">
                                                        <i class="fab fa-youtube me-1"></i><?= __("youtube_url") ?>
                                                    </label>
                                                    <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                                                           value="<?= htmlspecialchars(setting('youtube_url')) ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- System Settings Tab -->
                                    <div class="tab-pane fade" id="system" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="site_timezone" class="form-label">
                                                        <i class="fas fa-clock me-1"></i><?= __("timezone") ?>
                                                    </label>
                                                    <?php
                                                    $timezone = setting('site_timezone');
                                                    ?>
                                                    <select class="form-control" id="site_timezone" name="site_timezone">
                                                        <option value="UTC" <?= ($timezone ?? 'UTC') === 'UTC' ? 'selected' : '' ?>>UTC</option>
                                                        <option value="Asia/Riyadh" <?= ($timezone ?? '') === 'Asia/Riyadh' ? 'selected' : '' ?>>Asia/Riyadh</option>
                                                        <option value="Asia/Dubai" <?= ($timezone ?? '') === 'Asia/Dubai' ? 'selected' : '' ?>>Asia/Dubai</option>
                                                        <option value="Europe/London" <?= ($timezone ?? '') === 'Europe/London' ? 'selected' : '' ?>>Europe/London</option>
                                                        <option value="America/New_York" <?= ($timezone ?? '') === 'America/New_York' ? 'selected' : '' ?>>America/New_York</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="items_per_page" class="form-label">
                                                        <i class="fas fa-list me-1"></i><?= __("items_per_page") ?>
                                                    </label>
                                                    <?php
                                                    $items_per_page = setting('items_per_page');
                                                    ?>
                                                    <select class="form-control" id="items_per_page" name="items_per_page">
                                                        <option value="5" <?= ($items_per_page ?? '10') === '5' ? 'selected' : '' ?>>5</option>
                                                        <option value="10" <?= ($items_per_page ?? '10') === '10' ? 'selected' : '' ?>>10</option>
                                                        <option value="25" <?= ($items_per_page ?? '10') === '25' ? 'selected' : '' ?>>25</option>
                                                        <option value="50" <?= ($items_per_page ?? '10') === '50' ? 'selected' : '' ?>>50</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 px-2">
                                                <div class="mb-3 px-4">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="maintenance_mode" 
                                                               name="maintenance_mode" value="1"
                                                               <?= (setting('maintenance_mode') ?? '0') === '1' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="maintenance_mode">
                                                            <i class="fas fa-tools me-1"></i><?= __("maintenance_mode") ?>
                                                        </label>
                                                    </div>
                                                    <small class="form-text text-muted"><?= __("maintenance_mode_help") ?></small>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 px-2">
                                                <div class="mb-3 px-4">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="allow_registration" 
                                                               name="allow_registration" value="1" 
                                                               <?= (setting('allow_registration') ?? '1') === '1' ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="allow_registration">
                                                            <i class="fas fa-user-plus me-1"></i><?= __("allow_registration") ?>
                                                        </label>
                                                    </div>
                                                    <small class="form-text text-muted"><?= __("allow_registration_help") ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                              <div>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#resetModal">
                                                    <i class="fas fa-refresh me-2"></i><?= __("reset_to_default") ?>
                                                </button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-secondary" onclick="location.reload()">
                                                    <i class="fas fa-undo me-2"></i><?= __("reset_form") ?>
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-2"></i><?= __("save_settings") ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Reset Confirmation Modal -->
<div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i><?= __("confirm_reset") ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><?= __("reset_settings_warning") ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <?= __("cancel") ?>
                </button>
                <form action="<?= route('resetSetting') ?>" method="POST" style="display: inline;">
                     <?= setCsrf() ?>
                    <?= setMethod('PUT') ?>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-refresh me-2"></i><?= __("reset_to_default") ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// function confirmReset() {
//     const modal = new bootstrap.Modal(document.getElementById('resetModal'));
//     modal.show();
// }

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>
