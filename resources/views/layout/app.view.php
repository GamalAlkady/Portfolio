<!doctype html>
<html lang="<?= locale() ?>" dir="<?= (locale() == 'en' ? 'ltr' : 'rtl') ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getTitle() ?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Google Fonts: Cairo (Arabic) & Roboto (English) -->
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@330;400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <style>
            html[dir="rtl"],
            .body {
                font-family: 'Cairo', Arial, sans-serif !important;
            }
            html[dir="ltr"],
            .body {
                font-family: 'Roboto', Arial, sans-serif !important;
            }
        </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Favicon -->
    <link id='favicon' rel="shortcut icon" href="<?= assets('images/logo.svg') ?>" type="image/x-png">

    <link rel="stylesheet" href="<?= assets('css/home.css') ?>">
    <link rel="stylesheet" href="<?= assets('plugins/summernote/summernote-bs4.min.css') ?>">

    <script src="<?= assets('js/utils.js') ?>"></script>
</head>

<body>
    <?php
    if (isset($routeName))
        require_once 'header.view.php';
    else
        require_once 'header2.view.php';

    ?>
    <?php if (flushMessage()->has('success')) : ?>
        <script>
            toastr.success("<?php echo htmlspecialchars(flushMessage()->get('success')); ?>")
        </script>
    <?php endif; ?>

    <?php if (flushMessage()->has('error')) : ?>
        <script>
            toastr.error("<?php echo htmlspecialchars(flushMessage()->get('error')); ?>")
        </script>
    <?php endif; ?>
    <main>
        {{content}}
    </main>

    <?php require_once 'footer.view.php'; ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <!-- particle.js links -->
    <!-- <script src="<?= assets('js/particles.min.js') ?>"></script> -->
    <!-- <script src="<?= assets('js/app.js') ?>"></script> -->

    <!-- vanilla tilt.js links -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"
        integrity="sha512-SttpKhJqONuBVxbRcuH0wezjuX+BoFoli0yPsnrAADcHsQMW8rkR84ItFHGIkPvhnlRnE2FaifDOUw+EltbuHg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- scroll reveal anim -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>

    <!-- ==== ALL MAJOR JAVASCRIPT CDNS ENDS ==== -->

    <script src="<?= assets('js/script.js') ?>"></script>
</body>

</html>