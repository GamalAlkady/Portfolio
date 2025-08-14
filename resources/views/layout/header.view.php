<header>
    <a href="<?= isset($routeName) ? route($routeName) : '' ?>#" class="logo">
        <img src="<?= assets('images/logo.svg') ?>" alt="V2 Logo" style="height: 35px; width: auto; margin-right: 8px; vertical-align: middle;"> Mohammed Al-Qadi
    </a>

    <div id="menu" class="fas fa-bars"></div>
    <nav class="navbar">
        <ul>
            <li><a class="active" href="<?= isset($routeName) ? route($routeName) : '' ?>#home"><?= __('home') ?></a></li>
            <li><a href="<?= isset($routeName) ? route($routeName) : '' ?>#about"><?= __('about') ?></a></li>
            <li><a href="<?= isset($routeName) ? route($routeName) : '' ?>#education"><?= __('education') ?></a></li>
            <li><a href="<?= isset($routeName) ? route($routeName) : '' ?>#experience"><?= __('experience') ?></a></li>
            <li><a href="<?= isset($routeName) ? route($routeName) : '' ?>#skill"><?= __('skills') ?></a></li>
            <li><a href="<?= isset($routeName) ? route($routeName) : '' ?>#contact"><?= __('contact') ?></a></li>
            <li>
                <!-- Language Switcher -->
                <div class="language-switcher">
                    <?php 
                    if(locale()=='en'):
                    ?>
                    <a href="<?= route('language.switch', ['locale' => 'ar']) ?>"
                        class="<?= locale() === 'ar' ? 'active' : '' ?>"
                        title="<?= __('arabic') ?>"
                        aria-label="<?= __('switch_to_arabic') ?>">
                        AR
                    </a>
                    <?php else: ?>
                    <a href="<?= route('language.switch', ['locale' => 'en']) ?>"
                        class="<?= locale() === 'en' ? 'active' : '' ?>"
                        title="<?= __('english') ?>"
                        aria-label="<?= __('switch_to_english') ?>">
                        EN
                    </a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </nav>
</header>