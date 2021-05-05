<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/public/root.css">
  <?php 
  if(isset($custom_css_links))
  { 
    foreach ($custom_css_links as $key => $css_file_name) 
    {
      echo '<link rel="stylesheet" href="/public/assets/css/' . $css_file_name . '.css">';
    }; 
  }
  ?>
  <title><?= $title ?></title>
</head>
<body>
<?php $current_url = uri_string(); ?>

<?php if($current_url !== 'admin/login'): ?>
  <div class="container-lg">
  <div class="row m-0 p-0">
    <div class="col-md-1 d-flex flex-column nav-bar p-0">
      <br/>
      <a href="/" class="<?= $current_url === '' ? 'active' : ''; ?>" >Dashboard</a>
      <a href="/admin/company/0" class="<?= $current_url === 'admin/company/0' ? 'active' : ''; ?>" >Company</a>
      <a href="/admin/employee/0" class="<?= $current_url === 'admin/employee/0' ? 'active' : ''; ?>" >Employee</a>
      <a href="/logout" class="lout">Logout</a>
    </div>
    <div class="col-md-11 right-panel">
<?php endif; ?>
