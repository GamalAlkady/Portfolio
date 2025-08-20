<section class="footer">

    <div class="box-container">

        <div class="box">
            <h3><?=setting('name_'.locale()).' ' . __('portfolio')?></h3>
            <p><?=__('thanks_message')?></p>
        </div>

        <div class="box">
            <h3><?=__('quick_links')?></h3>
            <a href="<?=isset($routeName)?route($routeName):''?>#home"><i class="fas fa-chevron-circle-right"></i> <?=__('home')?></a>
            <a href="<?=isset($routeName)?route($routeName):''?>#about"><i class="fas fa-chevron-circle-right"></i> <?=__('about_me')?></a>
            <a href="<?=isset($routeName)?route($routeName):''?>#education"><i class="fas fa-chevron-circle-right"></i> <?=__('education')?></a>
            <a href="<?=isset($routeName)?route($routeName):''?>#skills"><i class="fas fa-chevron-circle-right"></i> <?=__('skills')?></a>
            <a href="<?=isset($routeName)?route($routeName):''?>#experience"><i class="fas fa-chevron-circle-right"></i> <?=__('experience')?></a>
            <a href="<?=isset($routeName)?route($routeName):''?>#contact"><i class="fas fa-chevron-circle-right"></i> <?=__('contact')?></a>
        </div>

        <div class="box">
            <h3><?=__('contact_info')?></h3>
            <p><i class="fas fa-phone"></i><span style="padding:0 1rem;"><?=setting('phone')?></span></p>
            <p><i class="fas fa-envelope"></i><span  style="padding:0 1rem;"><?=setting('email')?></span></p>
            <p><i class="fas fa-map-marked-alt"></i><span style="padding:0 1rem;"><?=setting('location_'.locale())?></span></p>
            <div class="share">

                <?php if(!empty(setting('email'))){?><a href="mailto:<?=setting('email')?>" class="fas fa-envelope" aria-label="Mail" target="_blank"></a><?php }?>
               <?php if(!empty(setting('linkedin_url'))){?> <a href="<?=setting('linkedin')?>" class="fab fa-linkedin" aria-label="LinkedIn"target="_blank"></a><?php }?>
                <?php if(!empty(setting('github_url'))){?><a href="<?=setting('github')?>" class="fab fa-github" aria-label="GitHub" target="_blank"></a><?php }?>
                <?php if(!empty(setting('instagram_url'))){?><a href="<?=setting('instagram')?>" class="fab fa-instagram" aria-label="Instagram" target="_blank"></a><?php }?>
               <?php if(!empty(setting('facebook_url'))){?> <a href="<?=setting('facebook')?>" class="fab fa-facebook" aria-label="Facebook" target="_blank"></a><?php }?>
               <?php if(!empty(setting('twitter_url'))){?> <a href="<?=setting('twitter')?>" class="fab fa-twitter" aria-label="Twitter" target="_blank"></a><?php }?>
              <?php if(!empty(setting('youtube_url'))){?>  <a href="<?=setting('youtube')?>" class="fab fa-youtube" aria-label="Youtube" target="_blank"></a><?php }?>
                
            </div>
        </div>
    </div>

    <h1 class="credit"><?=__('designed_by')?> <i class="fa fa-heart pulse"></i> <a href="https://wa.me/message/RWP5KH55UTUUF1"><?=setting('name_'.locale())?></a></h1>

</section>