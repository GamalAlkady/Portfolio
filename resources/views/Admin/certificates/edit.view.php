<?php setTitle(__("edit_certificate") ?? "تعديل شهادة") ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-edit mr-2"></i><?= __("edit_certificate") ?? "تعديل الشهادة" ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>"><?= __("dashboard") ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= route('certificates') ?>"><?= __("certificates") ?? "الشهادات" ?></a></li>
                        <li class="breadcrumb-item active"><?= __("edit") ?? "تعديل" ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __("edit_certificate_information") ?? "تعديل معلومات الشهادة" ?></h3>
                            <div class="card-tools">
                                <a href="<?= route('certificate.details',['id' => $certificate['id']]) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye mr-1"></i><?= __("view_certificate") ?? "عرض الشهادة" ?>
                                </a>
                            </div>
                        </div>

                        <form action="<?= route('certificate.update', ['id' => $certificate['id']]) ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            
                            <div class="card-body">
                                <!-- Title Section -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title_ar"><?= __("title_arabic") ?? "العنوان بالعربية" ?> <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title_ar" name="title_ar" 
                                                   value="<?= htmlspecialchars($certificate['title_ar'] ?? '') ?>"
                                                   placeholder="<?= __("enter_title_arabic") ?? "أدخل العنوان بالعربية" ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title_en"><?= __("title_english") ?? "العنوان بالإنجليزية" ?> <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title_en" name="title_en" 
                                                   value="<?= htmlspecialchars($certificate['title_data']['en'] ?? '') ?>"
                                                   placeholder="<?= __("enter_title_english") ?? "Enter title in English" ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Section -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description_ar"><?= __("description_arabic") ?? "الوصف بالعربية" ?></label>
                                            <textarea class="form-control" id="description_ar" name="description_ar" rows="4"
                                                      placeholder="<?= __("enter_description_arabic") ?? "أدخل الوصف بالعربية" ?>"><?= htmlspecialchars($certificate['description_data']['ar'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description_en"><?= __("description_english") ?? "الوصف بالإنجليزية" ?></label>
                                            <textarea class="form-control" id="description_en" name="description_en" rows="4"
                                                      placeholder="<?= __("enter_description_english") ?? "Enter description in English" ?>"><?= htmlspecialchars($certificate['description_data']['en'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="issuer"><?= __("issuer") ?? "الجهة المانحة" ?> <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="issuer" name="issuer" 
                                                   value="<?= htmlspecialchars($certificate['issuer']) ?>"
                                                   placeholder="<?= __("enter_issuer") ?? "أدخل الجهة المانحة" ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="certificate_type"><?= __("certificate_type") ?? "نوع الشهادة" ?> <span class="text-danger">*</span></label>
                                            <select class="form-control" id="certificate_type" name="certificate_type" required>
                                                <option value=""><?= __("select_type") ?? "اختر النوع" ?></option>
                                                <?php foreach ($certificateTypes as $key => $value): ?>
                                                    <option value="<?= $key ?>" <?= $certificate['certificate_type'] === $key ? 'selected' : '' ?>>
                                                        <?= $value ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="issued_date"><?= __("issued_date") ?? "تاريخ المنح" ?> <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="issued_date" name="issued_date" 
                                                   value="<?= $certificate['issued_date'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="expiry_date"><?= __("expiry_date") ?? "تاريخ الانتهاء" ?> <small class="text-muted">(<?= __("optional") ?? "اختياري" ?>)</small></label>
                                            <input type="date" class="form-control" id="expiry_date" name="expiry_date"
                                                   value="<?= $certificate['expiry_date'] ?>">
                                            <small class="form-text text-muted"><?= __("leave_empty_if_no_expiry") ?? "اتركه فارغاً إذا لم تنته صلاحية الشهادة" ?></small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="verification_url"><?= __("verification_url") ?? "رابط التحقق" ?></label>
                                            <input type="url" class="form-control" id="verification_url" name="verification_url" 
                                                   value="<?= htmlspecialchars($certificate['verification_url']) ?>"
                                                   placeholder="https://example.com/verify">
                                            <small class="form-text text-muted"><?= __("verification_url_help") ?? "رابط للتحقق من صحة الشهادة" ?></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="skills_related"><?= __("skills_related") ?? "المهارات المرتبطة" ?></label>
                                            <input type="text" class="form-control" id="skills_related" name="skills_related" 
                                                   value="<?= htmlspecialchars($certificate['skills_related']) ?>"
                                                   placeholder="PHP, JavaScript, Laravel">
                                            <small class="form-text text-muted"><?= __("skills_help") ?? "فصل بينها بفواصل" ?></small>
                                        </div>
                                    </div>
                                </div>

                                <!-- File Upload and Current File -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="certificate_file"><?= __("certificate_file") ?? "ملف الشهادة" ?></label>
                                            
                                            <?php if ($certificate['certificate_file']): ?>
                                                <div class="alert alert-info mb-2">
                                                    <i class="fas fa-file-alt mr-2"></i>
                                                    <strong><?= __("current_file") ?? "الملف الحالي" ?>:</strong>
                                                    <a href="<?= assets('files/' . $certificate['certificate_file']) ?>" target="_blank" class="ml-2">
                                                        <?= basename($certificate['certificate_file']) ?>
                                                        <i class="fas fa-external-link-alt ml-1"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="certificate_file" 
                                                       name="certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                                                <label class="custom-file-label" for="certificate_file">
                                                    <?= __("choose_new_file") ?? "اختر ملف جديد" ?>
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                <?= __("file_types_allowed") ?? "أنواع الملفات المسموحة" ?>: PDF, JPG, JPEG, PNG (<?= __("max_size") ?? "الحد الأقصى" ?>: 5MB)
                                                <br><?= __("leave_empty_to_keep_current") ?? "اتركه فارغاً للاحتفاظ بالملف الحالي" ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="display_order"><?= __("display_order") ?? "ترتيب العرض" ?></label>
                                            <input type="number" class="form-control" id="display_order" name="display_order" 
                                                   value="<?= $certificate['display_order'] ?>" min="0">
                                            <small class="form-text text-muted"><?= __("display_order_help") ?? "0 = ترتيب تلقائي، أرقام أعلى تظهر أولاً" ?></small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status"><?= __("status") ?? "الحالة" ?></label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="active" <?= $certificate['status'] === 'active' ? 'selected' : '' ?>>
                                                    <?= __("active") ?? "نشط" ?>
                                                </option>
                                                <option value="inactive" <?= $certificate['status'] === 'inactive' ? 'selected' : '' ?>>
                                                    <?= __("inactive") ?? "غير نشط" ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="is_featured" 
                                                       name="is_featured" value="1" <?= $certificate['is_featured'] ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="is_featured">
                                                    <i class="fas fa-star text-warning mr-1"></i><?= __("featured_certificate") ?? "شهادة مميزة" ?>
                                                </label>
                                            </div>
                                            <small class="form-text text-muted"><?= __("featured_help") ?? "الشهادات المميزة تظهر في المقدمة" ?></small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Certificate Info Box -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="card bg-light">
                                            <div class="card-header">
                                                <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i><?= __("certificate_info") ?? "معلومات الشهادة" ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <small class="text-muted"><?= __("created_at") ?? "تاريخ الإنشاء" ?>:</small>
                                                        <br><strong><?= date('Y-m-d H:i', strtotime($certificate['created_at'])) ?></strong>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small class="text-muted"><?= __("last_updated") ?? "آخر تحديث" ?>:</small>
                                                        <br><strong><?= date('Y-m-d H:i', strtotime($certificate['updated_at'])) ?></strong>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small class="text-muted"><?= __("certificate_id") ?? "معرف الشهادة" ?>:</small>
                                                        <br><strong>#<?= $certificate['id'] ?></strong>
                                                    </div>
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
                                                        <?= locale() === 'ar' ? htmlspecialchars($certificate['title_data']['ar'] ?? '') : htmlspecialchars($certificate['title_data']['en'] ?? '') ?>
                                                    </h6>
                                                    <p id="preview-issuer" class="text-muted mb-1">
                                                        <i class="fas fa-building mr-1"></i><span><?= htmlspecialchars($certificate['issuer']) ?></span>
                                                    </p>
                                                    <p id="preview-date" class="text-muted mb-1">
                                                        <i class="fas fa-calendar mr-1"></i><span><?= $certificate['issued_date'] ?></span>
                                                    </p>
                                                    <p id="preview-type" class="mb-2">
                                                        <span class="badge badge-<?= 
                                                            $certificate['certificate_type'] === 'certificate' ? 'primary' : 
                                                            ($certificate['certificate_type'] === 'award' ? 'success' : 
                                                            ($certificate['certificate_type'] === 'course' ? 'info' : 'warning')) 
                                                        ?>" id="preview-type-badge">
                                                            <?= $certificateTypes[$certificate['certificate_type']] ?? $certificate['certificate_type'] ?>
                                                        </span>
                                                        <?php if ($certificate['is_featured']): ?>
                                                            <span class="badge badge-warning ml-1">
                                                                <i class="fas fa-star"></i> <?= __("featured") ?? "مميز" ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </p>
                                                    <p id="preview-description" class="text-muted">
                                                        <?= locale() === 'ar' ? htmlspecialchars($certificate['description_data']['ar'] ?? '') : htmlspecialchars($certificate['description_data']['en'] ?? '') ?>
                                                    </p>
                                                    <?php if ($certificate['skills_related']): ?>
                                                        <p class="mb-1">
                                                            <i class="fas fa-tags mr-1"></i>
                                                            <small class="text-muted"><?= __("skills") ?? "المهارات" ?>:</small>
                                                            <?= htmlspecialchars($certificate['skills_related']) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="<?= route('certificates') ?>" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-1"></i><?= __("back_to_list") ?? "العودة للقائمة" ?>
                                        </a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save mr-1"></i><?= __("update_certificate") ?? "تحديث الشهادة" ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    const titleAr = document.getElementById('title_ar');
    const titleEn = document.getElementById('title_en');
    const previewTitle = document.getElementById('preview-title');
    
    function updateTitlePreview() {
        const title = currentLang === 'ar' ? titleAr.value : titleEn.value;
        previewTitle.textContent = title;
    }
    
    titleAr.addEventListener('input', updateTitlePreview);
    titleEn.addEventListener('input', updateTitlePreview);
    
    // Issuer Preview
    const issuer = document.getElementById('issuer');
    const previewIssuer = document.getElementById('preview-issuer').querySelector('span');
    
    issuer.addEventListener('input', function() {
        previewIssuer.textContent = this.value;
    });
    
    // Date Preview
    const issuedDate = document.getElementById('issued_date');
    const previewDate = document.getElementById('preview-date').querySelector('span');
    
    issuedDate.addEventListener('input', function() {
        previewDate.textContent = this.value;
    });
    
    // Type Preview
    const certificateType = document.getElementById('certificate_type');
    const previewTypeBadge = document.getElementById('preview-type-badge');
    
    certificateType.addEventListener('change', function() {
        const typeText = this.options[this.selectedIndex].text;
        previewTypeBadge.textContent = typeText;
        
        // Change badge color based on type
        previewTypeBadge.className = 'badge badge-' + 
            (this.value === 'certificate' ? 'primary' : 
             this.value === 'award' ? 'success' : 
             this.value === 'course' ? 'info' : 'warning');
    });
    
    // Description Preview
    const descriptionAr = document.getElementById('description_ar');
    const descriptionEn = document.getElementById('description_en');
    const previewDescription = document.getElementById('preview-description');
    
    function updateDescriptionPreview() {
        const description = currentLang === 'ar' ? descriptionAr.value : descriptionEn.value;
        previewDescription.textContent = description;
    }
    
    descriptionAr.addEventListener('input', updateDescriptionPreview);
    descriptionEn.addEventListener('input', updateDescriptionPreview);
    
    // File input label update
    const fileInput = document.getElementById('certificate_file');
    const fileLabel = document.querySelector('.custom-file-label');
    const originalLabel = fileLabel.textContent;
    
    fileInput.addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : originalLabel;
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