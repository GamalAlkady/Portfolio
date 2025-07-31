<?php use App\Models\Projects;

setTitle("Edit Project"); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Edit Project</h1>
    <!--        <a href="/admin/works" class="btn btn-secondary">-->
    <!--            <i class="fas fa-arrow-left me-2"></i>Back to Projects-->
    <!--        </a>-->
</div>

<?php
/** @var array $skill */
if ($skill) : ?>
    <div class="form-container">
        <form action="/admin/skills/<?=$skill['id']?>/update" method="POST" enctype="multipart/form-data">
            <?= setCsrf() ?>
            <?= setMethod("PUT") ?>
            <input type="hidden" name="id" value="<?= $skill['id'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo htmlspecialchars($skill['name'] ?? ''); ?>" required>
                    <div class="form-error text-danger text-sm mt-1"><?= errors('name') ?></div>
                </div>
                <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <?php
                        $categories = ['Technical skills', 'Design skills', 'Personal skills', 'Other'];
                        $old = old('category');
                        $category = !empty($old)?$old:$skill['category'];

                        foreach ($categories as $cat) {
                            $selected = ($category === $cat) ? 'selected' : '';
                            echo "<option value='$cat' $selected>$cat</option>";
                        }
                        ?>
                    </select>
                    <div class="form-error text-danger text-sm mt-1"><?= errors('category') ?></div>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"
                              required><?php echo htmlspecialchars($skill['description'] ?? ''); ?></textarea>
                    <div class="form-error text-danger text-sm mt-1"><?= errors('description') ?></div>
                </div>


                <div class="col-12 d-flex justify-content-around">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
<?php else : ?>
    <div class="alert alert-warning" role="alert">
        Project not found or an error occurred.
    </div>
<?php endif; ?>




