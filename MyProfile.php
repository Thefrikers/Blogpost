<?php require_once ("Includes/DB.php") ?>
<?php require_once ("Includes/Functions.php") ?>
<?php require_once ("Includes/Sessions.php") ?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
    $AdminId = $_SESSION["UserId"];
    global $ConnectingDB;
    $sql = "SELECT * FROM admins WHERE id='$AdminId'";
    $stmt = $ConnectingDB->query($sql);
    while ($DataRows=$stmt->fetch()){
        $ExistingName = $DataRows['aname'];
        $ExistingUserName = $DataRows['username'];
        $ExistingHeadline = $DataRows['aheadline'];
        $ExistingBio = $DataRows['abio'];
        $ExistingImage = $DataRows['aimage'];
    }
?>


<?php
if(isset($_POST["Submit"])){
    $AName = $_POST["Name"];
    $AHeadline = $_POST["Headline"];
    $ABio = $_POST["Bio"];
    $Image = $_FILES["Image"]["name"];
    $Target = "Images/".basename($_FILES["Image"]["name"]);

    if(strlen($AHeadline)>30){
        $_SESSION["ErrorMessage"] = "Headline should be less than 30 Characters.";
        Redirect_to("MyProfile.php");
    }
    else if(strlen($AHeadline)>500){
        $_SESSION["ErrorMessage"]= "Bio should be less than 500 character";
        Redirect_to("MyProfile.php");
    }
    else if((empty($ExistingName))&&(empty($ExistingHeadline))&&(empty($ExistingBio))){
        $_SESSION["ErrorMessage"]= "Fill all the information first";
        Redirect_to("MyProfile.php");
    }
    else{
        global $ConnectingDB;
        if(!empty($_FILES["Image"]["name"])){
            $sql = "UPDATE admins 
                SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
                WHERE id = '$AdminId'";
        }
        else{
            $sql = "UPDATE admins 
                SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
                WHERE id = '$AdminId'";
        }
        $Execute = $ConnectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

        if($Execute){
            $_SESSION["SuccessMessage"]="Details Updated Successfully";
            Redirect_to("MyProfile.php");
        }
        else{
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!";
            Redirect_to("MyProfile.php");
        }
    }
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
                    <a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-primary"></i> My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="Admins.php" class="nav-link">Manage Admins</a>
                </li>
                <li class="nav-item">
                    <a href="Comments.php" class="nav-link">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="Logout.php" class="nav-link"><i class="fas fa-user-times text-danger"></i> Logout</a> </li>
            </ul>
        </div>
    </div>
</nav>
<div style="height: 10px; background: #27aae1;"></div>
<!--NAVBAR ENDS HERE -->

<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-user mr-2 text-success"></i>@<?php echo  $ExistingUserName; ?></h1>
                <small><?php echo $ExistingHeadline;?></small>
            </div>
        </div>
    </div>
</header>

<section class="container py-2 mb-4">
    <div class="row">
        <!-- left hand -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h3> <?php echo $ExistingName;  ?></h3>
                </div>
                <div class="card-body">
                    <img src="Images/<?php echo $ExistingImage; ?>" class="block text-img-fluid  mb-3 ml-lg-3" width="180px" height="180px" alt="">
                    <div class="text-justify">
                        <?php echo $ExistingBio; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9" style="min-height: 400px; ">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-header">
                        <h1>Edit Profile</h1>
                    </div>
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <input class="form-control" type="text" name="Name" id="title" placeholder="Your Name" value="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="Headline" id="title" placeholder="Headline" value="">
                            <small class="text-muted">Add a professional headline like, 'Engineer' at XYZ or 'Architect'</small>
                            <span class="text-danger">Not more than 30 Characters</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="Post" name="Bio" rows="8" cols="80" placeholder="Bio"></textarea>
                        </div>
                        <div class="form-group mt-3 mb-1">
                            <div class="custom-file">
                                <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image</label>
                            </div>
                        </div>

                        <div class="row mt-3" >
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard </a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i>Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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