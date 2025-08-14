<?php setTitle(__("projects")); ?>
<!--<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">-->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                <h1 class="h2"><?= __("projects") ?></h1>
                <a href="<?=route('addProject')?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i><?= __("add_project") ?>
                </a>
            </div>
        </div>

    </div>
    <section class="content">
        <div class="container-fluid">


            <?php if (hasError()) : ?>
                <script>toastr.error(" <?php echo htmlspecialchars(error()); ?>")</script>
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
    // استخدام الدالة المساعدة لإنشاء DataTable مع الترجمة المناسبة
    initDataTableWithLanguage('#projects-table', {
        paging: true,
        processing: true,
        serverSide: true,
        ajax: '/admin/projects/datatable',
        columns: [
            {
                data: "title",
                render: function (data, type, row) {
                    return `<a class="text-decoration-none" href="/admin/project/details/${row.id}">${data}</a>`;
                }
            },
            {
                data: 'description',
                render: function (data) {
                    return data.length > 50 ? data.substring(0, 50) + '...' : data;
                }
            },
            {data: 'technologies'},
            {data: 'category'},
            {
                data: 'id',
                render: function (data) {
                    return `
                    <a href="/admin/projects/${data}/edit" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                    <form id="delete-form-${data}" method="POST" action="/admin/projects/${data}/delete" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <?= setCsrf() ?>
                        <button type="button" onclick="confirmDelete('<?=getCsrf()?>','/admin/projects/${data}/delete')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                `;
                }
            }
        ]
    }, '<?= locale() ?>');
</script>

