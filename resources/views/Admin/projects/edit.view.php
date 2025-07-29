<?php setTitle("Edit Project"); ?>

<div class="flex justify-between flex-wrap flex-md-nowrap align-center pb-2 mb-3">
    <h2 class="text-lg font-bold text-gray-900">Edit Project</h2>
</div>

<div class="form-container">
    <div class="border-b border-gray-900/10 pb-12">
        <?php if ($project) : ?>
            <form action="/admin/update-project" method="POST" enctype="multipart/form-data" id="productForm" class="p-6"
                  novalidate>
                <?= setCsrf() ?>

                <input type="hidden" name="id" value="<?=$project['id']?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column - Form Fields -->
                    <div>
                        <!-- Product Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                Product Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="<?=$project['title']?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                   placeholder="Enter product title">
                            <div id="titleError" class="form-error text-danger text-sm mt-1 ">
                                <?= errors('title') ?>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Description <span class="text-danger">*</span>
                            </label>
                            <textarea id="description" name="description" rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                      placeholder="Enter product description"><?=$project['description']?></textarea>
                            <div id="descriptionError"
                                 class="form-error text-danger text-sm mt-1 "><?= errors('description') ?></div>
                        </div>

                        <!-- Category -->
                        <?php
                        $categories = ["Web Application", "Mobile Development", "Desktop Software", "API Service", "Other"];
                        ?>
                        <div class="mb-6">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                Category <span class="text-danger">*</span>
                            </label>
                                <select id="category" name="category"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                                <option value="">Select a category</option>
                                <?php
                                foreach ($categories as $category) {
                                    echo "<option value='$category'". (($project['category']==$category)?'selected':'').">$category</option>";
                                } ?>
                            </select>
                            <div id="categoryError" class="form-error text-danger text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Technologies -->
                        <div class="mb-6">
                            <label for="technologies" class="block text-sm font-medium text-gray-700 mb-1">
                                Technologies <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="technologies" name="technologies" value="<?=$project['technologies']?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                   placeholder="Enter technologies (comma separated)">
                            <div class="text-xs text-gray-500 mt-1">Separate technologies with commas (e.g. React,
                                Node.js, MongoDB)
                            </div>
                            <div id="technologiesError"
                                 class="form-error text-danger text-sm mt-1 "><?= errors('technologies') ?></div>
                        </div>

                        <!-- URLs -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="hostUrl" class="block text-sm font-medium text-gray-700 mb-1">Host
                                    URL</label>
                                <input type="url" id="hostUrl" name="host_url" value="<?=$project['host_url']?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                       placeholder="https://example.com">
                                <div id="hostUrlError"
                                     class="form-error text-danger text-sm mt-1 "><?= errors('host_url') ?></div>
                            </div>
                            <div>
                                <label for="githubUrl" class="block text-sm font-medium text-gray-700 mb-1">
                                    GitHub URL
                                </label>
                                <input type="url" id="githubUrl" name="github_url" value="<?=$project['github_url']?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                       placeholder="https://github.com/username/repo">
                                <div id="githubUrlError"
                                     class="form-error text-danger text-sm mt-1 "><?= errors('github_url') ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Image Upload -->
                    <div>
                        <!-- Additional Images -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Additional Images
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer file-input-label flex "
                                 id="lightgallery">
                                <?php
                                foreach ($images as $image) :?>
                                   <div class="p-2">
                                       <a href="<?= assets($image['path']) ?>">
                                           <img src="<?=assets($image['path'])?>" alt='' width="50" height="50" class="border">
                                       </a>
                                   </div>

                                <?php endforeach; ?>
                            </div>
                            <div id="imagesError"
                                 class="form-error text-danger text-sm mt-1"><?= errors('images') ?></div>
                        </div>

                    </div>
                </div>

                <!-- Form Actions -->
                <div class="border-t pt-6 mt-6">
                    <div class="flex justify-between space-x-4">
                        <button
                                type="button"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition"
                                onclick="history.back()"
                        >
                            Back
                        </button>
                        <button
                                type="submit"
                                class="px-6 py-2 bg-primary hover:bg-secondary text-white rounded-lg transition flex items-center"
                        >
                            <i class="fas fa-edit mr-2"></i> Edit Product
                        </button>
                    </div>
                </div>
            </form>

        <?php else : ?>
            <div class="mt-4 bg-yellow-50 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                 role="alert">
                Project not found or an error occurred.
            </div>
        <?php endif; ?>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.min.js"></script>
<script>
    // lightGallery(document.getElementById('lightgallery'));
</script>