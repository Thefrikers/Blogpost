<?php require_once ("Includes/DB.php"); ?>
<?php require_once ("Includes/Functions.php"); ?>
<?php require_once ("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/e3893d6151.js" crossorigin="anonymous"></script>

    <title>Posts</title>
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
                <h1><i class="fas fa-blog text-primary"></i>Blog Posts</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="AddNewPost.php" class="btn btn-primary btn-block">
                    <i class="fas fa-edit">Add New Post</i>
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Categories.php" class="btn btn-info btn-block">
                    <i class="fas fa-folder-plus">Add New Category</i>
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="#" class="btn btn-warning btn-block">
                    <i class="fas fa-user-plus">Add New Admin</i>
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="#" class="btn btn-success btn-block">
                    <i class="fas fa-check">Approve Comments</i>
                </a>
            </div>
        </div>
    </div>
</header>

<section class="container py-2 mb-4 mt-3">
    <div class="row">
        <div class="col-md-12">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <table class="table table-responsive table-striped table-hover ">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date&Time</th>
                    <th>Author</th>
                    <th>Banner</th>
                    <th>Comments</th>
                    <th>Action</th>
                    <th>Live Preview</th>
                </tr>
                </thead>
                <?php
                global $ConnectingDB;
                $sql ="SELECT * FROM posts";
                $stmt = $ConnectingDB->query($sql);
                $sr=0;
                while ($DataRows=$stmt->fetch()){
                    $Id = $DataRows["id"];
                    $DataTime = $DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $Admin = $DataRows["author"];
                    $Image = $DataRows["image"];
                    $Posttext = $DataRows["post"];
                    $sr++;
                ?>
                    <tbody>
                <tr>
                    <td><?php echo $sr?></td>
                    <td>
                        <?php
                        if(strlen($PostTitle)>20){
                            $PostTitle = substr($PostTitle,0,15).'..';
                        }
                        echo $PostTitle;
                        ?>
                    </td>
                    <td><?php
                        if(strlen($Category)>8){
                            $Category = substr($Category,0,8).'..';
                        }
                        echo $Category;
                        ?>
                    </td>
                    <td><?php
                        if(strlen($DataTime)>11){
                            $DataTime = substr($DataTime,0,11).'..';
                        }
                        echo $DataTime;
                        ?>
                    </td>
                    <td><?php echo $Admin; ?></td>
                    <td><img src="Uploads/<?php echo $Image; ?>" width="140px;" height="50px"></td>
                    <td>
                        <?php
                        $Total = ApproveCommentsAccordingToPost($Id);
                        if($Total>0) {
                            ?>
                            <span class="badge badge-success">
                            <?php
                            echo $Total;   ?>
                            </span>
                        <?php }   ?>
                        <?php
                        $Total = DisApproveCommentsAccordingToPost($Id);
                        if($Total>0) {
                            ?>
                            <span class="badge badge-danger">
                            <?php
                            echo $Total;   ?>
                            </span>
                        <?php }   ?>
                    </td>                    <td>
                        <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span> </a>
                        <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span> </a>
                    </td>
                    <td>
                        <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span> </a>
                    </td>
                </tr>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>

</section>
<br>


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