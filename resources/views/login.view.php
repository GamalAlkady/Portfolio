<?php setTitle('login');?>

<div class="container">
    <div class="row">
        <div class="col">
            <form action="/login" method="POST" class="mt-5">

                <?=setCsrf()?>

                <div class="mb-3">
                    <label for="exampleInputEmail" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text"> <?= errors('email')?> </div>
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword">
                    <div id="emailHelp" class="form-text"> <?= errors('password')?> </div>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>

                <a class="mx-5" href="/forgot-password">Forgot password?</a>
                <div>
                    <br>
                    <a class="" href="/register">Create an account</a>
                </div>
            </form>
        </div>
    </div>
</div>