<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.2.0
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">

<head>
    <?php $this->load->view('template/coreui/head'); ?>
</head>

<body class="c-app flex-row align-items-center">
   <?php $this->load->view('auth/login') ?>
   <?php $this->load->view('template/coreui/loadjs_auth')?>

</body>

</html>