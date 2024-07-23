<style>
  .container {
    padding: 2rem 0;
  }

  .card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    overflow: hidden;
  }

  .card-header {
    background: linear-gradient(to right, #4a00e0, #8e2de2);
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border-bottom: none;
    padding: 1.5rem;
  }

  .form-control {
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
  }

  .btn-primary {
    background: linear-gradient(to right, #4a00e0, #8e2de2);
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 2rem;
    font-weight: bold;
    letter-spacing: 0.05em;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
  }

  .employee-details {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
  }

  .profile-pic {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    margin: 0 auto 1rem;
    border: 3px solid #4a00e0;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
  }

  .employee-info h4 {
    color: #4a00e0;
    margin-bottom: 1rem;
  }

  .employee-info p {
    margin-bottom: 0.5rem;
  }
</style>
<?php echo $this->session->flashdata('alert_message'); ?>

<h1>Employee Status: <?= $employee_status ?></h1>
<h1>Employee Login Status: <?= $employee_login_status ?></h1>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">


      <div class="employee-details">
        <h3 class="text-center mb-4">Employee Details</h3>
        <?php if (!empty($user_employee_data->profile_image)) { ?>
          <img src="<?= _uploaded_files_ . 'user_employee/profile_image/' . $user_employee_data->profile_image ?>"
            alt="Employee Profile Picture" class="profile-pic d-block">
        <?php } else { ?>
          <img src="<?= _uploaded_files_ ?>no-img.png" alt="Employee Profile Picture" class="profile-pic d-block">
        <?php } ?>

        <div class="employee-info mt-4">
          <h4 class="text-center"><?= $user_employee_data->name ?></h4>
          <!-- <p><strong>Branch:</strong> <?= $employee_branch ?></p> -->
          <!-- <p><strong>Department:</strong> <?= $employee_department ?></p> -->
          <!-- <p><strong>Designation:</strong> <?= $employee_designation ?></p> -->
          <p><strong>Date of Birth:</strong> <?= date("d-F-Y", strtotime($user_employee_data->birthday)) ?></p>
          <p><strong>Joining Date:</strong> <?= date("d-F-Y", strtotime($user_employee_data->joining_date)) ?>
          </p>
          <p><strong>Address:</strong> <?= $user_employee_data->address ?></p>
        </div>
      </div>

      <?php if ($employee_status == "active"): ?>
        <?php if ($employee_login_status == "allowed_for_login"): ?>
          <div id="login-form-container" class="row justify-content-center mt-4">
            <div class="col-md-6">
              <div class="card" style="min-width:200px;">
                <div class="card-header">Employee Login</div>
                <div class="card-body">

                  <form method="post" action="<?= MAINSITE . 'ajax_user_employee_do_login' ?>" id="employee-login-form">

                    <div class="form-group">

                      <label for="attendance_login_image">Employee Image</label>
                      <input type="file" accept="image/*" name="attendance_login_image" id="attendance_login_image"
                        class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="login-button">login</button>
                  </form>
                </div>
              </div>



            </div>
          </div>
        <?php elseif ($employee_login_status == "allowed_for_logout"): ?>
          <div class="card" style="min-width:200px;">
            <div class="card-header">Employee Logout</div>
            <div class="card-body">

              <form method="post" action="<?= MAINSITE . 'ajax_user_employee_do_logout' ?>" id="employee-login-form">
                <div class="form-group">
                  <label for="attendance_logout_image">Employee Image</label>
                  <input type="file" accept="image/*" name="attendance_logout_image" id="attendance_logout_image"
                    class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" id="login-button">Logout</button>
              </form>
            </div>
          </div>
        <?php endif; ?>


      <?php endif; ?>
    </div>
  </div>
</div>



<script>
  $(document).ready(function () {
    $('#errorToast').toast();
  });

  const video = document.getElementById('video');
  const canvas = document.getElementById('canvas');
  const captureButton = document.getElementById('capture');
  const photoInput = document.getElementById('user_photo');
  const form = document.getElementById('employee-login-form');
  const noWebcamDialog = document.getElementById('no-webcam-dialog');
  const loginFormContainer = document.getElementById('login-form-container');

  // Request access to the webcam
  navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
      video.srcObject = stream;
      video.style.display = 'block';
      captureButton.style.display = 'inline-block';
      loginFormContainer.style.display = 'block';
    })
    .catch(error => {
      console.error('Error accessing webcam:', error);
      noWebcamDialog.style.display = 'block';
    });

  // Capture photo when button is clicked
  captureButton.addEventListener('click', () => {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convert the canvas to a data URL and set it as the value of the hidden input
    const photoDataUrl = canvas.toDataURL('image/png');
    photoInput.value = photoDataUrl;
  });

  // Prevent form submission if no photo is captured
  form.addEventListener('submit', (event) => {
    if (!photoInput.value) {
      event.preventDefault();
      alert('Please capture a photo before submitting the form.');
    }
  });
</script>