<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo _project_complete_name_ ?> | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<? echo _lte_files_ ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<? echo _lte_files_ ?>dist/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<? echo _lte_files_ ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<? echo _lte_files_ ?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <!-- <a href="<? echo _lte_files_ ?>index2.html"><?php echo _project_complete_name_ ?></a> -->
      <!-- <img src="<?php echo MAINSITE . "assets/images/logo.png" ?>" style="height:150px"> -->
      <img src="<?php echo IMAGE . "logo.png" ?>" style="height:100px;width:auto;">
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"> Reset New Password</p>
        <?php echo $alert_message; ?>
        <?php echo form_open(MAINSITE_Admin . 'Login', array('method' => 'post', 'id' => '', 'style' => '', 'class' => '')); ?>
        <div class="input-group mb-3">
          <?php
          $attributes = array(
            'name' => 'password',
            'id' => 'password',
            'value' => set_value('password'),
            'class' => 'form-control',
            'placeholder' => "New Password",
            'type' => 'password',
            'required' => 'required'
          );
          echo form_input($attributes); ?>
          <?php //echo form_error('password'); ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <input type="hidden" name="token" id="token" value="<?= $token ?>">
          <input type="hidden" id="user_id" name="user_id" value="<?= $th_user_resetpwd_details[0]->user_fk ?>">

          <?php //echo form_error('username'); ?>

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-4">
          </div>
          <div class="col-4">
            <centre><button type="button" onclick="reset_password_fn()" name="login_btn" value="1"
                class="btn btn-primary btn-block">Reset</button></centre>
          </div>
          <div class="col-4">
          </div>
          <!-- /.col -->
        </div>
        <?php echo form_close() ?>
        <? /* ?>
<div class="social-auth-links text-center mb-3">
<p>- OR -</p>
<a href="#" class="btn btn-block btn-primary">
<i class="fab fa-facebook mr-2"></i> Sign in using Facebook
</a>
<a href="#" class="btn btn-block btn-danger">
<i class="fab fa-google-plus mr-2"></i> Sign in using Google+
</a>
</div>
<!-- /.social-auth-links -->
*/
        ?>
        <p class="message"></p>
        <!-- <p class="mb-1">
        <a href="<?= MAINSITE_Admin . 'forgot-password' ?>">Forgot password</a>
      </p> -->
        <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <? ?>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<? echo _lte_files_ ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<? echo _lte_files_ ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<? echo _lte_files_ ?>dist/js/adminlte.min.js"></script>

</body>

</html>
<script type="text/javascript">

  function reset_password_fn() {
    $('.message').html('');
    var password = $('#password').val();
    var token = $('#token').val();
    var user_id = $('#user_id').val();

    if (password != '') {

      $(".loader").css("display", "block");

      $.ajax({
        type: "post",
        url: '<?= MAINSITE_Admin ?>Login/save_new_password',
        dataType: "json",
        data: { 'password': password, 'token': token, 'user_id': user_id },
        success: function (result) {
          $(".loader").css("display", "none");

          if (result.status) {
            $('.message').css('color', 'green');
          } else {
            $('.message').css('color', 'red');
          }

          $('.message').html(result.message);



        }

      });



    }

    else {

      alert("Please Enter New Password");

      $('#password').focus();

    }

  }
</script>