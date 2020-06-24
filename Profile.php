<?php require_once ("Includes/DB.php"); ?>
<?php require_once ("Includes/Functions.php"); ?>
<?php require_once ("Includes/Sessions.php"); ?>
<?php
    $SearchQueryParameter = $_GET["username"];
    global $ConnectingDB;
    $sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt ->bindValue(':userName',$SearchQueryParameter);
    $stmt ->execute();
    $Result = $stmt->rowCount();
    if($Result==1)
    {
        while ($DataRows    = $stmt->fetch()){
            $ExistingName   = $DataRows["aname"];
            $ExistingBio    = $DataRows["abio"];
            $ExistingImage  = $DataRows["aimage"];
            $ExistingHeadline = $DataRows["aheadline"];
        }
    }
    else{
        $_SESSION["ErrorMessage"]="Bad Request!";
        Redirect_to("Blog.php?page=1");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/e3893d6151.js" crossorigin="anonymous"></script>

    <title>Profile</title>
    <link rel="stylesheet" href="Css/bootstrap.css">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <link rel="stylesheet" href="Css/Style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>
<div style="height: 10px; background: #27aae1;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
    <div class="container">
        <a href="#" class="navbar-brand">BLOGPOST.com</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a href="Blog.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php" class="nav-link">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Features</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto mt-2 mb-2">
                <form class="form-inline d-none d-sm-block" action="Blog.php" >
                    <div class="form-group">
                        <input class="form-control mr-2" type="text" name="Search" placeholder="Type here" value="">
                        <button class="btn btn-primary" name="SearchButton">Go</button>
                    </div>
                </form>
            </ul>
        </div>
    </div>
</nav>
<div style="height: 10px; background: #27aae1;"></div>
<!--NAVBAR ENDS HERE -->

<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1><i class="fas fa-user text-success mr-2" style="color: #27aae1;"></i><?php echo $ExistingName; ?></h1>
                <h3><?php echo $ExistingHeadline; ?></h3>
            </div>
        </div>
    </div>
</header>
<section class="container py-2 mb-4">
    <div class="row">
        <div class="col-md-3 mt-4">
            <img src="Images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3"   alt="">
        </div>
        <div class="col-md-9 mt-4" style="min-height: 350px">
            <div class="card">
                <div class="card-body">
                    <p class="lead">
                        <?php echo $ExistingBio; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</section>


<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="lead text-center m-3">THEME BY | KIRATPAL KAUR | <span id="year"></span> &copy; ALL RIGHTS RESERVED.</p>
            </div>
        </div>
    </div>
</footer>
<div style="height: 10px; background: #27aae1;"></div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    $('#year').text(new Date().getFullYear());
</script>

</body>
</html>