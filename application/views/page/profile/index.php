<maim class="c-main">
    <div class="container-fluid">
        <div class="ui-view">
            <div>
                <div class="fade-in">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    Profile
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="card bg-white p-2 py-5 text-center" style="min-height:100px;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4><?php echo ucwords($user_profile->username) ?></h4>
                                                        <p><span class="badge badge-primary"><?php echo ucwords($user_profile->level) ?></span></p>
                                                        <p class="px-3">
                                                            <i class="text-info fa fa-envelope"></i> <?php echo ($user_profile->email) ?> |
                                                            <i class="text-info fa fa-phone"></i> <?php echo ucwords($user_profile->phone) ?> |
                                                            <i class="text-info fa fa-venus-mars"></i> <?php echo ucwords($user_profile->gender) ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-12">
                                                        <a href="<?php echo site_url('profile/edit/' . $user_profile->user_id) ?>" class="btn btn-primary btn-block text-white"><i class="c-icon fa fa-user-edit"></i>&nbsp; Edit Profile</a>
                                                        <a href="<?php echo site_url('user/password/' . $user_profile->user_id) ?>" class="btn btn-primary btn-block text-white"> <i class="c-icon fa fa-lock"></i>&nbsp; Ganti Password</a>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <strong class="text-info">Riwayat Aktifitas</strong class="text-info">
                                            <hr>
                                            <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</maim>