<!-- Certificates Section -->
<section class="education " id="certificate">
    <h1 class="heading"><i class="fas fa-certificate"></i> <span><?= __('certificates_achievements') ?></span></h1>

    <?php if (!empty($featuredCertificates)): ?>
        <div class="box-container" style="flex-direction: row;">
            <?php foreach ($featuredCertificates as $certificate): ?>
                <div class="box" data-aos="zoom-in" style="width: fit-content;margin-inline-end: 1% !important;">
                    <div class="certificate-card ">
                        <!-- Certificate Header -->
                        <div class="certificate-header">
                            <div class="certificate-type">
                                <span class="type-badge type-<?= $certificate['certificate_type'] ?>">
                                    <i class="fas fa-<?=$certificate['certificate_type'] === 'certificate' ? 'certificate' : ($certificate['certificate_type'] === 'award' ? 'trophy' : ($certificate['certificate_type'] === 'course' ? 'graduation-cap' : 'star'))
                                                        ?>"></i>
                                    <?php
                                    $typeLabels = [
                                        'certificate' => __('certificate') ?: 'شهادة',
                                        'award' => __('award') ?: 'جائزة',
                                        'course' => __('course') ?: 'دورة',
                                        'achievement' => __('achievement') ?: 'إنجاز'
                                    ];
                                    echo $typeLabels[$certificate['certificate_type']] ?? $certificate['certificate_type'];
                                    ?>
                                </span>

                                <?php if ($certificate['is_featured']): ?>
                                    <span class="featured-badge">
                                        <i class="fas fa-star"></i>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="certificate-date">
                                <i class="fas fa-calendar-alt"></i>
                                <?= date('Y', strtotime($certificate['issued_date'])) ?>
                            </div>
                        </div>

                        <!-- Certificate Content -->
                        <div class="certificate-content">
                            <h1 class="certificate-title"><?= htmlspecialchars($certificate['title']) ?></h1>

                            <div class="issuer">
                                <i class="fas fa-building"></i>
                                <span><?= htmlspecialchars($certificate['issuer']) ?></span>
                            </div>

                            <?php if (!empty($certificate['description'])): ?>
                                <p class="certificate-description">
                                    <?= htmlspecialchars(substr($certificate['description'], 0, 150)) ?>
                                    <?= strlen($certificate['description']) > 150 ? '...' : '' ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($certificate['skills_related'])): ?>
                                <div class="skills-tags">
                                    <?php
                                    $skills = array_map('trim', explode(',', $certificate['skills_related']));
                                    foreach (array_slice($skills, 0, 4) as $skill):
                                    ?>
                                        <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                                    <?php endforeach; ?>
                                    <?php if (count($skills) > 4): ?>
                                        <span class="skill-tag more">+<?= count($skills) - 4 ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Certificate Footer -->
                        <div class="certificate-footer">
                            <div class="certificate-actions">
                                <?php if (!empty($certificate['certificate_file'])): ?>
                                    <a href="<?= assets( $certificate['certificate_file']) ?>"
                                        target="_blank" class="btn-view-certificate"
                                        title="<?= __('view_certificate') ?: 'عرض الشهادة' ?>">
                                        <i class="fas fa-eye"></i>
                                        <?= __('view') ?: 'عرض' ?>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($certificate['verification_url'])): ?>
                                    <a href="<?= $certificate['verification_url'] ?>"
                                        target="_blank" class="btn-verify"
                                        title="<?= __('verify_certificate') ?: 'التحقق من الشهادة' ?>">
                                        <i class="fas fa-check-circle"></i>
                                        <?= __('verify') ?: 'تحقق' ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="issue-date">
                                <small>
                                    <i class="fas fa-calendar"></i>
                                    <?= date('M Y', strtotime($certificate['issued_date'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- View All Button -->
        <div class="certificates-footer">
            <a href="<?= route('certificates.view') ?>" class="btn btn-view-all">
                <i class="fas fa-eye"></i>
                <?= __('view_all') ?>
            </a>
        </div>

    <?php else: ?>
        <div class="no-certificates">
            <div class="no-content-placeholder">
                <i class="fas fa-certificate"></i>
                <h3><?= __('no_certificates_yet') ?: 'لا توجد شهادات حالياً' ?></h3>
                <p><?= __('certificates_coming_soon') ?: 'ستتم إضافة الشهادات قريباً' ?></p>
            </div>
        </div>
    <?php endif; ?>
</section>

<style>
    /* Certificates Section Styles */
    .certificates {
        padding: 5rem 9%;
        /* background: var(--bg); */
    }

    .certificates .box-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .certificate-card {
        /* background: var(--white); */
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        /* border: 1px solid var(--gray); */
        position: relative;
    }

    .certificate-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .certificate-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--light), var(--dark, #e6a820));
        color: white;
    }

    .certificate-type {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .type-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .type-badge i {
        font-size: 1rem;
    }

    .type-certificate {
        background: var(--blue, #007bff);
    }

    .type-award {
        background: var(--success, #28a745);
    }

    .type-course {
        background: var(--info, #17a2b8);
    }

    .type-achievement {
        background: var(--warning, #ffc107);
    }

    .featured-badge {
        background: var(--warning, #ffc107);
        color: var(--black);
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }

    .certificate-date {
        color: rgba(255, 255, 255, 0.9);
        /* font-size: 0.9rem; */
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .certificate-content {
        padding: 1.5rem;
    }

    .certificate-title {
        /* font-size: 1.3rem;
        font-weight: 700; */
        color: var(--black);
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .issuer {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--light-color);
        font-size: 1.5rem;
        margin-bottom: 1rem;
        text-align: start;

    }

    .issuer i {
        color: var(--main-color);
    }

    .certificate-description {
        color: var(--light-color);
        line-height: 1.6;
        margin-bottom: 1rem;
        font-size: 1rem;
        text-align: start;
    }

    .skills-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .skill-tag {
        background: var(--main-color-light, #f8f9fa);
        color: var(--text-dark);
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        /* font-size: 0.8rem; */
        font-weight: 500;
        border: 1px solid var(--main-color-lighter, #e9ecef);
    }

    .skill-tag.more {
        background: var(--light-color);
        color: var(--white);
    }

    .certificate-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--gray);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--light, #f8f9fa);
    }

    .certificate-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-view-certificate,
    .btn-verify {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        text-decoration: none;
        /* font-size: 0.8rem; */
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        transition: all 0.3s ease;
    }

    .btn-view-certificate {
        background: var(--primary);
        color: var(--white);
    }

    .btn-view-certificate:hover {
        background: var(--dark, #e6a820);
        transform: translateY(-2px);
    }

    .btn-verify {
        background: var(--success, #28a745);
        color: var(--white);
    }

    .btn-verify:hover {
        background: var(--success-dark, #1e7e34);
        transform: translateY(-2px);
    }

    .issue-date {
        color: var(--light-color);
        font-size: 1rem;
    }

    .certificates-footer {
        text-align: center;
        margin-top: 3rem;
    }

    .btn-view-all {
        background: var(--main-color);
        color: var(--white);
        padding: 1rem 2rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 2px solid var(--main-color);
    }

    .btn-view-all:hover {
        background: transparent;
        color: var(--main-color);
        transform: translateY(-3px);
    }

    .no-certificates {
        text-align: center;
        padding: 3rem 0;
    }

    .no-content-placeholder i {
        font-size: 4rem;
        color: var(--light-color);
        margin-bottom: 1rem;
    }

    .no-content-placeholder h3 {
        color: var(--black);
        margin-bottom: 0.5rem;
    }

    .no-content-placeholder p {
        color: var(--light-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .certificates {
            padding: 3rem 5%;
        }

        .certificates .box-container {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .certificate-header {
            padding: 1rem;
        }

        .certificate-content {
            padding: 1rem;
        }

        .certificate-footer {
            padding: 0.8rem 1rem;
            flex-direction: column;
            gap: 0.5rem;
        }

        .certificate-actions {
            order: 2;
        }

        .issue-date {
            order: 1;
        }
    }

    @media (max-width: 450px) {
        .certificates {
            padding: 2rem 3%;
        }

        .certificate-title {
            /* font-size: 1.1rem; */
        }

        .skills-tags {
            justify-content: center;
        }
    }

    /* Animation Enhancements */
    @keyframes certificateSlideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .certificate-card {
        animation: certificateSlideIn 0.6s ease-out;
    }

    .certificate-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .certificate-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .certificate-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .certificate-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    .certificate-card:nth-child(5) {
        animation-delay: 0.5s;
    }

    .certificate-card:nth-child(6) {
        animation-delay: 0.6s;
    }
</style>