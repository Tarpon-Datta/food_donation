<?php
ob_start();
include '../connection.php';
include("connect.php");
if ($_SESSION['name'] == '') {
  header("location:deliverylogin.php");
}
$name = $_SESSION['name'];
$id = $_SESSION['Did'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="delivery.css">
  <link rel="stylesheet" href="../home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
  <header>
    <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
    <div class="hamburger">
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
    </div>
    <nav class="nav-bar">
      <ul>
        <li><a href="delivery.php" style="text-decoration: none;">Home</a></li>
        <li><a href="deliverymyord.php" style="text-decoration: none;" class="active">myorders</a></li>
        <li><a href="../logout.php" style="text-decoration: none;">Logout</a></li>

      </ul>
    </nav>
  </header>
  <br>
  <script>
    hamburger = document.querySelector(".hamburger");
    hamburger.onclick = function() {
      navBar = document.querySelector(".nav-bar");
      navBar.classList.toggle("active");
    }
  </script>
  <style>
    .video-container {
      position: relative;
      width: 100%;
      height: 50vh;

    }

    .video-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 70%;
      background-color: rgba(0, 0, 0, 0.4);

      opacity: 0;

      transition: opacity 0.3s;
    }

    .video-container:hover .video-overlay {
      opacity: 1;

    }

    video {
      width: 100%;
      height: 70%;
      object-fit: cover;
    }


    .footer {
      background-color: #333;
      color: #fff;
      padding: 20px 0;
      text-align: center;
    }

    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .footer p {
      margin: 0;
    }

    .footer-links {
      list-style: none;
      display: flex;
      margin-top: 10px;
    }

    .footer-links li {
      margin-right: 20px;
    }

    .footer-links a {
      color: #fff;
      text-decoration: none;
    }

    .lorem p {
      text-align: center;
    }

    /* Responsive styles */
    @media screen and (max-width: 768px) {
      .footer-content {
        flex-direction: column;
      }

      .footer-links {
        margin-top: 20px;
      }

      .footer-links li {
        margin-right: 0;
        margin-bottom: 10px;
      }
    }

    @media screen and (max-width: 600px) {
      #map-container {
        height: 200px;
      }
    }
  </style>

  <div class="video-container">
    <video autoplay loop muted playsinline>
      <source src="../img/pexel.mp4" type="video/mp4">
    </video>
    <div class="video-overlay"></div>

    <div class="get">
      <?php



      $sql = "SELECT fd.Fid AS Fid, fd.name,fd.phoneno,fd.date,fd.delivery_by, fd.address as From_address, 
ad.name AS delivery_person_name, ad.location AS To_address
FROM food_donations fd
LEFT JOIN admin ad ON fd.assigned_to = ad.Aid where delivery_by='$id';
";


      $result = mysqli_query($connection, $sql);




      if (!$result) {
        die("Error executing query: " . mysqli_error($conn));
      }


      $data = array();
      while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }


      if (isset($_POST['food']) && isset($_POST['delivery_person_id'])) {
        $order_id = $_POST['order_id'];
        $delivery_person_id = $_POST['delivery_person_id'];

        $sql = "UPDATE food_donations SET delivery_by = $delivery_person_id WHERE Fid = $order_id";

        $result = mysqli_query($connection, $sql);


        if (!$result) {
          die("Error assigning order: " . mysqli_error($conn));
        }


        header('Location: ' . $_SERVER['REQUEST_URI']);

        ob_end_flush();
      }



      ?>
      <div class="log">
        <a href="delivery.php" class="btn btn-primary btn-lg btn-block mb-3">Take orders</a>
        <p style="text-align: center; font-size: larger;">Orders assigned to you</p>
      </div>




      <div class="table-container">

        <div class="table-wrapper">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>phoneno</th>
                <th>date/time</th>
                <th>Pickup address</th>
                <th>Delivery address</th>




              </tr>
            </thead>
            <tbody>

              <?php foreach ($data as $row) { ?>
                <?php echo "<tr><td data-label=\"name\">" . $row['name'] . "</td><td data-label=\"phoneno\">" . $row['phoneno'] . "</td><td data-label=\"date\">" . $row['date'] . "</td><td data-label=\"Pickup Address\">" . $row['From_address'] . "</td><td data-label=\"Delivery Address\">" . $row['To_address'] . "</td>";
                ?>


              <?php } ?>
            </tbody>
          </table>
          <br>
          <br>
          <br>

        </div>

        <footer class="bg-dark text-white">
          <div class="container py-5">
            <div class="row justify-content-center">
              <div class="col-md-3">
                <h5 class="mb-4">Social Media</h5>
                <a class="btn btn-outline-light btn-floating me-2" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-light btn-floating me-2" href="#"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-outline-light btn-floating me-2" href="#"><i class="fab fa-instagram"></i></a>
              </div>

              <div class="col-md-3">
                <h5 class="mb-4">About Us</h5>
                <p>
                  We are a team of passionate individuals committed to addressing the issue of food waste in Bangladesh. Our goal is to create a system that connects food donors with charities and NGOs, while also reducing the environmental impact of food waste
                </p>
              </div>

              <div class="col-md-3">
                <h5 class="mb-3">Contact Us</h5>
                <p class="mb-0">
                  Email: contact@example.com
                </p>
                <p>
                  Phone: +8801917322572
                </p>
              </div>
            </div>
            <hr class="my-4">
          </div>


          <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 Your Company. All rights reserved.
          </div>
        </footer>

</body>

</html>