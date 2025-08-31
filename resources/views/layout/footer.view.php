<section class="footer">

    <div class="box-container">

        <div class="box">
            <h3><?= setting('name_' . locale()) . ' ' . __('portfolio') ?></h3>
            <p><?= __('thanks_message') ?></p>
        </div>

        <div class="box">
            <?php if(isset($routeName)): ?>
            <h3><?= __('quick_links') ?></h3>
            <a href="<?= isset($routeName) ? route($routeName) : '' ?>#home"><i class="fas fa-chevron-circle-right"></i> <?= __('home') ?></a>
            <a href="<?= isset($routeName) ? route($routeName) : '' ?>#about"><i class="fas fa-chevron-circle-right"></i> <?= __('about_me') ?></a>
            <a href="<?= isset($routeName) ? route($routeName) : '' ?>#education"><i class="fas fa-chevron-circle-right"></i> <?= __('education') ?></a>
            <a href="<?= isset($routeName) ? route($routeName) : '' ?>#skills"><i class="fas fa-chevron-circle-right"></i> <?= __('skills') ?></a>
            <a href="<?= isset($routeName) ? route($routeName) : '' ?>#experience"><i class="fas fa-chevron-circle-right"></i> <?= __('experience') ?></a>
            <a href="<?= isset($routeName) ? route($routeName) : '' ?>#contact"><i class="fas fa-chevron-circle-right"></i> <?= __('contact') ?></a>
            <?php endif; ?>
        </div>

        <div class="box">
            <h3><?= __('contact_info') ?></h3>
            <p><i class="fas fa-phone"></i><span style="padding:0 1rem;"><?= setting('phone') ?></span></p>
            <p><i class="fas fa-envelope"></i><span style="padding:0 1rem;"><?= setting('email') ?></span></p>
            <p><i class="fas fa-map-marked-alt"></i><span style="padding:0 1rem;"><?= setting('location_' . locale()) ?></span></p>
            <div class="share">

                <?php if (!empty(setting('phone'))) { ?><a href="tel:<?= setting('phone') ?>" class="whatsapp fab fa-whatsapp" aria-label="WhatsApp" target="_blank"></a><?php } ?>
                <?php if (!empty(setting('email'))) { ?><a href="mailto:<?= setting('email') ?>" class="fas fa-envelope" aria-label="Mail" target="_blank"></a><?php } ?>
                <?php if (!empty(setting('linkedin_url'))) { ?> <a href="<?= setting('linkedin') ?>" class="fab fa-linkedin" aria-label="LinkedIn" target="_blank"></a><?php } ?>
                <?php if (!empty(setting('github_url'))) { ?><a href="<?= setting('github') ?>" class="fab fa-github" aria-label="GitHub" target="_blank"></a><?php } ?>
                <?php if (!empty(setting('instagram_url'))) { ?><a href="<?= setting('instagram') ?>" class="fab fa-instagram" aria-label="Instagram" target="_blank"></a><?php } ?>
                <?php if (!empty(setting('facebook_url'))) { ?> <a href="<?= setting('facebook') ?>" class="fab fa-facebook" aria-label="Facebook" target="_blank"></a><?php } ?>
                <?php if (!empty(setting('twitter_url'))) { ?> <a href="<?= setting('twitter') ?>" class="fab fa-twitter" aria-label="Twitter" target="_blank"></a><?php } ?>
                <?php if (!empty(setting('youtube_url'))) { ?> <a href="<?= setting('youtube') ?>" class="fab fa-youtube" aria-label="Youtube" target="_blank"></a><?php } ?>

            </div>
        </div>
        <!-- عداد الزوار -->
        <?php if (setting('show_visitor_counter', '1') === '1'): ?>
            <div class="box">
                <h3><i class="fas fa-chart-bar"></i> <?= (__('visitors_statistics') ?: 'إحصائيات الزوار') ?></h3>
                <?php
                $visitorStats = getVisitorStats();
                ?>
                <div class="visitor-stats">
                    <div class="stat-item">
                        <i class="fas fa-eye"></i>
                        <span class="stat-label"><?= (__('visitors_today')) ?>:</span>
                        <span class="stat-value"><?= $visitorStats['today']['total_visits'] ?></span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-users"></i>
                        <span class="stat-label"><?= (__('unique_today') ?: 'فريد اليوم') ?>:</span>
                        <span class="stat-value"><?= $visitorStats['today']['unique_visitors'] ?></span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-globe"></i>
                        <span class="stat-label"><?= (__('total_visits') ?: 'إجمالي الزيارات') ?>:</span>
                        <span class="stat-value"><?= $visitorStats['total']['total_visits'] ?></span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-wifi"></i>
                        <span class="stat-label"><?= (__('online_now') ?: 'متصل الآن') ?>:</span>
                        <span class="stat-value"><?= $visitorStats['online'] ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <h1 class="credit"><?= __('designed_by') ?> <i class="fa fa-heart pulse"></i> <a href="https://wa.me/message/RWP5KH55UTUUF1"><?= setting('name_' . locale()) ?></a></h1>

</section>
<!-- scroll top btn -->
<a href="#home" aria-label="ScrollTop" id="scroll-top"><i class="fas fa-angle-up"></i></a>
<!-- scroll back to top -->
<style>
    .visitor-stats {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #fff;
    }

    .stat-item i {
        width: 20px;
        color: #ffd700;
        text-align: center;
    }

    .stat-label {
        flex: 1;
        color: #ccc;
    }

    .stat-value {
        font-weight: bold;
        color: #ffd700;
        font-size: 1.1em;
    }

    @media (max-width: 768px) {
        .visitor-stats {
            gap: 0.6rem;
        }

        .stat-item {
            font-size: 0.8rem;
        }

        .stat-item i {
            width: 18px;
        }
    }

    /* تحديث الزوار كل 5 دقائق */
    .visitor-counter-refresh {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }

        100% {
            opacity: 1;
        }
    }
</style>

<script>
    // تحديث عداد الزوار كل 5 دقائق
    setInterval(function() {
        // إعادة تحميل الصفحة بصمت لتحديث الإحصائيات
        fetch(window.location.href, {
                method: 'GET',
                cache: 'no-cache'
            }).then(response => response.text())
            .then(html => {
                // استخراج إحصائيات الزوار الجديدة من الاستجابة
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newStats = doc.querySelector('.visitor-stats');
                const currentStats = document.querySelector('.visitor-stats');

                if (newStats && currentStats) {
                    currentStats.innerHTML = newStats.innerHTML;
                    // إضافة تأثير بصري للتحديث
                    currentStats.classList.add('visitor-counter-refresh');
                    setTimeout(() => {
                        currentStats.classList.remove('visitor-counter-refresh');
                    }, 2000);
                }
            }).catch(err => {
                console.log('عداد الزوار: فشل في التحديث التلقائي');
            });
    }, 300000); // كل 5 دقائق
</script>