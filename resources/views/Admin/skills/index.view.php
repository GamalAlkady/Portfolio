<?php setTitle(__("skills")); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                <h1 class="h2"><?= __("skills") ?></h1>
                <a href="<?= route('addSkill') ?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i><?= __("add_skill") ?>
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

            <div class="card">
                <!-- Skills Table -->
                <div class="table-responsiv table-custom p-3">
                    <table class="table table-hover align-middle" id="skills-table">
                        <thead>
                            <tr>
                                <th><?= __('name') ?></th>
                                <th><?= __('description') ?></th>
                                <th><?= __('category') ?></th>
                                <th><?= __('actions') ?></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!--</main>-->
<script src="<?= assets('js/datatables-translations.js') ?>"></script>
<script>
    // دالة ترجمة التصنيفات
    function translateCategory(category) {
        const categoryTranslations = {
            'technical_skills': "<?= __('technical_skills') ?>",
            'design_skills': "<?= __('design_skills') ?>",
            'personal_skills': "<?= __('personal_skills') ?>",
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
        updateItemsCount('skillsTable', $('#skillsTable').DataTable());
    }

    // استخدام الدالة المساعدة لإنشاء DataTable مع الترجمة المناسبة
    initDataTableWithLanguage('#skills-table', {
        order: [
            [0, 'desc']
        ],
        paging: true,
        processing: true,
        serverSide: true,
        ajax: '/admin/skills/datatable',
        columns: [{
                data: "name"
            },
            {
                data: 'description',
                render: function(data) {
                    if (data == null) return '';
                    return data.length > 50 ? data.substring(0, 50) + '...' : data;
                }
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
                    <div class='d-flex justify-content-between'>
                    <a href="/admin/skills/${data}/edit" class="btn btn-info btn-sm" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button"
                            onclick="confirmDelete('<?= getCsrf() ?>', '/admin/skills/${data}/delete', this, {
                                tableId: 'skillsTable',
                                itemName: '<?= __('skill') ?>',
                                updateCounter: true,
                                reloadPage: false
                            })"
                            class="btn btn-danger btn-sm"
                            title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                    </div>
                `;
                }
            }
        ]
    }, '<?= locale() ?>');
</script>