<?php
//assets("");
?>

<!doctype html>
<html lang="<?=locale()?>" dir="<?=(locale()=='en'?'ltr':'rtl')?>">
<head>
    <base target="_self">
    <meta charset="UTF-8">
<!--    <meta name="csrf-token" content="--><?php //echo getCsrf() ?><!--">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=getTitle()?></title>
    <meta name="description" content="Responsive sidebar with navbar using Bootstrap 5">
    <?php  include_once 'include_top.php'?>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="<?=assets('images/logo.png')?>" alt="AdminLTELogo" height="60" width="60">
    </div> -->
<?php if (flushMessage()->has('success')) : ?>
    <script>toastr.success("<?php echo htmlspecialchars(flushMessage()->get('success')); ?>")</script>
<?php endif; ?>

<?php if (flushMessage()->has('error')) : ?>
    <script>toastr.error("<?php echo htmlspecialchars(flushMessage()->get('error')); ?>")</script>
<?php endif; ?>


    <?php require_once 'navbar.view.php'; ?>
     <?php include 'sidebar.view.php'; ?>

<!--    <div class="container-fluid">-->
<!--    <div class="row">-->
<!--        <main id="content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">-->
            {{content}}
<!--        </main>-->
<!--    </div>-->
<!--</div>-->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
<?php
require_once 'footer.view.php';
?>
</div>

<?php include_once 'include_bottom.php'?>

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     const sidebarToggle = document.getElementById('sidebarToggle');
    //     const sidebar = document.getElementById('sidebar');
    //     const content = document.getElementById('content');
    //
    //     sidebarToggle.addEventListener('click', function() {
    //         sidebar.classList.toggle('active');
    //         content.classList.toggle('active');
    //     });
    // });
</script>
</body>
</html>
