<?php
//assets("");
?>

<!doctype html>
<html lang="en">
<head>
    <base target="_self">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <meta name="description" content="Product details page with collapsible sidebar">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Alpine.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#3b82f6",
                        secondary: "#1e40af",
                        success: "#10b981",
                        danger: "#ef4444",
                        warning: "#f59e0b"
                    }
                }
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="<?= assets("css/style.css") ?>">

</head>
<body class="min-h-screen bg-gray flex">
<?php include 'sidebar.view.php'; ?>

<div class="flex-1 flex flex-col">

    <?php require_once 'navbar.view.php';?>

    <?php if (hasError()) : ?>
        <script>
            toastr.error("<?=error()?>");
        </script>
    <?php endif; ?>

    <?php if (flushMessage()->has('success')) : ?>
        <script>
            toastr.error("<?=flushMessage()->get('success')?>");
        </script>
    <?php endif; ?>

    <main class="flex-1 container mx-auto px-4 py-8">
        {{content}}
    </main>

    <!--<div class="container-fluid">-->
    <!--    <div class="row">-->
    <!--        <main>-->
    <!--        </main>-->
    <!--    </div>-->
    <!--</div>-->
    <?php
    require_once 'footer.view.php';
    ?>

</div>
<!--
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script> -->

<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script src="<?=assets('js/script.js')?>"></script>
</body>
</html>
