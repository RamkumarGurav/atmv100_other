<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Employee Login</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
   #video {
      width: 320px;
      height: 240px;
      border: 1px solid black;
      display: none;
   }

   #canvas {
      display: none;
   }
</style>

<body>
   <div class="container mt-5">
      <div id="no-webcam-dialog" style="display:none;">
         <div class="alert text-center alert-danger alert-dismissible">
            <i class="icon fas fa-ban"></i>
            Your computer does not have a webcam or access to the webcam is denied.
         </div>
      </div>
      <div id="login-form-container" class="row justify-content-center" style="display:none;">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Employee Login</div>
               <div class="card-body">
                  <?php echo $this->session->flashdata('alert_message'); ?>
                  <form method="post" action="<?= MAINSITE . 'employee-login' ?>" id="employee-login-form">
                     <div class="form-group">
                        <label for="user_employee_custom_id">Employee ID</label>
                        <input type="text" name="user_employee_custom_id" id="user_employee_custom_id"
                           class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label for="user_photo">Click Photo</label>
                        <video id="video" autoplay></video>
                        <button type="button" id="capture" style="display:none;">Capture Photo</button>
                        <canvas id="canvas"></canvas>
                        <input type="hidden" name="user_photo" id="user_photo" required>
                     </div>
                     <button type="submit" class="btn btn-primary" id="login-button">Login</button>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <?php if (!empty($user_employee_with_birthday)): ?>
         <div class="row justify-content-center mt-4">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">Employees Celebrating Birthdays Today</div>
                  <div class="card-body">
                     <div class="row">
                        <?php foreach ($user_employee_with_birthday as $item): ?>
                           <div class="col-md-4">
                              <div class="card mb-3">
                                 <img class="img-circle"
                                    src="<?= _uploaded_files_ . 'user_employee/profile_image/' . $item->profile_image ?>"
                                    alt="Profile Image">
                                 <div class="card-body">
                                    <h5 class="card-title"><?= $item->name ?></h5>
                                    <p class="card-text">Happy Birthday!</p>
                                 </div>
                              </div>
                           </div>
                        <?php endforeach; ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <?php endif; ?>
   </div>
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

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