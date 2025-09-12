<header class=" navbar-light">


    <div id="menu" class="fas fa-bars"></div>
    <nav class="navbar navbar-light">
        <ul>
            <li><a class="active" href="#home"><?= __('home') ?></a></li>
            <li><a href="#about"><?= __('about_me') ?></a></li>
            <?php if (!empty(setting('education_' . locale()))): ?><li><a href="#education"><?= __('education') ?></a></li><?php endif; ?>
            <?php if (!empty(setting('experience_' . locale()))): ?><li><a href="#experience"><?= __('experience') ?></a></li><?php endif; ?>
            <?php if (!empty($featuredCertificates)): ?><li><a href="#certificate"><?= __('certificates') ?></a></li><?php endif; ?>
            <?php if (count($skills) > 0): ?> <li><a href="#skill"><?= __('skills') ?></a></li><?php endif; ?>
            <li><a href="#contact"><?= __('contact') ?></a></li>
            <li>
                <!-- Language Switcher -->
                <div class="language-switcher">
                    <?php if(locale() === 'en'): ?>
                    <a href="<?= route('language.switch', ['locale' => 'ar', 'type' => 'user']) ?>"
                        class="<?= locale() === 'ar' ? 'active' : '' ?>"
                        title="<?= __('arabic') ?>"
                        data-lang="ar"
                        aria-label="<?= __('switch_to_arabic') ?>">
                        AR
                    </a>
                    <?php else: ?>
                    <a href="<?= route('language.switch', ['locale' => 'en', 'type' => 'user']) ?>"
                        class="<?= locale() === 'en' ? 'active' : '' ?>"
                        title="<?= __('english') ?>"
                        data-lang="en"
                        aria-label="<?= __('switch_to_english') ?>">
                        EN
                    </a>
                    <?php endif; ?>
                    
                </div>
            </li>
        </ul>
    </nav>

    <a href="<?= isset($routeName) ? route($routeName) : '' ?>#" class="logo">
        <img src="<?= assets(setting('logo_' . theme()), 'images/logo.svg') ?>" alt="V2 Logo" style="height: 35px; width: auto; margin-inline-end: 8px; vertical-align: middle;"><?= setting('name_' . locale()) ?>
    </a>
</header>
