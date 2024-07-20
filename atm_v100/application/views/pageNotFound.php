<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page Not Found</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <?php /*?><link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"><?php */ ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <?php /*?>  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css"><?php */ ?>

  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet"
    href="<?= _lte_files_ ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/pace-progress/themes/black/pace-theme-flat-top.css">
  <link rel="stylesheet" href="<?= _lte_files_ ?>dist/css/custome.css">
  <link rel="stylesheet" href="<?= _lte_files_ ?>css/jquery-ui-12.min.css">
  <script src="<?= _lte_files_ ?>plugins/jquery/jquery.min.js"></script>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= _lte_files_ ?>plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= _lte_files_ ?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <?php /*?><link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"><?php */ ?>
  <style type="text/css">
    #example1 thead th {
      position: sticky;
      top: 56px;
      background-color: #fff;
    }
  </style>

</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;paddingTop:100px;">



  <div class="container text-center my-auto">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-6">
        <img src="<?= IMAGE ?>page_not_found.jpg" alt="404 Not Found" class="img-fluid mb-4" style="max-width: 80%;">
      </div>
      <div class="col-md-6">
        <h1 style="font-size: 3.5rem; font-weight: bold;">Oops!</h1>
        <p style="font-size: 2.25rem;">We can't seem to find the page you're looking for.</p>
        <p style="font-size: 2rem;">The page might have been removed, had its name changed, or is temporarily
          unavailable.</p>
        <!-- <a class="btn btn-primary btn-lg mt-4" href="<?= MAINSITE ?>" style="font-size: 1.2rem;">Go to Homepage</a> -->
      </div>
    </div>
  </div>



</body>

</html>