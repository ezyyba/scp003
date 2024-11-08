<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD APPLICATION</title>
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
      
      if($_GET['update']) {
        $item = $_GET['update'];
        $recordID = $connection->prepare("SELECT * FROM scp1 WHERE item = ?");
        if(!$recordID) {
            echo "<div class='alert alert-danger p-3 m-2'> Error preparing record for updating</div>";
            exit;
        }
        $recordID->bind_param("i", $item);

        if($recordID->execute()) {
          echo "<div class='alert alert-success p-3 m-2'> Record ready for updating</div>";
          $temp = $recordID->get_result();
          $row = $temp->fetch_assoc();
        } else {
          echo "<div class='alert alert-danger p-3 m-2'> Error: {$recordID->error}</div>";
          exit;                    
        }
      }
      
      if(isset($_POST['update'])) {
        // Prepared statement to update data
        $update = $connection->prepare("UPDATE scp1 SET image=?, scp=?, oc=?, des=?, specialcp=? WHERE item=?");
        $update->bind_param("sssssi", $_POST['image'], $_POST['scp'], $_POST['oc'], $_POST['des'], $_POST['specialcp'], $_POST['item']);
        
        if($update->execute()) {
          echo "
            <div class='alert alert-success p-3'>Record successfully Updated</div>
          ";
        } else {
          echo "
            <div class='alert alert-danger p-3'> Error: {$update->error}</div>
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
        <h1 class="text-center">Update SCP Record</h1>
        <p><a href="index.php" class="btn btn-dark">Back to Home page</a></p>
        
        <div class="p-3">
          <form method="post" action="update.php" class="form-group">
            <input type="hidden" name="item" value="<?php echo $row['item']; ?>">
            
            <div class="mb-3">
              <label for="image">Image</label>
              <input type="text" name="image" id="image" placeholder="images/nameofimage.png..." class="form-control" value="<?php echo $row['image']; ?>">
            </div>
            
            <div class="mb-3">
              <label for="scp">SCP</label>
              <input type="text" name="scp" id="scp" placeholder="SCP..." class="form-control" value="<?php echo $row['scp']; ?>">
            </div>
            
            <div class="mb-3">
              <label for="oc">Object Class</label>
              <input type="text" name="oc" id="oc" placeholder="Object Class..." class="form-control" value="<?php echo $row['oc']; ?>">
            </div>
            
            <div class="mb-3">
              <label for="des">Description</label>
              <input type="text" name="des" id="des" placeholder="Description..." class="form-control" value="<?php echo $row['des']; ?>">
            </div>
            
            <div class="mb-3">
              <label for="specialcp">Special Containment Procedure</label>
              <input type="text" name="specialcp" id="specialcp" placeholder="Special Containment Procedure..." class="form-control" value="<?php echo $row['specialcp']; ?>">
            </div>
            
            <button type="submit" name="update" class="btn btn-primary">Update Record</button>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
