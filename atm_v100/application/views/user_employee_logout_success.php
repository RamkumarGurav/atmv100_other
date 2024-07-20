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

  .profile-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 5px solid #fff;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    margin: 0 auto 1rem;
  }

  .employee-name {
    font-size: 1.5rem;
    font-weight: bold;
    color: #4a00e0;
  }

  .login-time {
    font-size: 1.1rem;
    color: #6c757d;
  }

  .btn-custom {
    background: linear-gradient(to right, #4a00e0, #8e2de2);
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 2rem;
    font-weight: bold;
    letter-spacing: 0.05em;
    transition: all 0.3s ease;
    color: white;
  }

  .btn-custom:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
  }
</style>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card text-center">
        <div class="card-header">
          <h3 class="mb-0"><i class="fas fa-check-circle mr-2"></i>Logout Successful</h3>
        </div>
        <div class="card-body p-5">
          <img src="<?= _uploaded_files_ . 'user_employee/profile_image/' . $attendance_data->profile_image ?>"
            alt="<?= $attendance_data->name ?>'s Profile" class="profile-img">
          <h4 class="employee-name mt-3"><?= $attendance_data->name ?></h4>
          <p class="logout-time mb-4">
            <i class="fas fa-clock mr-2"></i>
            Logged in at: <?= date("d-F-Y \a\\t h:i A", strtotime($attendance_data->login_time)) ?>
          </p>
          <p class="logout-time mb-4">
            <i class="fas fa-clock mr-2"></i>
            Logged out at: <?= date("d-F-Y \a\\t h:i A", strtotime($attendance_data->logout_time)) ?>
          </p>

          <a href="<?= MAINSITE ?>" class="btn btn-custom">
            <i class="fas fa-tachometer-alt mr-2"></i>Go to HOME
          </a>
        </div>
      </div>
    </div>
  </div>
</div>