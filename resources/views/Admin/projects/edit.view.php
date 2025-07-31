<?php use App\Models\Projects;

setTitle("Edit Project"); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Edit Project</h1>
    <!--        <a href="/admin/works" class="btn btn-secondary">-->
    <!--            <i class="fas fa-arrow-left me-2"></i>Back to Projects-->
    <!--        </a>-->
</div>

<?php /** @var Projects $project */
if ($project) : ?>
    <div class="form-container">
        <form action="/admin/projects/<?=$project['id']?>/update" method="POST" enctype="multipart/form-data">
            <?= setCsrf() ?>
            <?= setMethod("PUT") ?>
            <input type="hidden" name="id" value="<?= $project['id'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Project Title</label>
                    <input type="text" class="form-control" id="title" name="title"
                           value="<?php echo htmlspecialchars($project['title'] ?? ''); ?>" required>
                    <div class="form-error text-danger text-sm mt-1"><?= errors('title') ?></div>
                </div>
                <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Web Development" <?php echo (($project['category'] ?? '') == 'Web Development') ? 'selected' : ''; ?>>
                            Web Development
                        </option>
                        <option value="Mobile Development" <?php echo (($project['category'] ?? '') == 'Mobile Development') ? 'selected' : ''; ?>>
                            Mobile Development
                        </option>
                        <option value="Desktop Application" <?php echo (($project['category'] ?? '') == 'Desktop Application') ? 'selected' : ''; ?>>
                            Desktop Application
                        </option>
                        <option value="Data Science" <?php echo (($project['category'] ?? '') == 'Data Science') ? 'selected' : ''; ?>>
                            Data Science
                        </option>
                        <option value="Other" <?php echo (($project['category'] ?? '') == 'Other') ? 'selected' : ''; ?>>
                            Other
                        </option>
                    </select>
                    <div class="form-error text-danger text-sm mt-1"><?= errors('category') ?></div>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"
                              required><?php echo htmlspecialchars($project['description'] ?? ''); ?></textarea>
                    <div class="form-error text-danger text-sm mt-1"><?= errors('description') ?></div>
                </div>

                <div class="col-md-6">
                    <label for="host_url" class="form-label">Host URL (Optional)</label>
                    <input type="url" class="form-control" id="host_url" name="host_url"
                           value="<?php echo htmlspecialchars($project['host_url'] ?? ''); ?>">
                    <div class="form-error text-danger text-sm mt-1"><?= errors('host_url') ?></div>
                </div>

                <div class="col-md-6">
                    <label for="github_url" class="form-label">GitHub URL (Optional)</label>
                    <input type="url" class="form-control" id="github_url" name="github_url"
                           value="<?php echo htmlspecialchars($project['github_url'] ?? ''); ?>">
                    <div class="form-error text-danger text-sm mt-1"><?= errors('github_url') ?></div>
                </div>

                <div class="col-12">
                    <label for="technologies" class="form-label">Technologies (Comma separated)</label>
                    <input type="text" class="form-control" id="technologies" name="technologies"
                           value="<?php echo htmlspecialchars($project['technologies'] ?? ''); ?>" required>
                    <div class="form-error text-danger text-sm mt-1"><?= errors('technologies') ?></div>
                </div>

                <div class="col-12 d-flex justify-content-around">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                    <button type="submit" class="btn btn-primary">Update Project</button>
                </div>
            </div>
        </form>
    </div>
<?php else : ?>
    <div class="alert alert-warning" role="alert">
        Project not found or an error occurred.
    </div>
<?php endif; ?>




