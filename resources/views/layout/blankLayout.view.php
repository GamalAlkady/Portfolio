<!DOCTYPE html>
<html lang="<?= locale() ?>" dir="<?= locale() === 'ar' ? 'rtl' : 'ltr' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- SEO Meta Tags -->
    <title><?= getTitle() ?> - <?= siteName() ?></title>
    <meta name="description" content="<?= siteDescription() ?>">
    <meta name="keywords" content="<?= siteKeywords() ?>">
    <meta name="author" content="<?= siteName() ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= getTitle() ?> - <?= siteName() ?>">
    <meta property="og:description" content="<?= siteDescription() ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= siteName() ?>">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= getTitle() ?> - <?= siteName() ?>">
    <meta name="twitter:description" content="<?= siteDescription() ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= siteLogo() ?>" type="image/x-icon">
    <link rel="icon" href="<?= siteLogo() ?>" type="image/x-icon">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Maintenance Styles -->
    <link rel="stylesheet" href="<?= assets('css/maintenance.css') ?>">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= assets('plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= assets('css/adminlte.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@330;400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Additional Inline Styles for Layout Only -->
    <style>
        /* Language Switcher */

        html[dir="rtl"],
        .body {
            font-family: 'Cairo', Arial, sans-serif !important;
        }

        html[dir="ltr"],
        .body {
            font-family: 'Roboto', Arial, sans-serif !important;
        }

           /* Styles for the language switcher button */
    </style>
</head>

<body class="hold-transition login-page">
   
    <!-- Main Content -->
    <main class="fade-in">
        {{content}}
    </main>



    <!-- jQuery -->
    <script src="<?= assets('plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= assets('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= assets('js/adminlte.js') ?>"></script>

    <!-- JavaScript -->
    <script>
        // Add smooth scrolling and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add fade-in animation to elements
            const elements = document.querySelectorAll('.slide-up');
            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(30px)';
                    element.style.transition = 'all 0.6s ease';

                    setTimeout(() => {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 200);
            });

            // Add keyboard navigation for language switcher
            const languageLinks = document.querySelectorAll('.language-switcher a');
            languageLinks.forEach(link => {
                link.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });

            // Add smooth transitions for hover effects
            const interactiveElements = document.querySelectorAll('a, button, .interactive');
            interactiveElements.forEach(element => {
                element.style.transition = 'all 0.3s ease';
            });

            // Add loading animation
            const body = document.body;
            body.style.opacity = '0';
            body.style.transition = 'opacity 0.5s ease';

            setTimeout(() => {
                body.style.opacity = '1';
            }, 100);
        });

        // Add performance optimization
        if ('requestIdleCallback' in window) {
            requestIdleCallback(() => {
                // Preload critical resources
                const criticalImages = document.querySelectorAll('img[data-critical]');
                criticalImages.forEach(img => {
                    const link = document.createElement('link');
                    link.rel = 'preload';
                    link.as = 'image';
                    link.href = img.src;
                    document.head.appendChild(link);
                });
            });
        }

        // Add error handling for images
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG') {
                e.target.style.display = 'none';
                console.warn('Image failed to load:', e.target.src);
            }
        }, true);

        // Add analytics tracking (if needed)
        function trackEvent(action, category = 'Maintenance', label = '') {
            if (typeof gtag !== 'undefined') {
                gtag('event', action, {
                    event_category: category,
                    event_label: label
                });
            }
        }

        // Track language switches
        document.querySelectorAll('.language-switcher a').forEach(link => {
            link.addEventListener('click', function() {
                const language = this.textContent.trim();
                trackEvent('language_switch', 'User Interaction', language);
            });
        });
    </script>

    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "<?= siteName() ?>",
            "description": "<?= siteDescription() ?>",
            "url": "<?= $_SERVER['HTTP_HOST'] ?? '' ?>",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "<?= $_SERVER['HTTP_HOST'] ?? '' ?>/search?q={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
</body>

</html>