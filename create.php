<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create SCP Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body {
        background-color: #1b1b1b;
        color: #eaeaea;
        font-family: 'Courier New', Courier, monospace;
        padding-top: 56px; /* Adjust for fixed navbar */
      }
      /* Navbar */
      .navbar {
        background-color: #111;
        z-index: 1050;
      }
      .navbar .navbar-brand {
        font-size: 1.25rem;
        color: #eaeaea;
        width: 100%;
        text-align: center;
      }
      /* Main Content */
      .main-container {
        display: flex;
        justify-content: center;
        padding-top: 20px;
      }
      .content {
        width: 100%;
        max-width: 800px;
        padding: 20px;
        background: #2b2b2b;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
      }
      /* Form and Button Styling */
      .form-group {
        margin-bottom: 1.5rem;
      }
      .form-control {
        background-color: #333;
        color: #fff;
        border: 1px solid #444;
      }
      .form-control:focus {
        background-color: #444;
        color: #fff;
        border-color: #ff4444;
      }
      label {
        color: #fff;
        font-weight: bold;
      }
      .btn-primary {
        background-color: #ff4444;
        border: none;
      }
      .btn-primary:hover {
        background-color: #cc3333;
      }
      .alert {
        color: #fff;
        background-color: #444;
        border: none;
      }
      .alert-success {
        background-color: #28a745;
      }
      .alert-danger {
        background-color: #dc3545;
      }
      .btn-dark {
        background-color: #222;
        color: #fff;
      }
      .btn-dark:hover {
        background-color: #111;
      }
    </style>
  </head>
  <body class="container-fluid">
    <?php
      include "connection.php";
      
      if(isset($_POST['Submit'])) {
        // Prepared statement to insert data
        $insert = $connection->prepare("INSERT INTO scp1 (image, scp, oc, des, specialcp) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $_POST['image'], $_POST['scp'], $_POST['oc'], $_POST['des'], $_POST['specialcp']);
        
        if($insert->execute()) {
          echo "
            <div class='alert alert-success p-3'>Record successfully created</div>
          ";
        } else {
          echo "
            <div class='alert alert-danger p-3'>Error: {$insert->error}</div>
          ";
        }
      }
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-dark fixed-top">
      <span class="navbar-brand ms-2">SCP Foundation Database</span>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
      <div class="content">
        <h1 class="text-center">Create a New SCP Record</h1>
        <p><a href="index.php" class="btn btn-dark">Back to Home page</a></p>
        
        <div class="p-3">
          <form method="post" action="create.php" class="form-group">
            <div class="mb-3">
              <label for="image">Enter Image URL</label>
              <input type="text" name="image" id="image" placeholder="images/nameofimage.png..." class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="scp">Enter SCP</label>
              <input type="text" name="scp" id="scp" placeholder="SCP..." class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="oc">Enter Object Class</label>
              <input type="text" name="oc" id="oc" placeholder="Object Class..." class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="des">Enter Description</label>
              <input type="text" name="des" id="des" placeholder="Description..." class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="specialcp">Enter Special Containment Procedure</label>
              <input type="text" name="specialcp" id="specialcp" placeholder="Special Containment Procedure..." class="form-control" required>
            </div>
            <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
