<?php setTitle(__('certificates_achievements') ?: 'الشهادات والإنجازات') ?>




    <!-- Page Header -->
    <section class="page-header">
        <h1><?= __('certificates_achievements') ?: 'الشهادات والإنجازات' ?></h1>
        <p><?= __('certificates_page_description') ?: 'استعرض جميع الشهادات والإنجازات والجوائز الحاصل عليها' ?></p>
    </section>

    <!-- Filter Section -->
    <section class="filter-section" style="min-height: 0;">
        <div class="filter-container">
            <div class="filter-buttons">
                <a href="Javascript:void(0);" class="filter-btn active" data-filter="all">
                    <i class="fas fa-th"></i>
                    <?= __('all_certificates') ?: 'جميع الشهادات' ?>
                </a>
                <?php foreach ($certificateTypes as $certificateType): 
                    ?>
                    <a href="Javascript:void(0);" class="filter-btn" data-filter="<?= $certificateType['id'] ?>">
                        <i class="fas fa-<?= 
                            $certificateType['id'] === 'certificate' ? 'certificate' : 
                            ($certificateType['id'] === 'award' ? 'trophy' : 
                            ($certificateType['id'] === 'course' ? 'graduation-cap' : 'star')) 
                        ?>"></i>
                        <?= $certificateType['name'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="cards-count">
                <i class="fas fa-certificate"></i>
                <span id="count-display"><?= count($certificates) ?></span> 
                <?= __('certificate') ?: 'شهادة' ?>
            </div>
        </div>
    </section>

  
 <!-- Certificates Grid -->
    <section class="cards-grid">
        <?php if (!empty($certificates)): ?>
            <div class="cards-container" id="certificates-container">
                <?php foreach ($certificates as $certificate): ?>
                    <div class="card-enhanced" data-type="<?= $certificate['certificate_type'] ?>">
                        <?php if ($certificate['is_featured']): ?>
                            <div class="featured-badge-enhanced">
                                <i class="fas fa-star"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-image">
                            <i class="card-icon fas fa-<?= 
                                $certificate['certificate_type'] === 'certificate' ? 'certificate' : 
                                ($certificate['certificate_type'] === 'award' ? 'trophy' : 
                                ($certificate['certificate_type'] === 'course' ? 'graduation-cap' : 'star')) 
                            ?>"></i>
                        </div>
                        
                        <div class="card-body-enhanced">
                            <div class="card-header-enhanced">
                                <span class="card-type-enhanced">
                                    <?= $certificateTypes[$certificate['certificate_type']] ?? $certificate['certificate_type'] ?>
                                </span>
                                <div class="card-date-enhanced">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?= date('Y', strtotime($certificate['issued_date'])) ?>
                                </div>
                            </div>
                            
                            <h3 class="card-title-enhanced">
                                <?= htmlspecialchars($certificate['title']) ?>
                            </h3>
                            
                            <div class="card-issuer-enhanced">
                                <i class="fas fa-building"></i>
                                <?= htmlspecialchars($certificate['issuer']) ?>
                            </div>
                            
                            <?php if (!empty($certificate['description'])): ?>
                                <p class="card-description-enhanced">
                                    <?= htmlspecialchars($certificate['description']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (!empty($certificate['skills_related'])): ?>
                                <div class="card-skills-enhanced">
                                    <div class="skills-list">
                                        <?php
                                        $skills = array_map('trim', explode(',', $certificate['skills_related']));
                                        foreach ($skills as $skill):
                                        ?>
                                            <span class="skill-item"><?= htmlspecialchars($skill) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-actions-enhanced">
                                <?php if (!empty($certificate['certificate_file'])): ?>
                                    <a href="<?= assets($certificate['certificate_file']) ?>" 
                                       target="_blank" class="action-btn action-btn-primary">
                                        <i class="fas fa-eye"></i>
                                        <?= __('view_certificate') ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($certificate['verification_url'])): ?>
                                    <a href="<?= $certificate['verification_url'] ?>" 
                                       target="_blank" class="action-btn action-btn-secondary">
                                        <i class="fas fa-check-circle"></i>
                                        <?= __('verify') ?: 'تحقق' ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (empty($certificate['certificate_file']) && empty($certificate['verification_url'])): ?>
                                    <div class="action-btn action-btn-secondary">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?= date('M d, Y', strtotime($certificate['issued_date'])) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="empty-state" <?=empty($certificates) ? 'style="display: block;"' : 'style="display: none;"' ?>>
                <i class="fas fa-certificate"></i>
                <h3><?= __('no_certificates_found') ?: 'لا توجد شهادات متاحة' ?></h3>
                <!-- <a href="<?= route('home') ?>" class="action-btn action-btn-primary">
                    <i class="fas fa-home"></i>
                    <?= __('back_to_home') ?: 'العودة للرئيسية' ?>
                </a> -->
            </div>
        <?php endif; ?>
    </section>

    
    <script>
    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const certificates = document.querySelectorAll('.card-enhanced');
        const countDisplay = document.getElementById('count-display');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterType = this.getAttribute('data-filter');
                let visibleCount = 0;
                
                certificates.forEach(certificate => {
                    const certificateType = certificate.getAttribute('data-type');
                    
                    if (filterType === 'all' || certificateType === filterType) {
                        certificate.style.display = 'block';
                        certificate.style.animation = 'fadeInUp 0.6s ease-out';
                        visibleCount++;
                    } else {
                        certificate.style.display = 'none';
                    }
                });
                
                        $('.empty-state').css('display',visibleCount === 0?'block':'none');
                // Update count
                countDisplay.textContent = visibleCount;
            });
        });
        
        // Add stagger animation to certificates
        certificates.forEach((certificate, index) => {
            certificate.style.animationDelay = `${index * 0.1}s`;
        });
    });
    </script>

