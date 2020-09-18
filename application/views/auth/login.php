<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>Login</h1>
                        <p class="text-muted">Silahkan Masuk Untuk Melanjutkan</p>
                        <?php if($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                        <?php echo form_open('auth/check_user'); ?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text">
                                        <i class="fa fa-envelope"></i>
                                    </span></div>
                                <input class="form-control" name="username" type="email" placeholder="Username">
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend"><span class="input-group-text">
                                        <i class="fa fa-lock"></i>
                                </div>
                                <input class="form-control" name="password" type="password" placeholder="Password">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Login</button>
                                </div>
                                <!-- <div class="col-6 text-right">
                                    <button class="btn btn-link px-0" type="button">Forgot password?</button>
                                </div> -->
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <div>
                            <h2><?php echo APP_NAME ?></h2>
                            <p><?php echo APP_DESC ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>