<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Project</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

   <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet"> 
</head>

<body class="body-header">

  <nav class="navbar">
    <div class="container-fluid px-5"> 
        <a class="navbar-brand">NOTIPAY</a>

        <div class="nav-right">
            <span class="user-text">
                <?php 
                echo isset($_SESSION['username']) 
                    ? "Hello, " . htmlspecialchars($_SESSION['username']) 
                    : "Hello, User"; 
                ?>
            </span>

            <a href="logout.php" class="btn btn-logout">Logout</a>
        </div>
    </div>
</nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
