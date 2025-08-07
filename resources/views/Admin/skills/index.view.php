<?php setTitle("Skills");?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                <h1 class="h2">Skills</h1>
                <a href="<?=route('addSkill')?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Add Skill
                </a>
            </div>
        </div>

    </div>
    <section class="content">
        <div class="container-fluid">

    <?php if (hasError()) : ?>
        <script>toastr.error(" <?php echo htmlspecialchars(error()); ?>")</script>           
    <?php endif; ?>

            <div class="card">
                <!-- Skills Table -->
                <div class="table-responsiv table-custom p-3">
                    <table class="table table-hover align-middle" id="skills-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $('#skills-table').DataTable({
        paging:true,
        processing: true,
        serverSide: true,
        ajax: '/admin/skills/datatable',
        columns: [
            {data: "name"},
            { data: 'description' },
            { data: 'category' },
            {
                data: 'id',
                render: function (data) {
                    return `
                    <a href="/admin/skills/${data}/edit" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                    <form id="delete-form-${data}" method="POST" action="/admin/skills/${data}/delete" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <?= setCsrf() ?>
                        <button type="button" onclick="confirmDelete('<?=getCsrf()?>','/admin/skills/${data}/delete')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                `;
                }
            }
        ]
        // language: {
        //     url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
        // }
    });

</script>

