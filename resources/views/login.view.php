<?php setTitle(__("login")); ?>

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1"><b><?=__('profolio')?></b></a>
        </div>
        <div class="card-body">
<!--            <p class="login-box-msg">Sign in to start your session</p>-->

            <form action="<?=route('login')?>" method="post">
                <?php echo setCsrf() ?>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="<?= __("email") ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="<?= __("password") ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                <?= __("remember_me") ?>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="">
                        <button type="submit" class="btn btn-primary btn-block"><?= __("sign_in") ?></button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center mt-2 mb-3 d-none">
                <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> <?=__('sign_in_using_facebook')?>
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> <?=__('sign_in_using_google')?>
                </a>
            </div>
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="forgot-password.html"><?=__('forgot_password')?></a>
            </p>
<!--            <p class="mb-0">-->
<!--                <a href="register.html" class="text-center">Register a new membership</a>-->
<!--            </p>-->
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
