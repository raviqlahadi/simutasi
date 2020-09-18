<base href="./">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="description" content="<?php echo APP_DESC ?>" />
<meta name="author" content="<?php echo APP_AUTHOR ?>">

<title><?php
        if (!isset($page_title) || $page_title == null) {
            echo APP_NAME;
        } else {
            echo strip_tags($page_title);
        }
        ?></title>

<link rel="shortcut icon" type="image/png" href="<?php echo base_url() . FAVICON_IMAGE; ?>" />
<!-- Main styles for this application-->
<link href="<?php echo base_url() .  COREUI_PATH  ?>css/coreui.min.css" rel="stylesheet">
<link href="<?php echo base_url() .  FONTAWESOME_PATH  ?>css/all.min.css" rel="stylesheet">

<!-- Costum Style -->
<link rel="stylesheet" href="<?php echo base_url() . '/assets/css/style.css'; ?>" />
<?php
if (isset($view_library) && array_search('datatable', $view_library) !== false) {
?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . '/assets/' ?>DataTables/datatables.min.css" />

<?php
}
?>
<?php
if (isset($view_library) && array_search('ckeditor', $view_library) !== false) {
    echo '<script src="' . base_url() . 'assets/node_modules/ckeditor4/ckeditor.js"></script>';
}
?>