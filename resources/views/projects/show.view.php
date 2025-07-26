<?php setTitle($project['title'] ?? 'Project Details'); ?>
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <?php if (!empty($project['image'])): ?>
                    <img src="<?= assets($project['image']) ?>" class="card-img-top rounded" alt="<?= htmlspecialchars($project['title']) ?>">
                <?php else: ?>
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height:300px;">
                        <span class="text-muted">No Main Image</span>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($project['other_images'])): ?>
                <div class="mt-4">
                    <h5 class="mb-3">Gallery</h5>
                    <div class="row g-2">
                        <?php foreach (json_decode($project['other_images'], true) as $img): ?>
                            <div class="col-4 col-md-3">
                                <a href="<?= assets($img) ?>" target="_blank">
                                    <img src="<?= assets($img) ?>" class="img-fluid rounded border gallery-thumb" alt="Gallery image" style="object-fit:cover; height:80px; width:100%;">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4 h-100">
                <h2 class="mb-3 text-primary fw-bold"><?= htmlspecialchars($project['title']) ?></h2>
                <div class="mb-2">
                    <span class="badge bg-info text-dark">ID: <?= htmlspecialchars($project['id']) ?></span>
                    <span class="badge bg-secondary ms-2">Category: <?= htmlspecialchars($project['category']) ?></span>
                </div>
                <div class="mb-3">
                    <span class="badge bg-light text-dark">Technologies: <?= htmlspecialchars($project['technologies']) ?></span>
                </div>
                <div class="mb-3">
                    <strong>Description:</strong>
                    <p class="mt-1 text-muted" style="white-space:pre-line;"> <?= nl2br(htmlspecialchars($project['description'])) ?> </p>
                </div>
                <div class="mb-3">
                    <strong>Created At:</strong>
                    <span class="text-muted ms-2"> <?= htmlspecialchars($project['created_at']) ?> </span>
                </div>
                <?php if (!empty($project['host_url'])): ?>
                    <div class="mb-2">
                        <strong>Live URL:</strong>
                        <a href="<?= htmlspecialchars($project['host_url']) ?>" target="_blank" class="ms-2 text-decoration-underline text-success">
                            <?= htmlspecialchars($project['host_url']) ?>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($project['github_url'])): ?>
                    <div class="mb-2">
                        <strong>GitHub:</strong>
                        <a href="<?= htmlspecialchars($project['github_url']) ?>" target="_blank" class="ms-2 text-decoration-underline text-dark">
                            <?= htmlspecialchars($project['github_url']) ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<style>
.gallery-thumb:hover {
    box-shadow: 0 0 0 2px #0d6efd;
    transition: box-shadow 0.2s;
}
</style> 