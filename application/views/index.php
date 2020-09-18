<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('template/coreui/head') ?>
</head>

<body class="c-app">
    <?php $this->load->view('template/coreui/sidebar')?>
    <div class="c-wrapper c-fixed-components">
        <?php $this->load->view('template/coreui/header')?>
        <div class="c-body">
            <?php $this->load->view($page_content) ?>
            <?php $this->load->view('template/coreui/footer') ?>

        </div>
    </div>
   <?php $this->load->view('template/coreui/loadjs_app')?>
</body>

</html>