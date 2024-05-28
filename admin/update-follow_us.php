<?php 
    include('sidebar.php');
    $id  = $_GET['id'];
    $sql = "SELECT * FROM `follow_us` WHERE id='$id'";
    $rs  = $connection->query($sql);
    $row = mysqli_fetch_assoc($rs);
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Update New Follow</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Label</label>
                                        <input type="text" class="form-control" name="label" value="<?php echo $row['label']?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="d-flex">Icon</label>
                                        <input type="file" class="form-control" name="icon">
                                        <img src="assets/image/<?php echo $row['icon']?>" width="120" height="120" style="object-fit:cover;" alt="">
                                        <!-- Hidden Icon -->
                                        <input type="hidden" value="<?php echo $row['icon']?>" name="old_icon">
                                    </div>
                                    <div class="form-group">
                                        <label>Url</label>
                                        <input type="text" class="form-control" name="url" value="<?php echo $row['url']?>">
                                    </div>
                                    <div class="form-group">
                                        <button name="update_follow" type="submit" class="btn btn-success">Update</button>
                                        <a href="index.php" type="submit" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>