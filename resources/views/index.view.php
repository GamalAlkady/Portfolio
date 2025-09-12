<?php define('TYPE_USER','user'); ?>

<?php

use App\Models\Skills;

setTitle("Home"); ?>
<!-- navbar starts -->

<!-- navbar ends -->


<!-- hero section starts -->
<section class="home" id="home">
    <div id="particles-js"></div>

    <div class="content">

        <!-- <h2>Hi There,<br /> I'm Mohammed Al-Qadi <span></span></h2> -->
        <p><?= setting('site_description_' . locale()) ?><span class="typing-text"></span></p>

        <a href="<?= route('showProjects') ?>" class="btn"><span><?= __("view_portfolio") ?></span>
            <i class="fa fa-arrow-circle-<?= (locale() == 'ar' ? 'left' : 'right') ?>"></i>
        </a>
        <div class="socials">
            <ul class="social-icons">
                <!-- <li><a class="linkedin" aria-label="LinkedIn" href="https://www.linkedin.com/in/engalqadi/"
                        target="_blank"><i class="fab fa-linkedin"></i></a></li>
                <li><a class="github" aria-label="GitHub" href="https://github.com/M-Alshalfi/" target="_blank"><i
                            class="fab fa-github"></i></a></li>
                <li><a class="instagram" aria-label="Instagram" href="https://www.instagram.com/techno_shalfof/"
                        target="_blank"><i class="fab fa-instagram" target="_blank"></i></a></li>
                <li><a class="dev" aria-label="Dev" href="https://wa.me/message/RWP5KH55UTUUF1" target="_blank"><i class="fab fa-whatsapp"></i></a></li>

                <li><a class="dev" aria-label="Dev" href="tel:+1234567890"><i class="fa-solid fa-phone"></i></a></li> -->

                <?php if (!empty(setting('phone'))) { ?><li><a href="tel:<?= setting('phone') ?>" class="whatsapp fab fa-whatsapp" aria-label="WhatsApp" target="_blank"></a></li><?php } ?>
                <?php if (!empty(setting('linkedin_url'))) { ?><li><a href="<?= setting('linkedin') ?>" class="linkedin fab fa-linkedin" aria-label="LinkedIn" target="_blank"></a></li><?php } ?>
                <?php if (!empty(setting('github_url'))) { ?><li><a href="<?= setting('github') ?>" class="github fab fa-github" aria-label="GitHub" target="_blank"></a></li><?php } ?>
                <?php if (!empty(setting('instagram_url'))) { ?><li><a href="<?= setting('instagram') ?>" class="instagram fab fa-instagram" aria-label="Instagram" target="_blank"></a></li><?php } ?>
                <?php if (!empty(setting('facebook_url'))) { ?><li><a href="<?= setting('facebook') ?>" class="facebook fab fa-facebook" aria-label="Facebook" target="_blank"></a></li><?php } ?>
                <?php if (!empty(setting('twitter_url'))) { ?><li><a href="<?= setting('twitter') ?>" class="twitter fab fa-twitter" aria-label="Twitter" target="_blank"></a></li><?php } ?>
                <?php if (!empty(setting('youtube_url'))) { ?><li><a href="<?= setting('youtube') ?>" class="youtube fab fa-youtube" aria-label="Youtube" target="_blank"></a></li><?php } ?>
                <?php if (!empty(setting('email'))) { ?><li><a href="mailto:<?= setting('email') ?>" class="email fas fa-envelope" aria-label="Mail" target="_blank"></a></li><?php } ?>
            </ul>
        </div>
    </div>
    <div class="image">
        <img draggable="false" class="tilt" src="<?= assets(setting('home_image'), 'images/logo.png') ?>" alt="">
    </div>
</section>

<section class="about" id="about">
    <?php 
    // dd(TYPE_USER)
    ?>
    <h2 class="heading"><i class="fas fa-user-alt"></i><span><?= __("about_me") ?></span></h2>

    <div class="row">

        <div class="image">
            <img draggable="false" class="tilt" src="<?= assets(setting('about_image'), 'images/hero.png') ?>" alt="">
        </div>
        <div class="content">
            <?php echo setting('description_' . locale()) ?>

            <div class="box-container">
                <!-- <div class="box">
                    <p><span> age: </span> 20</p>
                    <p><span> phone : </span> +91 XXX-XXX-XXXX</p>
                  </div> -->
                <div class="box">
                    <p><span> <?= __('email') ?> : </span> <?php echo setting('email') ?></p>
                    <p><span> <?= __('address') ?> : </span> <?php echo setting('location_' . locale()) ?></p>
                    <p><span> <?= __('phone') ?> : </span> <?php echo setting('phone') ?></p>

                </div>
            </div>

            <div class="resumebtn">
                <a href="<?= assets(setting('cv_pdf')) ?>" target="_blank" class="btn"><span><?= __("view_resume") ?></span>
                    <i class="fas fa-chevron-<?= (locale() == 'ar' ? 'left' : 'right') ?>"></i>
                </a>
            </div>

        </div>
    </div>
</section>
<!-- about section ends -->


<!-- education section starts -->
<section class="education " id="education">

    <h1 class="heading"><i class="fas fa-graduation-cap"></i><span><?= __('my_education') ?></span></h1>
    <div class="box-container">
        <div class="box">
            <div class="image" style="max-height: 176px;max-width: 172px;">
                <img draggable="false" src="<?= assets('images/college.jpg') ?>" alt="">
            </div>
            <div class="content">
                <?= setting('education_' . locale()) ?>
            </div>
        </div>

    </div>
</section>
<!-- education section ends -->

<!-- education section starts -->
<section class="education exp" id="experience">
    <h1 class="heading"><i class="fas fa-award"></i><span><?= __('experience') ?></span></h1>
    <div class="box-container">
        <div class="box">

            <div class="content">
                <?= setting('experience_' . locale()) ?>
            </div>
        </div>

    </div>
</section>

<!-- featured certificates section starts -->
<?php if (!empty($featuredCertificates)): ?>
    <?php includeView('components/certificates-section.view', compact('featuredCertificates')) ?>
<?php endif; ?>
<!-- featured certificates section ends -->


<?php if (count($skills) > 0): ?>
    <!-- experience section starts -->
    <section class="skill" id="skill">

        <h2 class="heading"><i class="fas fa-laptop-code" style="margin-inline-end: 5px;"></i><span><?= __('skills_abilities') ?></span></h2>

        <div class="timeline">
            <?php /** @var array $skills */
            for ($i = 0; $i < count($skills); $i++): ?>
                <div class="container <?= ($i % 2) ? 'left' : 'right' ?>">
                    <div class="content">
                        <div class="tag">
                            <h4><?php echo $skills[$i]['description'] ?></h4>
                        </div>
                        <div class="desc">
                        </div>
                    </div>
                </div>

            <?php endfor; ?>


        </div>

    </section>
    <!-- experience section ends -->
<?php endif; ?>

<!-- contact section starts -->
<section class="contact" id="contact">

    <h2 class="heading"><i class="fas fa-headset"></i><span><?= __('get_in_touch') ?></span></h2>

    <div class="container">
        <div class="content">
            <div class="image-box">
                <img draggable="false" src="<?= assets(setting('contact_image'), 'images/contact1.png') ?>" alt="">
            </div>
            <form action="<?= route('sendEmail') ?>" id="contact-form" method="post">
                <?php echo setCsrf() ?>
                <div class="form-group">
                    <div class="field">
                        <input type="text" name="name" placeholder="Name" required>
                        <i class='fas fa-user'></i>
                    </div>
                    <div class="field">
                        <input type="text" name="email" placeholder="Email" style="text-transform: none" required>
                        <i class='fas fa-envelope'></i>
                    </div>
                    <div class="field">
                        <input type="text" name="phone" placeholder="Phone">
                        <i class='fas fa-phone-alt'></i>
                    </div>
                    <div class="message">
                        <textarea placeholder="Message" name="message" required></textarea>
                        <i class="fas fa-comment-dots"></i>
                    </div>
                </div>
                <div class="button-area">
                    <button type="submit" name="send"> <?= __('submit') ?> <i class="fa fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- contact section ends -->


<!-- footer section starts -->

<!-- footer section ends -->



    <!-- particle.js links -->
    <!-- <script src="<?= assets('js/particles.min.js') ?>"></script> -->
    <!-- <script src="<?= assets('js/app.js') ?>"></script> -->
<!-- typed.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.5/typed.min.js"
    integrity="sha512-1KbKusm/hAtkX5FScVR5G36wodIMnVd/aP04af06iyQTkD17szAMGNmxfNH+tEuFp3Og/P5G32L1qEC47CZbUQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // <!-- typed js effect starts -->
    var strings = "<?= setting('site_keywords_' . locale()) ?>";
    strings = strings.replace(/،/g, ',');
    strings = strings.split(',');
    var typed = new Typed(".typing-text", {
        strings: strings,
        loop: true,
        typeSpeed: 50,
        backSpeed: 25,
        backDelay: 500,
        showCursor: false, // Hide cursor
    });
    // <!-- typed js effect ends -->
</script>