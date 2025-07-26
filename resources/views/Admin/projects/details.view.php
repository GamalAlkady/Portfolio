<?php setTitle("Details"); ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">

        <!-- Product Header -->
        <div class="p-6 border-b">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium mb-2">
                            <?=$project['category']?>
                        </span>
                    <h1 class="text-3xl font-bold text-gray-900"><?=$project['title']?></h1>
                </div>

             <div>
                 <div class=" md:mt-0 flex justify-around">
                     <a href="/admin/edit-project/<?php echo $project['id']; ?>" class="btn  btn-outline-primary">
                         <i class="fas fa-edit"></i>
                     </a>
                     <a href="/admin/delete-project/<?php echo $project['id']; ?>"
                        class="btn btn-outline-danger"
                        onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا المشروع؟')">
                         <i class="fas fa-trash"></i>
                     </a>
                 </div>

                 <div class="mt-4 md:mt-0">
                     <span class="text-gray-500">Created: <?=$project['created_at']?></span>
                 </div>
             </div>
            </div>
        </div>


        <!-- Details -->
    <div class="p-6 border-b d-flex gap-1">
        <div class="lg:w-5/6">
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Project Details</h2>
                <p class="text-gray-700 mb-6"><?=$project['description']?></p>

                <div class="mb-6">
                    <h3 class="font-medium text-gray-900 mb-2">Technologies Used</h3>
                    <p> <?= htmlspecialchars($project['technologies']) ?></p>

                </div>


            </div>
        </div>

        <div class="lg:w-1/4">
            <div class="space-y-4">
                <?php if (!empty($project['host_url'])): ?>
                    <a href="<?=$project['host_url']?>"
                       class="block w-full bg-primary hover:bg-secondary text-white text-center py-2 px-4 rounded-lg transition-colors"
                       target="_blank">
                        <i class="fas fa-external-link-alt mr-2"></i> View Live Project
                    </a>
                <?php endif; ?>

                <?php if (!empty($project['github_url'])): ?>
                    <a href="<?=$project['github_url']?>"
                       class="block w-full bg-gray-800 hover:bg-gray-900 text-white text-center py-2 px-4 rounded-lg transition-colors"
                    >
                        <i class="fab fa-github mr-2"></i> View on GitHub
                    </a>
                <?php endif; ?>



            </div>
        </div>
    </div>

        <!-- Product Content -->
        <div class="p-6">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Main Image -->
                <div>
                    <div class=" md:mt-0 flex justify-around">
                        <a href="/admin/edit-project/<?php echo $project['id']; ?>" class="btn  btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/admin/delete-project/<?php echo $project['id']; ?>"
                           class="btn btn-outline-danger"
                           onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا المشروع؟')">
                            <i class="fas fa-trash"></i>
                        </a>
                </div>

                <div class="lg:w-2/3">
                    <div class="bg-gray-100 rounded-lg overflow-hidden mb-4">
                        <img
                                src="<?=assets($project['image'])?>"
                                alt="{{title}}"
                                class="w-full h-80 object-cover"
                                loading="lazy"
                        />
                    </div>

                    <!-- Gallery -->
                    <?php if (!empty($project['other_images'])): ?>
                        <div id="lightgallery">
                            <?php foreach (json_decode($project['other_images'], true) as $img): ?>
                            <a href="<?= assets($img) ?>">
                                <img  src="<?= assets($img) ?>" width="100">
                            </a>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>
                </div>



            </div>
        </div>
    </div>
</main>


<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.min.js"></script>
<script>
    lightGallery(document.getElementById('lightgallery'));
</script>

<script>
    // Sample data - in a real app this would come from your API
    const productData = {
        id: 1,
        title: "Sample Project",
        description: "This is a detailed description of the project. It explains what the project does, its features, and any other relevant information that would help visitors understand the project better.",
        image: "https://picsum.photos/800/500?random=1",
        host_url: "https://example.com",
        github_url: "https://github.com/example/project",
        technologies: ["JavaScript", "React", "Node.js", "Tailwind CSS"],
        category: "Web Application",
        other_images: [
            "https://picsum.photos/400/300?random=2",
            "https://picsum.photos/400/300?random=3",
            "https://picsum.photos/400/300?random=4"
        ],
        created_at: "2023-05-15"
    };

    // Navigation functions
    function navigateToHome() {
        console.log("Navigating to home");
        // window.location.href = "/";
    }

    function navigateToProjects() {
        console.log("Navigating to projects");
        // window.location.href = "/projects";
    }

    function navigateToContact() {
        console.log("Navigating to contact");
        // window.location.href = "/contact";
    }

    function openExternalLink(url) {
        console.log("Opening external link:", url);
        // window.open(url, "_blank");
    }

    // Render product data
    function renderProduct(data) {
        // This would be replaced with your templating engine or framework
        document.title = `${data.title} | MyProjects`;

        // In a real app, you would use a templating system or framework
        // This is a simplified version for demonstration
        const elements = document.querySelectorAll('[class*="{{"]');
        elements.forEach(el => {
            let content = el.className;
            Object.keys(data).forEach(key => {
                const regex = new RegExp(`\\{\\{${key}\\}\\}`, 'g');
                content = content.replace(regex, data[key]);
            });
            el.className = content;
        });

        const textElements = document.querySelectorAll('[textContent*="{{"]');
        textElements.forEach(el => {
            let content = el.textContent;
            Object.keys(data).forEach(key => {
                const regex = new RegExp(`\\{\\{${key}\\}\\}`, 'g');
                content = content.replace(regex, data[key]);
            });
            el.textContent = content;
        });

        const attrElements = document.querySelectorAll('[src*="{{"]');
        attrElements.forEach(el => {
            let src = el.getAttribute('src');
            Object.keys(data).forEach(key => {
                const regex = new RegExp(`\\{\\{${key}\\}\\}`, 'g');
                src = src.replace(regex, data[key]);
            });
            el.setAttribute('src', src);
        });
    }


</script>
