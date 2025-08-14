<?php setTitle("Projects Gallery"); ?>

<!-- LightGallery CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/css/lightgallery.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/css/lg-zoom.min.css">
<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/css/lg-thumbnail.css" />
<link rel="stylesheet" href="<?=assets('css/projects.css')?>">


<!-- projects section starts -->
<section class="projects" id="projects" style="margin-top: 5rem">
    <h1 class="heading"><i class="fas fa-project-diagram"></i> My <span>Projects</span></h1>
    
    <div class="projects-container">
        <?php if (!empty($projects)): ?>
            <div class="projects-grid">
                <?php foreach ($projects as $index => $project): ?>
                    <?php 
                        $images = !empty($project['all_images']) ? explode(',', $project['all_images']) : [];
                        $mainFlags = !empty($project['image_main_flags']) ? explode(',', $project['image_main_flags']) : [];
                        $hasImages = !empty($images);
                    ?>
                    <div class="project-card">
                                                 <div class="image-gallery">
                             <?php if ($hasImages): ?>
                                 <div class="main-image-container">
                                     <div class="main-image" id="main-image-<?php echo $project['id']; ?>">
                                         <img src="<?php echo assets(htmlspecialchars(trim($images[0]))); ?>" 
                                              alt="<?php echo htmlspecialchars($project['title']); ?>"
                                              onerror="this.src='<?=assets('images/default-150x150.png')?>'">
                                         
                                         <?php if (count($images) > 1): ?>
                                             <button class="gallery-nav prev" onclick="changeMainImage(<?php echo $project['id']; ?>, -1)">
                                                 <i class="fas fa-chevron-left"></i>
                                             </button>
                                             <button class="gallery-nav next" onclick="changeMainImage(<?php echo $project['id']; ?>, 1)">
                                                 <i class="fas fa-chevron-right"></i>
                                             </button>
                                             
                                             <div class="image-counter">
                                                 <span id="counter-<?php echo $project['id']; ?>">1</span>/<?php echo count($images); ?>
                                             </div>
                                         <?php endif; ?>
                                     </div>
                                 </div>
                                 
                                 <!-- LightGallery Container (Hidden) -->
                                 <div class="lightgallery-container" id="lightgallery-<?php echo $project['id']; ?>" style="display: block;">
                                     <?php foreach ($images as $imgIndex => $imagePath): ?>
                                        <a href="<?php echo assets(htmlspecialchars(trim($imagePath))); ?>" 
                                        class="gallery-item"
                                                           data-sub-html="<?php echo htmlspecialchars($project['title']); ?> - Image <?php echo $imgIndex + 1; ?>">
                                                            <img src="<?= assets(htmlspecialchars(trim($imagePath))); ?>"
                                                                 class="img-fluid rounded shadow-sm"
                                                                 style="width: 100%; height: 150px; object-fit: cover;"
                                                                 alt="Project Image">
                                                        </a>

                                         <!-- <a href="<?php echo assets(htmlspecialchars(trim($imagePath))); ?>" 
                                            data-sub-html="<?php echo htmlspecialchars($project['title']); ?> - Image <?php echo $imgIndex + 1; ?>">
                                         </a> -->
                                     <?php endforeach; ?>
                                 </div>
                                 
                                 <!-- Click to open gallery -->
                                 <div class="gallery-overlay" onclick="openGallery(<?php echo $project['id']; ?>)">
                                     <i class="fas fa-expand-arrows-alt"></i>
                                     <span>عرض جميع الصور</span>
                                 </div>
                            <?php else: ?>
                                <img src="./assets/images/default-project.jpg" 
                                     alt="<?php echo htmlspecialchars($project['title']); ?>">
                            <?php endif; ?>
                            
                            <div class="project-overlay">
                                <div class="project-actions">
                                    <?php if (!empty($project['host_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($project['host_url']); ?>" target="_blank" class="action-btn">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($project['github_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($project['github_url']); ?>" target="_blank" class="action-btn">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="project-content">
                            <div class="project-header">
                                <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                                <span class="project-category"><?php echo htmlspecialchars($project['category']); ?></span>
                            </div>
                            
                            <p class="project-description">
                                <?php 
                                    $description = htmlspecialchars($project['description']);
                                    echo strlen($description) > 120 ? substr($description, 0, 120) . '...' : $description;
                                ?>
                            </p>
                            
                            <div class="project-technologies">
                                <?php 
                                    $techs = explode(',', $project['technologies']);
                                    foreach ($techs as $tech): 
                                        $tech = trim($tech);
                                        if (!empty($tech)):
                                ?>
                                    <span class="tech-tag"><?php echo htmlspecialchars($tech); ?></span>
                                <?php 
                                        endif;
                                    endforeach; 
                                ?>
                            </div>
                            
                            <div class="project-footer">
                                <span class="project-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo date('M Y', strtotime($project['created_at'])); ?>
                                </span>
                                <div class="project-links">
                                    <?php if (!empty($project['host_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($project['host_url']); ?>" target="_blank" class="project-link">
                                            <i class="fas fa-external-link-alt"></i> Live Demo
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($project['github_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($project['github_url']); ?>" target="_blank" class="project-link">
                                            <i class="fab fa-github"></i> Code
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-projects">
                <i class="fas fa-folder-open"></i>
                <h3>No projects found</h3>
                <p>Projects will appear here once they are added.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- projects section ends -->

  <!-- scroll top btn -->
  <a href="#home" aria-label="ScrollTop" class="fas fa-angle-up" id="scroll-top"></a>
  <!-- scroll back to top -->

<!-- LightGallery JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/lightgallery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/plugins/zoom/lg-zoom.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/thumbnail/lg-thumbnail.min.js"></script>

<script>
// Gallery functionality
const galleries = {};
const lightGalleryInstances = {};

// Initialize galleries when page loads
document.addEventListener('DOMContentLoaded', function() {
    <?php if (!empty($projects)): ?>
        <?php foreach ($projects as $project): ?>
            <?php 
                $images = !empty($project['all_images']) ? explode(',', $project['all_images']) : [];
                if (!empty($images)):
            ?>
                // Initialize gallery data
                galleries[<?php echo $project['id']; ?>] = {
                    currentIndex: 0,
                    totalImages: <?php echo count($images); ?>,
                    images: <?php echo json_encode($images); ?>
                };
                
                // Initialize LightGallery (hidden)
                lightGalleryInstances[<?php echo $project['id']; ?>] = lightGallery(document.getElementById('lightgallery-<?php echo $project['id']; ?>'), {
                    speed: 500,
                    download: true,
                    counter: true,
                    thumbnail: true,
                    zoom: true,
                    fullScreen: true,
                    autoplay: false,
                    progressBar: true,
                    backdropDuration: 400,
                    hideBarsDelay: 2000,
                    plugins: [lgZoom, lgThumbnail],
                    settings: {
                        slideEndAnimation: true,
                        hideControlOnEnd: false,
                        mousewheel: true,
                        getCaptionFromTitleOrAlt: true
                    }
                });
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
});

// Change main image
function changeMainImage(projectId, direction) {
    const gallery = galleries[projectId];
    if (!gallery) return;
    
    gallery.currentIndex += direction;
    
    if (gallery.currentIndex >= gallery.totalImages) {
        gallery.currentIndex = 0;
    } else if (gallery.currentIndex < 0) {
        gallery.currentIndex = gallery.totalImages - 1;
    }
    
    updateMainImage(projectId);
}

// Update main image display
function updateMainImage(projectId) {
    const gallery = galleries[projectId];
    if (!gallery) return;
    
    const mainImage = document.querySelector(`#main-image-${projectId} img`);
    const counter = document.getElementById(`counter-${projectId}`);
    
    if (mainImage) {
        mainImage.src = `<?php echo assets('images/'); ?>${gallery.images[gallery.currentIndex]}`;
        mainImage.alt = `Image ${gallery.currentIndex + 1}`;
    }
    
    if (counter) {
        counter.textContent = gallery.currentIndex + 1;
    }
}

// Open LightGallery
function openGallery(projectId) {
    const instance = lightGalleryInstances[projectId];
    if (instance) {
        // Start from current image
        instance.openGallery(galleries[projectId].currentIndex);
    }
}
</script>


