<?php setTitle("Projects");?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
        <h1 class="h2">Projects</h1>
        <a href="/admin/add-project" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Project
        </a>
    </div>





    <?php if (hasError()) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars(error()); ?>
        </div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card p-3">
                <h5>Total Projects</h5>
                <h3><?php echo count($projects); ?></h3>
            </div>
        </div>
    </div>

    <!-- Projects Table -->
    <div class="table-responsive table-custom p-3">
        <table class="table table-hover align-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Technologies</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?php echo htmlspecialchars($project['id']); ?></td>
                    <td class="fw-bold"><a href="/admin/project/details/<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['title']); ?></a></td>
                    <td><?php echo substr(htmlspecialchars($project['description']), 0, 50) . '...'; ?></td>
                    <td>
                        <span class="badge bg-light text-dark"><?php echo htmlspecialchars($project['technologies']); ?></span>
                    </td>
                    <td><span class="badge bg-info"><?php echo htmlspecialchars($project['category']); ?></span></td>
                    <td class="action-buttons">
                        <a href="/admin/edit-project/<?php echo $project['id']; ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/admin/delete-project/<?php echo $project['id']; ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا المشروع؟')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
