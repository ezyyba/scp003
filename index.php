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
        padding-top: 56px; /* Add padding-top to push content below navbar */
      }
      /* Navbar */
      .navbar {
        background-color: #111;
        width: 100%;
        z-index: 1050;
      }
      .navbar .navbar-brand {
        font-size: 1.25rem;
        color: #eaeaea;
        width: 100%;
        text-align: center;
      }
      /* Sidebar */
      .sidebar {
        height: calc(100vh - 56px); /* Full height minus navbar */
        width: 250px;
        background-color: #111;
        color: #eaeaea;
        padding-top: 20px;
        position: fixed;
        top: 56px; /* Position below navbar */
        left: 0;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 1040;
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .sidebar .nav-link {
        color: #eaeaea;
        border-bottom: 1px solid #333;
        padding: 12px 20px;
      }
      .sidebar .nav-link:hover {
        background-color: #333;
        color: #ff4444;
      }
      /* Centered Content */
      .main-container {
        display: flex;
        justify-content: center;
        padding-top: 20px; /* Add padding to the content */
      }
      .content {
        width: 100%;
        max-width: 800px;
        padding: 20px;
        background: #2b2b2b;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
      }
      /* Card and Button Styling */
      .card {
        background-color: #2b2b2b;
        color: #eaeaea;
        border: none;
      }
      .card-title {
        color: #ff4444;
      }
      .btn-info {
        background-color: #ff4444;
        border: none;
      }
      .btn-info:hover {
        background-color: #cc3333;
      }
      img {
        max-width: 100%;
        border: 1px solid #444;
        margin-bottom: 15px;
      }
      .alert {
        color: #fff;
        background-color: #444;
        border: none;
      }
    </style>
  </head>
  <body class="container-fluid">
    <?php include "connection.php"; ?>

    <!-- Navbar with SCP Branding -->
    <nav class="navbar navbar-dark fixed-top">
      <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
        <span class="navbar-toggler-icon"></span>
      </button>
      <span class="navbar-brand ms-2">SCP Foundation Database</span>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a href="index.php" class="nav-link">Home</a>
        </li>
        <?php foreach($result as $link): ?>
          <li class="nav-item">
            <a href="index.php?link=<?php echo $link['scp']; ?>" class="nav-link"><?php echo $link['scp']; ?></a>
          </li>
        <?php endforeach; ?>
        <li class="nav-item">
          <a href="create.php" class="nav-link">New SCP</a>
        </li>
      </ul>
    </div>

    <!-- Centered Content -->
    <div class="main-container">
      <div class="content">
        <h1 class="text-center"></h1>
        <div>
          <?php 
            if(isset($_GET['link'])) {
              $scp = $_GET['link'];
              $stmt = $connection->prepare("SELECT * FROM scp1 WHERE scp = ?");
              if(!$stmt) {
                echo "<p>Error in preparing SQL statement</p>"; 
                exit; 
              }
              $stmt->bind_param("s", $scp); 
              if($stmt->execute()) {
                $result = $stmt->get_result();
                if($result->num_rows > 0) {
                  $array = array_map('htmlspecialchars', $result->fetch_assoc());
                  $update = "update.php?update=" . $array['item'];
                  $delete = "index.php?delete=" . $array['item'];
                  echo "
                  <div class='card card-body shadow mb-3'> 
                    <p><img src='{$array['image']}' alt ='{$array['scp']}'></p>
                    <h2 class='card-title'>{$array['scp']}</h2>
                    <p><strong>Object Class:</strong> {$array['oc']}</p>
                    <p><strong>Description:</strong> {$array['des']}</p>
                    <p><strong>Special Containment Procedures:</strong> {$array['specialcp']}</p>
                    <p>
                      <a href='{$update}' class='btn btn-info'> Update Record</a>
                      <a href='{$delete}' class='btn btn-info'> Delete Record</a>                                  
                    </p>
                  </div>
                  ";
                } else {
                  echo "<p>No record found for model " . htmlspecialchars($scp) . "</p>";
                }
              } else {
                echo "<p>Error executing the statement</p>";
              }
            } else {
              echo "
                <div class='text-center'>
                  <p><img src='images/scphome.jpg' class='img-fluid'></p> 
                  <h2>Please use caution when accessing classified entries.</h2>
                </div>
              ";
            }

            if(isset($_GET['delete'])) {
              $delID = $_GET['delete'];
              $delete = $connection->prepare("DELETE FROM scp1 WHERE item=?");
              $delete->bind_param("i", $delID);
              if($delete->execute()) {
                echo "<div class='alert alert-warning'> Record Deleted...</div>";
              } else {
                echo "<div class='alert alert-danger'> Error Deleting: {$delete->error}.</div>";
              }
            }
          ?>
        </div>
      </div>
    </div>

    <script>
      function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
      }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
