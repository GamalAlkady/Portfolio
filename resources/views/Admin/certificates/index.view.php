<?php setTitle(__("certificates")) ?>

<!-- إضافة الترجمات للـ JavaScript -->
<?= renderTranslations(locale(), [
    'set_featured',
    'cancel_featured',
]) ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-certificate mr-2"></i><?= __("certificates_management") ?? "إدارة الشهادات" ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>"><?= __("dashboard") ?></a></li>
                        <li class="breadcrumb-item active"><?= __("certificates") ?? "الشهادات" ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $stats['total'] ?? 0 ?></h3>
                            <p><?= __("total_certificates") ?? "إجمالي الشهادات" ?></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $stats['featured'] ?? 0 ?></h3>
                            <p><?= __("featured_certificates") ?? "الشهادات المميزة" ?></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $stats['recent_year'] ?? 0 ?></h3>
                            <p><?= __("recent_certificates") ?? "شهادات هذا العام" ?></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= count($stats['by_type'] ?? []) ?></h3>
                            <p><?= __("certificate_types") ?? "أنواع الشهادات" ?></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certificates Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __("certificates_list") ?? "قائمة الشهادات" ?></h3>

                            <div class="card-tools">
                                <a href="<?= route('certificate.add') ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus mr-1"></i><?= __("add_certificate") ?? "إضافة شهادة" ?>
                                </a>
                            </div>
                        </div>


                        <div class="card-body">
                            <!-- <?php if (!empty($certificates)): ?> -->
                            <table class="table table-striped" id="certificatesTable">
                                <thead>
                                    <tr>
                                        <th><?= __("title") ?? "العنوان" ?></th>
                                        <th><?= __("issuer") ?? "الجهة المانحة" ?></th>
                                        <th><?= __("type") ?? "النوع" ?></th>
                                        <th><?= __("issued_date") ?? "تاريخ المنح" ?></th>
                                        <th><?= __("status") ?? "الحالة" ?></th>
                                        <th><?= __("actions") ?? "الإجراءات" ?></th>
                                    </tr>
                                </thead>

                            </table>
                            <!-- <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-certificate fa-3x text-muted mb-3"></i>
                                    <h4 class="text-muted"><?= __("no_certificates_found") ?? "لا توجد شهادات" ?></h4>
                                    <p class="text-muted"><?= __("add_first_certificate") ?? "قم بإضافة أول شهادة لك" ?></p>
                                    <a href="<?= route('certificate.add') ?>" class="btn btn-primary">
                                        <i class="fas fa-plus mr-1"></i><?= __("add_certificate") ?? "إضافة شهادة" ?>
                                    </a>
                                </div>
                            <?php endif; ?> -->
                        </div>
                    </div>

                </div>
            </div>

            <!-- Types Statistics -->
            <?php if (!empty($stats['by_type'])): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?= __("certificates_by_type") ?? "الشهادات حسب النوع" ?></h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($stats['by_type'] as $typeStat): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge badge-<?=
                                                                                $typeStat['certificate_type'] === 'certificate' ? 'primary' : ($typeStat['certificate_type'] === 'award' ? 'success' : ($typeStat['certificate_type'] === 'course' ? 'info' : 'warning'))
                                                                                ?>">
                                                        <?= $certificateTypes[$typeStat['certificate_type']] ?? $typeStat['certificate_type'] ?>
                                                    </span>
                                                </td>
                                                <td><?= $typeStat['count'] ?></td>
                                                <td>
                                                    <a href="<?= route('certificates.search') ?>?type=<?= $typeStat['certificate_type'] ?>"
                                                        class="btn btn-outline-primary btn-sm">
                                                        <?= __("view_all") ?? "عرض الكل" ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>
</div>

<style>
    .certificate-type-certificate {
        background-color: #007bff;
    }

    .certificate-type-award {
        background-color: #28a745;
    }

    .certificate-type-course {
        background-color: #17a2b8;
    }

    .certificate-type-achievement {
        background-color: #ffc107;
    }
</style>

<script src="<?= assets('js/datatables-translations.js') ?>"></script>
<script>
    // دالة ترجمة التصنيفات
    function translateCategory(category) {
        const categoryTranslations = {
            'certificate': "<?= __('certificate') ?>",
            'award': "<?= __('award') ?>",
            'course': "<?= __('course') ?>",
            'achievement': "<?= __('achievement') ?>",
            'other': "<?= __('other') ?>",
        };

        return categoryTranslations[category] || category;
    }

    // تم دمج دالة deleteProject مع confirmDelete في utils.js
    // الآن نستخدم confirmDelete مع خيارات متقدمة

    // دالة تحديث عداد المشاريع (تم تبسيطها - الوظائف الأساسية موجودة في utils.js)
    function updateProjectsCount() {
        // هذه الدالة محفوظة للتوافق مع الكود القديم
        // الوظائف الأساسية تتم الآن في utils.js تلقائياً
        updateItemsCount('projectsTable', $('#projectsTable').DataTable());
    }

    // استخدام الدالة المساعدة لإنشاء DataTable مع الترجمة المناسبة
    initDataTableWithLanguage('#certificatesTable', {
        order: [
            [0, 'desc']
        ],
        paging: true,
        processing: true,
        serverSide: true,
        ajax: '<?= route("certificates.datatable") ?>',
        columns: [{
                data: "title",
                render: function(data, type, row) {
                    value = tryParse(data);
                    locale = "<?= locale() ?>";
                    if (value !== null) value = value[locale];
                    else value = data;

                    return `<a class="text-decoration-none" href="/admin/certificate/details/${row.id}">${value}</a>`;
                }
            },
            {
                data: 'issuer'
            },
            {
                data: 'certificate_type',
                render: function(data) {
                    return `<span class="badge badge-${data === 'certificate' ? 'primary' : (data === 'award' ? 'success' : (data === 'course' ? 'info' : 'warning'))}">${translateCategory(data)}</span>`;
                }
            },
            {
                data: 'issued_date',
                render: function(data) {
                    // Format date as YYYY-MM-DD in JS
                    if (!data) return '';
                    const dateObj = new Date(data);
                    const year = dateObj.getFullYear();
                    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                    const day = String(dateObj.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                }
            },
            {
                data: 'status',
                render: function(data) {
                    return `<span class="badge badge-${data === 'active' ? 'success' : 'danger'}">${__(data)}</span>`;
                }
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                     <div class="btn-group-certificate btn-group d-flex justify-content-between" role="group">
                
                    <a href="/admin/certificates/${data}/edit"
                        class="btn btn-outline-info btn-sm" title="<?= __("edit") ?? "تعديل" ?>">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="/admin/certificates/${data}/toggle-featured"
                        method="POST" class="d-inline"
                        title="${row.is_featured ? __("cancel_featured"): __("set_featured")}">
                        <button type="submit" class="w-100 btn btn-${row.is_featured ? 'warning' : 'outline-warning'} btn-sm">
                            <i class="fas fa-star"></i>
                        </button>
                    </form>

                    <form action="/admin/certificates/${data}/toggle-status"
                        method="POST" class="d-inline"
                        title="${row.status === 'active' ? __("deactivate") : __("activate")}">
                        <button type="submit" class="btn btn-${row.status === 'active' ? 'outline-success' : 'outline-danger'} btn-sm">
                            <i class="fas fa-${row.status === 'active' ? 'check' : 'times'}"></i>
                        </button>
                    </form>

                
                        <button type="button" onClick="confirmDelete('<?= getCsrf() ?>', '/admin/certificates/${data}/delete', this, {
                                tableId: 'certificatesTable',
                                itemName: '<?= __('certificate') ?>',
                                updateCounter: true,
                                reloadPage: false
                            })" class="btn btn-outline-danger btn-sm"
                            title="${__("delete")}">
                            <i class="fas fa-trash"></i>
                        </button>
                
                </div>
                    `;

                }
            }
        ]
    }, '<?= locale() ?>');
</script>