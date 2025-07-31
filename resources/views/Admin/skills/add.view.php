<?php setTitle("Add Skill"); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Add Skill</h1>
</div>

<div class="form-container">
    <form action="/admin/skills/store" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <?= setCsrf() ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label required-field">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="<?php echo old('name') ?>"
                       required>
                <div class="form-error text-danger text-sm mt-1"><?= errors('name') ?></div>
            </div>

            <div class="col-md-6">
                <label for="category" class="form-label required-field">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Choose...</option>
                    <?php
                    $categories = ['Technical skills', 'Design skills', 'Personal skills', 'Other'];
                    foreach ($categories as $cat) {
                        $selected = (old('category') === $cat) ? 'selected' : '';
                        echo "<option value='$cat' $selected>$cat</option>";
                    }
                    ?>
                </select>
                <div class="form-error text-danger text-sm mt-1"><?= errors('category') ?></div>
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"
                          rows="4"><?php echo old('description') ?></textarea>
                <div class="form-error text-danger text-sm mt-1"><?= errors('description') ?></div>
            </div>

            <div class="col-12 mt-4 d-flex justify-content-between">
                <a href="/admin/skills" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Skills
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save
                </button>
            </div>
        </div>
    </form>
</div>


<script>
    // Form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
