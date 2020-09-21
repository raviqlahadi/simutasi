<main class="c-main">
    <div class="container-fluid">
        <div id="ui-view">
            <div>
                <div class="fade-in">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php echo $page_title ?>
                                    <a class="btn btn-warning text-white float-right text-white" href="<?php echo $page_url; ?>"><i class="fa fa-arrow-circle-left"></i> Back</a>

                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-12 px-5">
                                            <?php $this->load->view($page_current . '/form_password') ?>
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
</main>