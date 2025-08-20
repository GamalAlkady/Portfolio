<?php
setTitle(__('maintenance_mode'));
// استخدام layout خاص بصفحة الصيانة
layout('blankLayout');
?>

<!-- جميع الأنماط موجودة في ملف CSS منفصل -->

<div class="maintenance-container">
    <!-- Animated Particles Background -->
    <div class="particles">
        <div class="particle" style="left: 10%; animation-delay: 0s; width: 10px; height: 10px;"></div>
        <div class="particle" style="left: 20%; animation-delay: 1s; width: 15px; height: 15px;"></div>
        <div class="particle" style="left: 30%; animation-delay: 2s; width: 8px; height: 8px;"></div>
        <div class="particle" style="left: 40%; animation-delay: 0.5s; width: 12px; height: 12px;"></div>
        <div class="particle" style="left: 50%; animation-delay: 1.5s; width: 6px; height: 6px;"></div>
        <div class="particle" style="left: 60%; animation-delay: 2.5s; width: 14px; height: 14px;"></div>
        <div class="particle" style="left: 70%; animation-delay: 0.8s; width: 9px; height: 9px;"></div>
        <div class="particle" style="left: 80%; animation-delay: 1.8s; width: 11px; height: 11px;"></div>
        <div class="particle" style="left: 90%; animation-delay: 2.2s; width: 7px; height: 7px;"></div>
    </div>

    <div class="maintenance-content">
        <!-- Main Icon -->
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>

        <!-- Title -->
        <h1 class="maintenance-title">
            <?= __('maintenance_mode') ?>
        </h1>

        <!-- Subtitle -->
        <p class="maintenance-subtitle">
            <?= __('maintenance_mode_message') ?>
        </p>

        <!-- Progress Bar -->
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>

        <!-- Features Being Improved -->
        <div class="maintenance-features">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <div class="feature-text">
                    <?= __('improving_performance') ?>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="feature-text">
                    <?= __('enhancing_security') ?>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-magic"></i>
                </div>
                <div class="feature-text">
                    <?= __('adding_features') ?>
                </div>
            </div>
        </div>

        <!-- Main Message -->
        <div class="maintenance-message">
            <i class="fas fa-info-circle" style="margin-<?= locale() === 'ar' ? 'left' : 'right' ?>: 0.5rem;"></i>
            <?= __('maintenance_mode_help') ?>
        </div>

        <!-- Estimated Time -->
        <div class="estimated-time" style="margin: 1.5rem 0; padding: 1rem; background: rgba(102, 126, 234, 0.1); border-radius: 10px; border-left: 4px solid #667eea;">
            <i class="fas fa-clock" style="color: #667eea; margin-<?= locale() === 'ar' ? 'left' : 'right' ?>: 0.5rem;"></i>
            <strong><?= __('estimated_completion') ?>:</strong>
            <span id="countdown" style="color: #667eea; font-weight: bold;">2-3 <?= __('hours') ?></span>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <div class="contact-title">
                <i class="fas fa-headset"></i>
                <?= __('need_help') ?>
            </div>
            <div class="contact-links">
                <?php if (setting('site_email')): ?>
                <a href="mailto:<?= setting('site_email') ?>" class="contact-link">
                    <i class="fas fa-envelope"></i>
                    <?= __('email_us') ?>
                </a>
                <?php endif; ?>

                <?php if (setting('site_phone')): ?>
                <a href="tel:<?= setting('site_phone') ?>" class="contact-link">
                    <i class="fas fa-phone"></i>
                    <?= __('call_us') ?>
                </a>
                <?php endif; ?>

                <?php
                $socialLinks = [
                    'facebook_url' => ['icon' => 'fab fa-facebook', 'text' => 'Facebook'],
                    'twitter_url' => ['icon' => 'fab fa-twitter', 'text' => 'Twitter'],
                    'linkedin_url' => ['icon' => 'fab fa-linkedin', 'text' => 'LinkedIn']
                ];

                foreach ($socialLinks as $key => $social):
                    if (setting($key)):
                ?>
                <a href="<?= setting($key) ?>" class="contact-link" target="_blank">
                    <i class="<?= $social['icon'] ?>"></i>
                    <?= $social['text'] ?>
                </a>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>

<script>
// Add some interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Animate feature items on load
    const featureItems = document.querySelectorAll('.feature-item');
    featureItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.6s ease';

            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 100);
        }, index * 200);
    });

    // Add floating animation to particles
    const particles = document.querySelectorAll('.particle');
    particles.forEach(particle => {
        const randomDelay = Math.random() * 2;
        const randomDuration = 4 + Math.random() * 4;
        particle.style.animationDelay = randomDelay + 's';
        particle.style.animationDuration = randomDuration + 's';
    });

    // Add dynamic countdown (optional)
    const countdownElement = document.getElementById('countdown');
    if (countdownElement) {
        let hours = 2;
        let minutes = Math.floor(Math.random() * 60);

        const updateCountdown = () => {
            if (minutes > 0) {
                minutes--;
            } else if (hours > 0) {
                hours--;
                minutes = 59;
            }

            const hoursText = '<?= __("hours") ?>';
            const minutesText = '<?= __("minutes") ?>';

            if (hours > 0) {
                countdownElement.textContent = `${hours} ${hoursText} ${minutes} ${minutesText}`;
            } else {
                countdownElement.textContent = `${minutes} ${minutesText}`;
            }
        };

        // Update every minute
        setInterval(updateCountdown, 60000);
    }

    // Add loading states for external links
    document.querySelectorAll('a[href^="http"], a[href^="mailto"], a[href^="tel"]').forEach(link => {
        link.addEventListener('click', function() {
            this.style.opacity = '0.7';
            this.style.pointerEvents = 'none';

            setTimeout(() => {
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
            }, 2000);
        });
    });
});
</script>
