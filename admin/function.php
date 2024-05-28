<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
    // connection
    $connection = new mysqli('localhost','root','','db_project');
    // move image to folder
    function moveImage($profile){
        $image = date('dmyhis').'-'.$_FILES[$profile]['name'];
        $path = './assets/image/'.$image;
        move_uploaded_file($_FILES[$profile]['tmp_name'],$path);
        return $image;
    }
    function registerAccount(){
        global $connection;
        if(isset($_POST['btn_register'])){
            $username = $_POST['username'];
            $email  = $_POST['email'];
            $password  = md5($_POST['password']);
            $profile  = moveImage('profile');
            // get username for compare
            $getusername = "SELECT * FROM `user` WHERE 1";
            $r  = $connection->query($getusername);
            while($row=mysqli_fetch_assoc($r)){
                if($username==$row['username']){
                    $username=null;
                }
            }
            if(!empty($username) && !empty($email) && !empty($password) && !empty($profile)){
                $sql = "INSERT INTO `user`(`username`, `email`, `password`, `profile`) 
                        VALUES ('$username','$email','$password','$profile')";
                $rs  = $connection->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success!",
                                text: "Account has been sign up",
                                icon: "success",
                                button: "exit",
                              });
                        })
                    </script>
                    ';
                }
            }else{
                echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Unsuccess!",
                                text: "Account has not sign up",
                                icon: "error",
                                button: "exit",
                              });
                        })
                    </script>
                ';
            }
        }
    }
    registerAccount();

    session_start();
    function login(){
        global $connection;
        if(isset($_POST['btn_login'])){
           $user_email = $_POST['name_email'];
           $password   = md5($_POST['password']);
            if(!empty($user_email) && !empty($password)){
                $sql = "SELECT id FROM `user` 
                        WHERE (username='$user_email' OR email='$user_email') AND password='$password'";
                $rs  = $connection->query($sql);
                $row = mysqli_fetch_assoc($rs);
                if($row){
                    $_SESSION['user'] = $row['id'];
                    echo '
                    <script>
                        $(document).ready(function(){

                            swal({
                                title: "Login Success!",
                                text: "Accouct has been login",
                                icon: "success",
                                button: "exit",
                              }).then((result) => {
                                    if(result){
                                        window.location.href="index.php";
                                    }
                              }).catch((err) => {
                                  if(err){

                                  }
                              });
                        })
                    </script>
                    ';
                }
            }else{
                echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Login Unsuccess!",
                                text: "Accouct has not been login",
                                icon: "error",
                                button: "exit",
                              });
                        })
                    </script>
                ';
            }
        }
    }
    login();
    function logout(){
        global $connection;
        if(isset($_POST['btn_logout'])){
            unset($_SESSION['user']);
            header('location: login.php');
        }
    }
    logout();

    function AddNewPost(){
        global $connection;
        if(isset($_POST['btn_upload'])){
            $title = $_POST['title'];
            $type = $_POST['type'];
            $category = $_POST['category'];
            $thumbnail = moveImage('thumbnail');
            $banner = moveImage('banner');
            $description = $_POST['description'];
            $author_id = $_SESSION['user'];
            if(!empty($title) && !empty($type) && !empty($category) && !empty($thumbnail) && !empty($banner) && !empty($description) && !empty($author_id)){
                $spl = "INSERT INTO `news`(`author_id`, `type`, `category`, `banner`, `thumbnail`, `title`, `description`) 
                        VALUES ('$author_id','$type','$category','$banner','$thumbnail','$title','$description')";
                $rs  = $connection->query($spl);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success!",
                                text: "News upload success!",
                                button: "exit",
                            });
                        })
                    </script>
                    ';
                }
            }else{
                echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Unsuccess!",
                                text: "Can not upload!",
                                button: "exit",
                              });
                        })
                    </script>
                ';
            }
        }
    }
    AddNewPost();
    function getNewsPost($page,$limit){
        global $connection;
        $start = ($page-1) * $limit;
        $sql = "SELECT t_user.username,t_news.* FROM `user` as t_user INNER JOIN `news` as `t_news` ON t_user.id = t_news.author_id
                ORDER BY id DESC LIMIT $start,$limit";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y',strtotime($date));
            echo '
                <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['title'].'</td>
                    <td>'.$row['type'].'</td>
                    <td>'.$row['category'].'</td>
                    <td><img src="assets/image/'.$row['thumbnail'].'" width="110" hiegth="110" style="object-fit:cover;"/></td>
                    <td>'.$row['view'].'</td>
                    <td>'.$date.'</td>
                    <td>'.$row['username'].'</td>
                    <td width="150px">
                        <a href="update-news-post.php?id='.$row['id'].'"class="btn btn-success">Update</a>
                        <button type="button" remove-id="'.$row['id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Remove
                        </button>
                    </td>
                </tr>
            ';
        }
    }
    function getPageInage($table,$limit){
        global $connection;
        $sql = "SELECT COUNT(`id`) as total_id FROM `$table`";
        $rs  = $connection->query($sql);
        $row = mysqli_fetch_assoc($rs);
        $total_id = $row['total_id'];
        $page = ceil($total_id/$limit);
        for($i=1;$i<=$page;$i++){
            echo '
                <li>
                    <a href="?page='.$i.'">'.$i.'</a>
                </li>
            ';
        }
    }
    function UpdateNewsPost(){
        global $connection;
        if(isset($_POST['btn_update'])){
            $title       = $_POST['title'];
            $type        = $_POST['type'];
            $category    = $_POST['category'];
            $thumbnail   = $_FILES['thumbnail']['name'];
            $banner      = $_FILES['banner']['name'];
            $description = $_POST['description'];
            $author_id   = $_SESSION['user'];
            $id          = $_GET['id'];
            if(empty($thumbnail)){
                $thumbnail = $_POST['old_thumbnail'];
            }else{
                $thumbnail = moveImage('thumbnail');
            }
            if(empty($banner)){
                $banner = $_POST['old_banner'];
            }else{
                $banner = moveImage('banner');
            }
            if(!empty($title) && !empty($type) && !empty($category) && !empty($thumbnail) && !empty($banner) && !empty($description) && !empty($author_id)){
                $update_at = date('d/M/Y');
                $sql = "UPDATE `news` 
                        SET `author_id`='$author_id',`type`='$type',`category`='$category',`banner`='$banner',`thumbnail`='$thumbnail',`title`='$title',`description`='$description' 
                        WHERE `id`='$id'";
                $rs  = $connection->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success!",
                                text: "News update success!",
                                button: "exit",
                            });
                        })
                    </script>
                    ';
                }
            }else{
                echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Unsuccess!",
                                text: "Can not upload!",
                                button: "exit",
                              });
                        })
                    </script>
                ';
            }
        }
    }
    UpdateNewsPost();
    function deleteNewsPost(){
        global $connection;
        if(isset($_POST['accept_delete'])){
            $id = $_POST['remove_id'];
            $sql = "DELETE FROM `news` WHERE id='$id'";
            $rs  = $connection->query($sql);
            if($rs){
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Success!",
                            text: "News deleted success!",
                            button: "exit",
                        });
                    })
                </script>
                ';
            }
        }
    }
    deleteNewsPost();
    function AddLogoPost(){
        global $connection;
        if(isset($_POST['save_logo'])){
            $type  = $_POST['type'];
            $thumbnail = moveImage('thumbnail');
            if(!empty($type) && !empty($thumbnail)){
                $sql = "INSERT INTO `logo`(`type`, `thumbnail`) 
                        VALUES ('$type','$thumbnail')";
                $rs  = $connection->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success!",
                                text: "Logo uploaded success!",
                                button: "exit",
                            });
                        })
                    </script>
                    ';
                }
            }else{
                echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Unsuccess!",
                                text: "Can not upload!",
                                button: "exit",
                              });
                        })
                    </script>
                ';
            }
        }
    }
    AddLogoPost();
    function getLogoNews($page,$limit){
        global $connection;
        $start = ($page-1)*$limit;
        $sql = "SELECT * FROM `logo` ORDER BY id DESC LIMIT $start,$limit";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
                <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['type'].'</td>
                    <td><img src="assets/image/'.$row['thumbnail'].'" width="110" hiegth="110" style="object-fit:cover;"/></td>
                    <td width="150px">
                        <a href="update-logo.php?id='.$row['id'].'"class="btn btn-success" name="update_logo">Update</a>
                        <button type="button" remove-id="'.$row['id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Remove
                        </button>
                    </td>
                </tr> 
            ';
        }
    }
    function updateLogoPost(){
        global $connection;
        if(isset($_POST['update_logo'])){
            $id = $_GET['id'];
            $type = $_POST['type'];
            $thumbnail = $_FILES['thumbnail']['name'];
            if(empty($thumbnail)){
                $thumbnail = $_POST['old_thumbnail'];
            }else{
                $thumbnail = moveImage('thumbnail');
            }
            if(!empty($type) && !empty($thumbnail)){
                $sql = "UPDATE `logo`
                        SET `type`='$type',`thumbnail`='$thumbnail'
                        WHERE `id`='$id'";
                $rs = $connection->query($sql);
                
            }
        }
    }
    updateLogoPost();
    function deleteLogopost(){
        global $connection;
        if(isset($_POST['accept_delete'])){
            $id = $_POST['remove_id'];
            $sql = "DELETE FROM `logo` WHERE id='$id'";
            $rs  = $connection->query($sql);
        }
    }
    deleteLogopost();
    function getfeedback($page,$limit){
        global $connection;
        $start = ($page-1) * $limit;
        $sql = "SELECT * FROM `feedback`
                ORDER BY id DESC LIMIT $start,$limit";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y',strtotime($date));
            echo '
                <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['username'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['address'].'</td>
                    <td>'.$row['message'].'</td>
                    <td>'.$date.'</td>
                </tr>
            ';
        }
    }
    function AddFollowUs(){
        global $connection;
        if(isset($_POST['btn_save'])){
            $label = $_POST['label'];
            $icon = moveImage('icon');
            $url = $_POST['url'];
            if(!empty($label) && !empty($icon) && !empty($url)){
                $spl = "INSERT INTO `follow_us`(`label`, `icon`, `url`) 
                        VALUES ('$label','$icon','$url')";
                $rs  = $connection->query($spl);
            }
        }
    }
    AddFollowUs();
    function getfollowUs(){
        global $connection;
        $sql = "SELECT * FROM follow_us ORDER BY id DESC";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
                <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['label'].'</td>
                    <td><img src="assets/image/'.$row['icon'].'" width="110" hiegth="110" style="object-fit:cover;"/></td>
                    <td width="150px">
                        <a href="update-follow_us.php?id='.$row['id'].'"class="btn btn-success">Update</a>
                        <button type="button" remove-id="'.$row['id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Remove
                        </button>
                    </td>
                </tr>
            ';
        }
    }
    function updateFollowUs(){
        global $connection;
        if(isset($_POST['update_follow'])){
            $id = $_GET['id'];
            $label = $_POST['label'];
            $icon = $_FILES['icon']['name'];
            if(empty($icon)){
                $icon = $_POST['old_icon'];
            }else{
                $icon = moveImage('icon');
            } 
            $url = $_POST['url'];
            if(!empty($label) && !empty($icon) && !empty($url)){
                $sql = "UPDATE `follow_us`
                        SET `label`='$label',`icon`='$icon',`url`='$url'
                        WHERE `id`='$id'";
                $rs = $connection->query($sql);
                
            }
        }
    }
    updateFollowUs();
    function deletefollowUs(){
        global $connection;
        if(isset($_POST['accept_delete'])){
            $id = $_POST['remove_id'];
            $sql = "DELETE FROM `follow_us` WHERE id='$id'";
            $rs  = $connection->query($sql);
        }
    }
    deletefollowUs();
?>