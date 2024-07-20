<!DOCTYPE html>

<html lang="en">

<head>

  <title>Welcome to BSNL</title>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--===============================================================================================-->

  <link rel="icon" type="image/png" href="<?= MAINSITE_Files ?>images/icons/favicon.ico" />



  <link rel="stylesheet" type="text/css" href="<?= MAINSITE_Files ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">

  <!--===============================================================================================-->

  <link rel="stylesheet" type="text/css" href="<?= MAINSITE_Files ?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

  <!--===============================================================================================-->

  <link rel="stylesheet" type="text/css" href="<?= MAINSITE_Files ?>fonts/iconic/css/material-design-iconic-font.min.css">

  <!--===============================================================================================-->

  <link rel="stylesheet" type="text/css" href="<?= MAINSITE_Files ?>css/main.css">

  <!--===============================================================================================-->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body style="background-color: #999999;">



  <div class="limiter">

    <div class="container-login100">



      <div class="login100-more"></div>
      <!-- <div class="login100-more" style="background-image: url('<?= MAINSITE_Files ?>images/nature.jpg');"></div> -->



      <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">

        <div class="text-center"><img src="<?= MAINSITE_Files ?>images/logo.png" class="img-responsive" style="width:30%">



        </div>



        <div class="main_login">

          <div class=" container ">

            <div class="main_loginw">

              <?php echo $alert_message; ?>

              <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                  <div class="col-md-12 ">

                    <div class="row ">

                      <div class="col-md-12">

                        <div class="text-center">

                          <span class="login100-form-title p-b-59 text-center">

                            Sign In

                          </span>

                        </div>



                        <?php echo form_open(base_url(), array('method' => 'post', 'id' => '', 'style' => '', 'class' => 'login100-form validate-form')); ?>



                        <div class="row">

                          <div class="col-md-12">

                            <div class="wrap-input100 validate-input" data-validate="OTP is required">

                              <span class="label-input100">Membership ID</span>

                              <?php

                              $attributes = array(

                                'name' => 'am_no',

                                'id' => 'am_no',

                                'value' => set_value('am_no'),

                                'class' => 'input100',

                                'placeholder' => "Enter Your Membership ID.",

                                'autofocus' => 'autofocus',

                                'type' => 'text',

                                'required' => 'required'

                              );

                              echo form_input($attributes); ?>

                              <span class="focus-input100"></span>

                            </div>



                          </div>



                        </div>

                        <div class="row MobOTPField">

                          <div class="col-md-12">



                            <div class="wrap-input100 validate-input">

                              <span class="label-input100">Password</span>

                              <?php

                              $attributes = array(

                                'name' => 'password',

                                'id' => 'password',

                                'value' => set_value('password'),

                                'class' => 'input100',

                                'type' => 'password',

                                'placeholder' => 'Enter Password',

                                'required' => 'required'

                              );

                              echo form_input($attributes); ?>

                              <span class="focus-input100"></span>

                            </div>

                          </div>



                        </div><br>

                        <!-- <a class="resend_otp" style="cursor: pointer" id="otp_func" onclick="login_otp_func()">Click to get OTP</a>

<a class="resend_otp" id="otp_func_count" style="display:none" ></a>

<span id="resendotp" style="display:none;"> <a class="admin_align" onclick="getOTP()" style="cursor:pointer;">Resend OTP</a></span>
 -->


                        <div class="row">

                          <div class="col-md-5">

                            <div class="container-login100-form-btn">

                              <div class="wrap-login100-form-btn">

                                <div class="login100-form-bgbtn"></div>

                                <button type="submit" name="login_btn" value="1" class="login100-form-btn">Sign
                                  In</button>

                              </div>



                            </div>

                          </div>

                          <div class="col-md-7">

                            <ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">

                              <li class="nav-item btn-danger-style1" role="presentation  ">

                                <button class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30" id="pills-profile-tab1"
                                  data-bs-toggle="pill" data-bs-target="#pills-profile1" type="button" role="tab"
                                  aria-controls="pills-profile" aria-selected="false">Forgot Password <i
                                    class="fa fa-long-arrow-right m-l-5"></i></button>

                              </li>

                            </ul>

                          </div>



                        </div>

                        <?php echo form_close() ?>



                      </div>

                    </div>

                  </div>
                </div>

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                  <div class="col-md-12 loginbg">

                    <div class="text-center">

                      <span class="login100-form-title p-b-59 text-center">

                        Sign In

                      </span>

                    </div>

                  </div>



                </div>

                <div class="tab-pane fade" id="pills-profile1" role="tabpanel" aria-labelledby="pills-profile-tab">

                  <div class="col-md-12 loginbg">

                    <div class="text-center">

                      <span class="login100-form-title p-b-59 text-center">

                        Forgot Password

                      </span>

                    </div>

                    <form class="login100-form validate-form">







                      <div class="wrap-input100 validate-input" data-validate="Membership Id is required">

                        <span class="label-input100">Membership Id</span>

                        <input class="input100" type="text" name="username" id="username"
                          placeholder="Enter Membership Id...">

                        <span class="focus-input100"></span>

                      </div>


                      <div class="row">

                        <div class="col-md-6">

                          <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">

                              <div class="login100-form-bgbtn"></div>

                              <button class="login100-form-btn" type="button" onclick="forgot_password_func()">

                                Continue

                              </button>

                            </div>

                          </div>

                        </div>





                        <div class="offset-3 col-md-3">

                          <ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">



                            <li class="nav-item btn-danger-style1" role="presentation  ">

                              <button class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30" id="pills-profile-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">back<i
                                  class="fa fa-long-arrow-left m-l-5"></i></button>

                            </li>



                          </ul>

                        </div>
                        <h6 class="message"></h6>

                      </div>

                  </div>

                  </form>

                </div>



              </div>

            </div>









          </div>
        </div>



      </div>

    </div>

  </div>

  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>



    //clearInterval(myOTPTimer);

    var time_sec = 20;



    //var myOTPTimer = setInterval(resend_otp_time, 1000);



    function resend_otp_time() {

      $('#otp_func_count').show();

      time_sec = time_sec - 1;

      $('#otp_func_count').html('Resend OTP in ' + time_sec + ' Seconds.');

      if (time_sec == 0) {

        clearInterval(myOTPTimer);

        $('#otp_func').show();

        $('#otp_func_count').html('');

        $('#otp_func_count').hide();

        $('#otp_func').html('Resend OTP');

      }

    }



    function login_otp_func() {

      var username = $('#username').val();

      if (username != '') {

        $(".loader").css("display", "block");

        $.ajax({

          type: "POST",

          url: '<?= base_url() ?>Login/resend_otp',

          dataType: "json",

          data: { 'username': username },

          success: function (result) {



            $(".loader").css("display", "none");

            if (result.status) {

              $('.MobOTPField').show();

              time_sec = 20;

              $('#otp_func').hide();

              myOTPTimer = setInterval(resend_otp_time, 1000);

            }

            else {

              alert(result.message)

            }

          }

        });



      }

      else {

        alert("Please Enter Username");

        $('#username').focus();

      }

    }
    function forgot_password_func() {

      var username = $('#username').val();

      if (username != '') {
        $('.message').text('');
        $(".loader").css("display", "block");

        $.ajax({

          type: "POST",

          url: '<?= base_url() ?>forgot_password',

          dataType: "json",

          data: { 'username': username },

          success: function (result) {

            $(".loader").css("display", "none");

            if (result) {

              if (result.status) {
                $('.message').css('color', 'white');
              } else {
                $('.message').css('color', 'red');
              }

              $('.message').text(result.message);
            }

            else {

              alert(result.message)

            }

          }

        });



      }

      else {

        alert("Please Enter Username");

        $('#username').focus();

      }

    }





  </script>

</body>

</html>