<!-- @import jquery & sweet alert  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 
    $connection = new mysqli('localhost','root','','db_project');
    function getLogo($type){
        global $connection;
        $sql = "SELECT * FROM `logo` WHERE type = '$type' ORDER BY id DESC LIMIT 1";
        $rs  = $connection->query($sql);
        $row = mysqli_fetch_assoc($rs);
        echo $row['thumbnail'];
    }
    
    function getTrending(){
        global $connection;
        $sql = "SELECT * FROM `news` ORDER BY id DESC LIMIT 3";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
                <i class="fas fa-angle-double-right"></i>
                <a href="news-detail.php?id='.$row['id'].'">'.$row['title'].'</a> &ensp;
            ';
        }
    }
    function getNewsDetail($id){
        global $connection;
        $sql = "SELECT * FROM `news` WHERE id = '$id'";
        $rs  = $connection->query($sql);
        $row = mysqli_fetch_assoc($rs);
        $date = $row['create_at'];
        $date = date('d/M/Y',strtotime($date));
        echo '
            <div class="main-news">
                <div class="thumbnail">
                    <img src="../admin/assets/image/'.$row['banner'].'">
                </div>
                <div class="detail">
                    <h3 class="title">'.$row['title'].'</h3>
                    <div class="date">'.$date.'</div>
                    <div class="description">'.$row['description'].'</div>
                </div>
            </div>
        ';
    }
    function getNewstype($id){
        global $connection;
        $sql = "SELECT * FROM `news` WHERE id='$id'";
        $rs = $connection->query($sql);
        $row = mysqli_fetch_assoc($rs);
        return $row['type'];
    }
    function getReteNews($id){
        global $connection;
        $type = getNewstype($id);
        $sql = "SELECT * FROM `news` WHERE type='$type' AND id NOT IN($id) ORDER BY id DESC LIMIT 3";
        $rs = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y',strtotime($date));
            echo '
            <figure>
                <a href="news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" alt="">
                    </div>
                    <div class="detail">
                        <h3 class="title">'.$row['title'].'</h3>
                        <div class="date">'.$date.'</div>
                        <div class="description">'.$row['description'].'</div>
                    </div>
                </a>
            </figure>
            ';
        }
    }
    function getViews($id){
        global $connection;
        $sql = "UPDATE `news` SET `view`=`view`+1 WHERE id='$id'";
        $rs = $connection->query($sql);
    }
    function getMinNews($type){
        global $connection;
        if($type=='Trending'){
            $sql = "SELECT * FROM `news` ORDER BY `view` DESC LIMIT 1";
            $rs = $connection->query($sql);
            $row = mysqli_fetch_assoc($rs);
            echo '
            <div class="col-8 content-left">
                <figure>
                    <a href="news-detail.php?id='.$row['id'].'">
                        <div class="thumbnail">
                            <img src="../admin/assets/image/'.$row['banner'].'" width="730" height="415" alt="">
                            <div class="title">'.$row['title'].'</div>
                        </div>
                    </a>
                </figure>
            </div>
            ';
        }else{
            $sql = "SELECT * FROM `news` WHERE id !=(SELECT id FROM `news` ORDER BY `view` DESC LIMIT 1) ORDER BY id DESC LIMIT 2";
            $rs = $connection->query($sql);
            while($row=mysqli_fetch_assoc($rs)){
                echo '
                <div class="col-12">
                    <figure>
                        <a href="news-detail.php?id='.$row['id'].'">
                            <div class="thumbnail">
                                <img src="../admin/assets/image/'.$row['banner'].'" width="350" height="200" alt="">
                            <div class="title">'.$row['title'].'</div>
                            </div>
                        </a>
                    </figure>
                </div>
                ';
            }
        }
    }
    function search($query){
        global $connection;
        $sql = "SELECT * FROM `news` WHERE `title` LIKE '%$query%'";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y',strtotime($date));
            echo '
                <div class="col-4">
                    <figure>
                        <a href="news-detail.php?id='.$row['id'].'">
                            <div class="thumbnail">
                                <img src="../admin/assets/image/'.$row['thumbnail'].'"width="350" height="200" alt="">
                            </div>
                            <div class="detail">
                                <h3 class="title">'.$row['title'].'</h3>
                                <div class="date">'.$date.'</div>
                                <div class="description">'.$row['description'].' </div>
                            </div>
                        </a>
                    </figure>
                </div>
            ';
        }
    }
    function listNews($category,$type,$page,$limit){
        global $connection;
        $start = ($page-1) * $limit;
        $sql   = "SELECT * FROM `news` WHERE (`category`='$category' AND `type`='$type')
                ORDER BY id DESC LIMIT $start,$limit";
        $rs    = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y',strtotime($date));
            echo '
                <div class="col-4">
                    <figure>
                        <a href="news-detail.php?id='.$row['id'].'">
                            <div class="thumbnail">
                                <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" height="200" alt="">
                            </div>
                            <div class="detail">
                                <h3 class="title">'.$row['title'].'</h3>
                                <div class="date">'.$date.'</div>
                                <div class="description">'.$row['description'].'</div>
                            </div>
                        </a>
                    </figure>
                </div>
            ';
        }
    }
    function getPageInage($category,$type,$limit){
        global $connection;
        $sql = "SELECT COUNT(`id`) as total_id FROM `news`
                WHERE (`category`='$category' AND type='$type')";
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
    function getAllNews($category,$limit){
        global $connection;
        $sql   = "SELECT * FROM `news` WHERE `category`='$category' ORDER BY id DESC LIMIT $limit";
        $rs    = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y',strtotime($date));
            echo '
                <div class="col-4">
                    <figure>
                        <a href="news-detail.php?id='.$row['id'].'">
                            <div class="thumbnail">
                                <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" height="200" alt="">
                                <div class="title">'.$row['title'].'></div>
                            </div>
                           
                        </a>
                    </figure>
                </div>
            ';
        }
    }
    function AddFeedBack(){
        global $connection;
        if(isset($_POST['btn_message'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $tel = $_POST['tel'];
            $address = $_POST['address'];
            $message = $_POST['message'];
            if(!empty($username) && !empty($email) && !empty($tel) && !empty($address) && !empty($message)){
                $spl = "INSERT INTO `feedback`(`username`,`email`, `phone`, `address`, `message`) 
                        VALUES ('$username','$email','$tel','$address','$message')";
                $rs  = $connection->query($spl);
            }
        }
    }
    AddFeedBack();
    function geticon($pos){
        global $connection;
        $sql = "SELECT * FROM `follow_us` ORDER BY `id` LIMIT 3";
        $rs  = $connection->query($sql);
        while($row = mysqli_fetch_assoc($rs)){
            if($pos == 'contact'){
                echo '
                    <li>
                    <a href="'.$row['url'].'">
                    <img src="../admin/assets/image/'.$row['icon'].'" width="40">'.$row['label'].' </a>
                    </li>
                ';
            }else{
                echo '
                    <li>
                        <a href="'.$row['url'].'"><img src="../admin/assets/image/'.$row['icon'].'" width="40" alt=""></a>
                    </li>
                ';
            }
        }
        
        
    }
    

    
?>