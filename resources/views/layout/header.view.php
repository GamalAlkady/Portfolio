<header>
    <a href="<?= isset($routeName) ? route($routeName) : '' ?>#" class="logo">
        <img src="<?= assets('images/logo.svg') ?>" alt="V2 Logo" style="height: 35px; width: auto; margin-inline-end: 8px; vertical-align: middle;"><?=setting('name_'.locale())?>
    </a>

    <div id="menu" class="fas fa-bars"></div>
    <nav class="navbar">
        <ul>
            <li><a class="active" href="#home"><?= __('home') ?></a></li>
            <li><a href="#about"><?= __('about_me') ?></a></li>
            <?php if(!empty(setting('education_'.locale()))): ?><li><a href="#education"><?= __('education') ?></a></li><?php endif; ?>
            <?php if(!empty(setting('experience_'.locale()))): ?><li><a href="#experience"><?= __('experience') ?></a></li><?php endif; ?>
            <?php if (!empty($featuredCertificates)): ?><li><a href="#certificate"><?= __('certificates') ?></a></li><?php endif; ?>
            <?php if(count($skills)>0):?> <li><a href="#skill"><?= __('skills') ?></a></li><?php endif; ?>
            <li><a href="#contact"><?= __('contact') ?></a></li>
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