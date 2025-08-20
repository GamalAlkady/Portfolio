<?php setTitle(__("projects")); ?>

<!--<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">-->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                <h1 class="h2"><?= __("projects") ?></h1>
                <a href="<?= route('project.add') ?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i><?= __("add_project") ?>
                </a>
            </div>
        </div>

    </div>
    <section class="content">
        <div class="container-fluid">


            <?php if (hasError()) : ?>
                <script>
                    toastr.error(" <?php echo htmlspecialchars(error()); ?>")
                </script>
            <?php endif; ?>

            <!--            <div class="row">-->
            <!--                <div class="col-12">-->
            <div class="card">
                <!-- Projects Table -->
                <div class="table-responsive table-custom p-3">
                    <table class="table table-hover align-middle" id="projects-table">
                        <thead>
                            <tr>
                                <th><?= __("title") ?></th>
                                <th><?= __("description") ?></th>
                                <th><?= __("technologies_used") ?></th>
                                <th><?= __("category") ?></th>
                                <th><?= __("actions") ?></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
            <!--                </div>-->
            <!--            </div>-->
        </div>
    </section>
</div>

<!--</main>-->
<script src="<?= assets('js/datatables-translations.js') ?>"></script>
<script>
    // دالة ترجمة التصنيفات
    function translateCategory(category) {
        const categoryTranslations = {
            'web_development':"<?=__('web_development')?>",
            'mobile_app':"<?=__('mobile_app')?>",
            'desktop_app':"<?=__('desktop_app')?>",
            'ui_ux_design':"<?=__('ui_ux_design')?>",
            'other':"<?=__('other')?>",
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
    initDataTableWithLanguage('#projects-table', {
        order: [
            [0, 'desc']
        ],
        paging: true,
        processing: true,
        serverSide: true,
        ajax: '/admin/projects/datatable',
        columns: [{
                data: "title",
                render: function(data, type, row) {
                    value = tryParse(data);
                    locale = "<?= locale() ?>";
                    if (value !== null) value = value[locale];
                    else value = data;

                    return `<a class="text-decoration-none" href="/admin/project/details/${row.id}">${value}</a>`;
                }
            },
            {
                data: 'description',
                render: function(data) {
                    value = tryParse(data);
                    locale = "<?= locale() ?>";
                    if (value !== null) value = value[locale];
                    else value = data;

                    return value.length > 50 ? value.substring(0, 50) + '...' : value;
                }
            },
            {
                data: 'technologies'
            },
            {
                data: 'category',
                render: function(data) {
                    return translateCategory(data); // ✅ يعمل بشكل صحيح
                }
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                    <a href="/admin/projects/${data}/edit" class="btn btn-info btn-sm" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button"
                            onclick="confirmDelete('<?= getCsrf() ?>', '/admin/projects/${data}/delete', this, {
                                tableId: 'projectsTable',
                                itemName: '<?=__('project')?>',
                                updateCounter: true,
                                reloadPage: false
                            })"
                            class="btn btn-danger btn-sm"
                            title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                }
            }
        ]
    }, '<?= locale() ?>');
</script>
