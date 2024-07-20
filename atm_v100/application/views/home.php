<style>
   body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
   }

   .container {
      padding-top: 50px;
      padding-bottom: 50px;
   }

   .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: all 0.3s ease;
   }

   .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
   }

   .card-header {
      background: linear-gradient(60deg, #1e3c72 0%, #2a5298 100%);
      color: white;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
   }

   .btn-custom {
      width: 200px;
      border-radius: 50px;
      text-transform: uppercase;
      font-weight: bold;
      letter-spacing: 1px;
      transition: all 0.3s ease;
   }

   .btn-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
   }

   .btn-primary {
      background: linear-gradient(60deg, #1e3c72 0%, #2a5298 100%);
      border: none;
   }

   .btn-secondary {
      background: linear-gradient(60deg, #2C3E50 0%, #4CA1AF 100%);
      border: none;
   }

   .birthday-card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s ease;
   }

   .birthday-card:hover {
      transform: translateY(-5px) rotate(2deg);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
   }

   .img-circle {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      margin: 20px auto 10px;
      border: 5px solid #f8f9fa;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
   }

   .birthday-card:hover .img-circle {
      transform: scale(1.1);
   }

   .confetti {
      position: absolute;
      width: 10px;
      height: 10px;
      background-color: #f2d74e;
      opacity: 0.7;
      animation: confetti 5s ease-in-out infinite;
   }

   @keyframes confetti {
      0% {
         transform: translateY(0) rotateZ(0deg);
      }

      100% {
         transform: translateY(100vh) rotateZ(720deg);
      }
   }
</style>
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

   .birthday-section {
      background: white;
      border-radius: 1rem;
      padding: 2rem;
      margin-top: 2rem;
   }

   .birthday-card {
      background: linear-gradient(45deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%);
      border-radius: 1rem;
      overflow: hidden;
      transition: all 0.3s ease;
   }

   .birthday-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
   }

   .img-circle {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      margin: 1rem auto;
      border: 3px solid white;
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
   }
</style>
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-6">
         <div class="card mb-4">
            <div class="card-header text-center">
               <h3 class="mb-0"><i class="fas fa-user-circle mr-2"></i>Employee Attendance</h3>
            </div>
            <div class="card-body p-4">
               <?php echo $this->session->flashdata('alert_message'); ?>
               <form method="post" action="<?= MAINSITE ?>">
                  <div class="form-group">
                     <label for="user_employee_custom_id"><i class="fas fa-id-badge mr-2"></i>Employee
                        ID</label>
                     <input type="text" name="user_employee_custom_id" id="user_employee_custom_id" class="form-control"
                        required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block mt-4">
                     <i class="fas fa-sign-in-alt mr-2"></i>continue
                  </button>
               </form>
            </div>
         </div>
      </div>
   </div>


</div>