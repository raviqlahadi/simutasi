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
                                    <a class="btn btn-warning text-white float-right" href="<?php echo $page_url . '/create'; ?>"><i class="fa fa-plus"></i> New Data</a>
                                    <button class="btn btn-warning text-white mr-1 float-right" data-toggle="collapse" type="button" data-target="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseSearch">
                                        <i class="fa fa-search"></i>
                                    </button>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="collapse" id="collapseSearch">
                                                <form action="" method="get">
                                                    <div class="input-group pb-3">
                                                        <input class="form-control" id="search" type="text" name="search" placeholder="Search" required>
                                                        <span class="input-group-append">
                                                            <a class="btn btn-info" href="<?php echo $page_url; ?>"><i class="fa fa-sync-alt"></i></a>
                                                            <button class="btn btn-warning text-white" type="submit">Search</button>
                                                        </span>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                                            <?php $this->load->view($page_current . '/table') ?>
                                        </div>
                                    </div>

                                </div>
                                <?php
                                if ($pagination != false) {
                                    echo  '<div class="card-footer">
                                                    ' . $pagination . '
                                                </div>';
                                }
                                ?>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
<?php
if ($this->input->get('search') != null) {
?>
    <script>
        let collapseSearch = document.getElementById('collapseSearch');
        let searchInput = document.getElementById('search');

        collapseSearch.classList.add('show');
        search.value = '<?php echo $this->input->get('search') ?>';
    </script>
<?php
}
?>