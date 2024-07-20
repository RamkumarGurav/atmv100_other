<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Employee Logout</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
   <style>
      body {
         background: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
         min-height: 100vh;
         display: flex;
         flex-direction: column;
         font-family: 'Arial', sans-serif;
      }

      .navbar {
         background: linear-gradient(to right, #4a00e0, #8e2de2);
      }

      .navbar-brand img {
         height: 40px;
      }

      .content-wrapper {
         flex: 1;
         display: flex;
         align-items: center;
      }

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

      .footer {
         background: linear-gradient(to right, #4a00e0, #8e2de2);
         color: white;
         padding: 2rem 0;
         margin-top: auto;
      }

      .footer a {
         color: #ffffff;
         text-decoration: none;
         transition: all 0.3s ease;
      }

      .footer a:hover {
         color: #84fab0;
      }

      .footer-icons {
         font-size: 1.5rem;
      }

      .footer-icons a {
         margin: 0 10px;
      }
   </style>
</head>

<body>
   <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="<?= MAINSITE ?>">
         <div>
            <h3 class="mb-0"><i class="fas fa-brain mr-2"></i>ATM</h3>
         </div>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
         aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
               <a class="nav-link" href="<?= MAINSITE ?>"><i class="fas fa-home mr-2"></i>Home</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?= MAINSITE . "employee-login" ?>"><i
                     class="fas fa-sign-in-alt mr-2"></i>Login</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?= MAINSITE . "employee-logout" ?>"><i
                     class="fas fa-sign-out-alt mr-2"></i>Logout</a>
            </li>
         </ul>
      </div>
   </nav>