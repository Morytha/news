<!DOCTYPE html>
<?php 
    include('function.php');
    $user_id = $_SESSION['user'];
    if(empty($_SESSION['user'])){
        header('location: login.php');
    }
    $sql = "SELECT * FROM `user` WHERE id='$user_id'";
    $rs  = $connection->query($sql);
    $row = mysqli_fetch_assoc($rs);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- @theme style -->
    <link rel="stylesheet" href="assets/style/theme.css">

    <!-- @Bootstrap -->
    <link rel="stylesheet" href="assets/style/bootstrap.css">

    <!-- @script -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/bootstrap.js"></script>

    <!-- @tinyACE -->
    <script src="https://cdn.tiny.cloud/1/5gqcgv8u6c8ejg1eg27ziagpv8d8uricc4gc9rhkbasi2nc4/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</head>
<body>
    <main class="admin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <div class="content-left">
                        <!-- <div class="wrap-top">
                            <img src="assets/icon/admin-logo.png" alt="">
                            <h5>Jong Deng News</h5>
                        </div> -->
                        <a  href="index.php" style="background-color:#1a162b">
                            <div class="wrap-center">
                                <img src="./assets/image/<?php echo $row['profile']?>" width="40" height="40" style="object-fit:cover" alt="">
                                <h6>Welcome Admin <?php echo $row['username']?></h6>
                            </div>
                        </a>
                        <div class="wrap-bottom">
                            <ul>
                                <li class="parent">
                                    <a class="parent" href="javascript:void(0)">
                                        <span>New Content</span>
                                        <img src="assets/icon/arrow.png" alt="">
                                    </a>
                                    <ul class="child">
                                        <li>
                                            <a href="view_news-post.php">View Post</a>
                                            <a href="add_news-post.php">Add News</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent">
                                    <a class="parent" href="javascript:void(0)">
                                        <span>New Logo</span>
                                        <img src="assets/icon/arrow.png" alt="">
                                    </a>
                                    <ul class="child">
                                        <li>
                                            <a href="add_logo-post.php">Add Logo</a>
                                            <a href="view_logo-post.php">View Logo</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent">
                                    <a class="parent" href="javascript:void(0)">
                                        <span>Follow us</span>
                                        <img src="assets/icon/arrow.png" alt="">
                                    </a>
                                    <ul class="child">
                                        <li>
                                            <a href="add-fullow_us.php">Add Follow Us</a>
                                            <a href="view-fullow_us.php">View Follow Us</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent">
                                    <a href="view_feedback.php">FEEDBACK</a>
                                </li>
                                <li class="parent">
                                    <a href="logout.php">Logout</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>   