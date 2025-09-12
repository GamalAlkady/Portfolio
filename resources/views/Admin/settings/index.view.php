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
                                    <button class="nav-link active" id="general-tab" data-toggle="tab"
                                        data-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                                        <i class="fas fa-cog me-2"></i><?= __("general_settings") ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-toggle="tab"
                                        data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="true">
                                        <i class="fas fa-address-book me-2"></i><?= __("contact_info") ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="social-tab" data-toggle="tab"
                                        data-target="#social" type="button" role="tab" aria-controls="social" aria-selected="true">
                                        <i class="fas fa-share-alt me-2"></i><?= __("social_media") ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="email-tab" data-toggle="tab"
                                        data-target="#email" type="button" role="tab" aria-controls="email" aria-selected="true">
                                        <i class="fas fa-envelope-open me-2"></i><?= __("email_settings") ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="system-tab" data-toggle="tab"
                                        data-target="#system" type="button" role="tab" aria-controls="system" aria-selected="true">
                                        <i class="fas fa-server me-2"></i><?= __("system_settings") ?>
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <form action="<?= route('updateSetting') ?>" id="settings-form" class="settings-form" method="POST" enctype="multipart/form-data">
                                <?= setCsrf() ?>
                                <?= setMethod('PUT') ?>

                                <div class="tab-content" id="settings-tabs-content">

                                    <!-- General Settings Tab -->
                                    <?php
                                    renderLangTabs('general', function ($lang) {
                                        $form = new FormHelper();
                                        echo $form->input('site_name_' . $lang, '  <i class="fas fa-globe mx-1"></i>' . __("site_name", [], $lang) . ' (' . __($lang, [], $lang) . ')', old('site_name_' . $lang, setting('site_name_' . $lang)))
                                            ->labelClass('col-sm-12 col-form-label')->controlsClass('col-sm-12')
                                            ->formGroupClass('col-md-6')
                                            ->attrs(['placeholder' => __('enter_site_name_' . $lang)])
                                            ->render();
                                    ?>


                                    <?php

                                        echo $form->textarea('site_description_' . $lang, '  <i class="fas fa-align-left mx-1"></i>' . __("site_description", [], $lang) . ' (' . __($lang, [], $lang) . ')', old('site_description_' . $lang, setting('site_description_' . $lang)))
                                            ->placeHolder(__('enter_site_description_' . $lang))
                                            ->render();

                                        echo $form->input('site_keywords_' . $lang, '  <i class="fas fa-tags me-1"></i>' . __("site_keywords", [], $lang) . ' (' . __($lang, [], $lang) . ')', old('site_keywords_' . $lang, setting('site_keywords_' . $lang)))
                                            ->placeHolder(__('keywords_placeholder_' . $lang))
                                            ->render();
                                    }, function () { ?>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="logo_light" class="form-label">
                                                    <i class="fas fa-image me-1"></i><?= __("logo_light") ?>
                                                </label>
                                                <div>
                                                    <div class="">
                                                        <img id="logoLight" class="profile-user-img img-fluid img-circle cursor-pointer"
                                                            src="<?= assets(setting('logo_light'), 'images/user.png') ?>"
                                                            alt="Click to change image"
                                                            onclick="openFileInput('fileLogoLight')">

                                                        <input type="file" id="fileLogoLight" name="logo_light" accept="image/*" style="display: none;"
                                                         onchange="previewImage(this, 'logoLight');">
                                                        <input type="hidden" id="oldLogoLight" name="logo_light" value="<?= setting('logo_light') ?>" accept="image/*" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="logo_dark" class="form-label">
                                                    <i class="fas fa-image me-1"></i><?= __("logo_dark") ?>
                                                </label>
                                                <div>
                                                    <div class="">
                                                        <img id="logoDark" class="profile-user-img img-fluid img-circle cursor-pointer"
                                                            src="<?= assets(setting('logo_dark'), 'images/user.png') ?>"
                                                            alt="Click to change image"
                                                            onclick="openFileInput('fileLogoDark')">

                                                        <input type="file" id="fileLogoDark" name="logo_dark" accept="image/*" style="display: none;"
                                                         onchange="previewImage(this, 'logoDark');">
                                                        <input type="hidden" id="oldLogoDark" name="logo_dark" value="<?= setting('logo_dark') ?>" accept="image/*" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php })
                                        ?>

                                        <!-- Contact Information Tab -->
                                        <div class="tab-pane fade " id="contact" role="tabpanel">
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

                                        <!-- Email Settings Tab -->
                                        <div class="tab-pane fade" id="email" role="tabpanel">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        <?= __("email_settings_note") ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="mail_host" class="form-label">
                                                            <i class="fas fa-server me-1"></i><?= __("smtp_host") ?>
                                                        </label>
                                                        <input type="text" class="form-control" id="mail_host" name="mail_host"
                                                            value="<?= htmlspecialchars(env('MAIL_HOST', '')) ?>"
                                                            placeholder="smtp.gmail.com">
                                                        <small class="form-text text-muted"><?= __("smtp_host_help") ?></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="mail_port" class="form-label">
                                                            <i class="fas fa-plug me-1"></i><?= __("smtp_port") ?>
                                                        </label>
                                                        <select class="form-control" id="mail_port" name="mail_port">
                                                            <option value="587" <?= env('MAIL_PORT', '587') === '587' ? 'selected' : '' ?>>587 (TLS)</option>
                                                            <option value="465" <?= env('MAIL_PORT', '587') === '465' ? 'selected' : '' ?>>465 (SSL)</option>
                                                            <option value="25" <?= env('MAIL_PORT', '587') === '25' ? 'selected' : '' ?>>25 (غير مشفر)</option>
                                                        </select>
                                                        <small class="form-text text-muted"><?= __("smtp_port_help") ?></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="mail_username" class="form-label">
                                                            <i class="fas fa-user me-1"></i><?= __("smtp_username") ?>
                                                        </label>
                                                        <input type="email" class="form-control" id="mail_username" name="mail_username"
                                                            value="<?= htmlspecialchars(env('MAIL_USERNAME', '')) ?>"
                                                            placeholder="your-email@gmail.com">
                                                        <small class="form-text text-muted"><?= __("smtp_username_help") ?></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="mail_password" class="form-label">
                                                            <i class="fas fa-key me-1"></i><?= __("smtp_password") ?>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="mail_password" name="mail_password"
                                                                value="<?= htmlspecialchars(env('MAIL_PASSWORD', '')) ?>"
                                                                placeholder="<?= __("enter_app_password") ?>">
                                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </div>
                                                        <small class="form-text text-muted"><?= __("smtp_password_help") ?></small>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-none">
                                                    <div class="mb-3">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">
                                                                    <i class="fas fa-paper-plane me-2"></i><?= __("test_email") ?>
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <input type="email" class="form-control" id="test_email"
                                                                            placeholder="<?= __("enter_test_email") ?>">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button type="button" class="btn btn-info w-100" id="sendTestEmail">
                                                                            <i class="fas fa-paper-plane me-2"></i><?= __("send_test_email") ?>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <small class="form-text text-muted"><?= __("test_email_help") ?></small>
                                                            </div>
                                                        </div>
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
                                                                <i class="fas fa-tools mx-1"></i><?= __("maintenance_mode") ?>
                                                            </label>
                                                        </div>
                                                        <small class="form-text text-muted"><?= __("maintenance_mode_help") ?></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 px-2 d-none">
                                                    <div class="mb-3 px-4">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="allow_registration"
                                                                name="allow_registration" value="1"
                                                                <?= (setting('allow_registration') ?? '1') === '1' ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="allow_registration">
                                                                <i class="fas fa-user-plus mx-1"></i><?= __("allow_registration") ?>
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
                                                            <!-- <button type="button" class="btn btn-secondary" onclick="location.reload()">
                                                                <i class="fas fa-undo me-2"></i><?= __("reset_form") ?>
                                                            </button> -->
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
    $(function() {
        // إعدادات Summernote للنص العربي (RTL)
        summerNote('site_description_ar', 'rtl');
        summerNote('site_description_en', 'ltr');

        $('input[type="file"]').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $('.display-file-name').html(fileName);
        });
    });

    $(document).ready(function() {

        ChangeTabs("<?= route('updateSetting') ?>");

        // تفعيل التبويبات المتداخلة للغات
        var generalLanguageTabList = [].slice.call(document.querySelectorAll('#generalLanguageTabs button'))
        generalLanguageTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)

            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        });
    });

    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('mail_password');
        const icon = this.querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Auto-hide alerts after 5 seconds when the mouse is not hovered or focused
    document.querySelectorAll('.alert').forEach(function(alert) {
        let closeTimer;

        function startCloseTimer() {
            closeTimer = setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }

        function stopCloseTimer() {
            clearTimeout(closeTimer);
        }

        // عند دخول الماوس: إيقاف المؤقت
        alert.addEventListener('mouseenter', stopCloseTimer);

        // عند خروج الماوس: إعادة تشغيل المؤقت
        alert.addEventListener('mouseleave', startCloseTimer);

        // بدء المؤقت أول مرة
        startCloseTimer();
    });
</script>