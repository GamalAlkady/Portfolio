<div>
    <!-- Language Switcher -->
    <div class="language-switcher">
        <?php if(locale()=='en'):?>
        <a href="<?= route('language.switch', ['locale' => 'ar']) ?>" 
           class="<?= locale() === 'ar' ? 'active' : '' ?>"
           title="<?= __('arabic') ?>"
           aria-label="<?= __('switch_to_arabic') ?>">
            ع
        </a>
        <?php else:?>
        <a href="<?= route('language.switch', ['locale' => 'en']) ?>" 
           class="<?= locale() === 'en' ? 'active' : '' ?>"
           title="<?= __('english') ?>"
           aria-label="<?= __('switch_to_english') ?>">
            EN
        </a>
        <?php endif; ?>
    </div>
</div>       