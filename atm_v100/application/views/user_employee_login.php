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
          <h3 class="mb-0"><i class="fas fa-user-circle mr-2"></i>Employee Login</h3>
        </div>
        <div class="card-body p-4">
          <?php echo $this->session->flashdata('login_alert_message'); ?>
          <form method="post" action="<?= MAINSITE . 'ajax_user_employee_do_login' ?>">
            <div class="form-group">
              <label for="user_employee_custom_id"><i class="fas fa-id-badge mr-2"></i>Employee ID</label>
              <input type="text" name="user_employee_custom_id" id="user_employee_custom_id" class="form-control"
                required>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-4">
              <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>


</div>