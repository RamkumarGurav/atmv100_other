<?php



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Page Not Found</title>
  <style>
    body {
      background-color: #f0f0f0;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #333;
    }

    .container {
      text-align: center;
    }

    .container h1 {
      font-size: 72px;
      margin: 0;
    }

    .container h2 {
      font-size: 24px;
      margin: 10px 0;
    }

    .container p {
      font-size: 18px;
      margin: 20px 0;
    }

    .container a {
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
      font-size: 18px;
    }

    .container a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>404</h1>
    <h2>Page Not Found</h2>
    <p>Sorry, the page you are looking for does not exist.</p>
    <p><a href="<?= MAINSITE_Admin . "wam" ?>">Go to Homepage</a></p>
  </div>
</body>

</html>