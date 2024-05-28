<?php 
    include('sidebar.php');
    $id  = $_GET['id'];
    $sql = "SELECT * FROM `news` WHERE id='$id'";
    $rs  = $connection->query($sql);
    $row = mysqli_fetch_assoc($rs);
    if($row['type']=='National'){
        $select_national = 'selected';
        $select_international = '';
    }else{
        $select_international = 'selected';
        $select_national = '';
    }
    $select_Social = '';
    $select_Entertainment = '';
    $select_Sport = '';
    if($row['category']=='Sport'){
        $select_Sport = 'selected';
    }else if($row['category']=='Social'){
        $select_Social = 'selected';
    }else{
        $select_Entertainment = 'selected';
    }
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Update New Contents</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $row['title']?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="type">
                                            <option selected>Select Type</option>
                                            <option value="National" <?php echo $select_national?> >National</option>
                                            <option value="International" <?php echo $select_international?> >International</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-select" name="category">
                                            <option selected>Select Category</option>
                                            <option value="Sport" <?php echo $select_Sport?> >Sport</option>
                                            <option value="Social" <?php echo $select_Social?> >Social</option>
                                            <option value="Entertainment" <?php echo $select_Entertainment?> >Entertainment</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="d-flex">Thumbnail  (<p style="color: red;">Size 350x200</p>)</label>
                                        <input type="file" class="form-control" name="thumbnail">
                                        <img src="assets/image/<?php echo $row['thumbnail']?>" width="120" height="120" style="object-fit:cover;" alt="">
                                        <!-- Hidden Thumbnail -->
                                        <input type="hidden" value="<?php echo $row['thumbnail']?>" name="old_thumbnail">
                                    </div>
                                    <div class="form-group">
                                        <label class="d-flex">Banner  (<p style="color: red;">Size 730x415</p>)</label>
                                        <input type="file" class="form-control" name="banner">
                                        <img src="assets/image/<?php echo $row['banner']?>" width="120" height="120" style="object-fit:cover;" alt="">
                                        <!-- Hidden Banner -->
                                        <input type="hidden" value="<?php echo $row['banner']?>" name="old_banner">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description">
                                          <?php echo $row['description']?>
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <button name="btn_update" type="submit" class="btn btn-success">Update</button>
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