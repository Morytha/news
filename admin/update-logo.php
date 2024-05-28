<?php 
    include('sidebar.php');
    $id  = $_GET['id'];
    $sql = "SELECT * FROM `logo` WHERE id='$id'";
    $rs  = $connection->query($sql);
    $row = mysqli_fetch_assoc($rs);
    if($row['type']=='Header'){
        $select_header = 'selected';
        $select_footer = '';
    }else{
        $select_footer = 'selected';
        $select_header = '';
    }
    
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Update Logo</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                   
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="type">
                                            <option selected>Select Type</option>
                                            <option value="Header" <?php echo $select_header?> >Header</option>
                                            <option value="Footer" <?php echo $select_footer?> >Footer</option>
                                        </select>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        <input type="file" class="form-control" name="thumbnail">
                                        <img src="assets/image/<?php echo $row['thumbnail']?>" width="120" height="120" style="object-fit:cover;" alt="">
                                        <!-- Hidden Thumbnail -->
                                        <input type="hidden" value="<?php echo $row['thumbnail']?>" name="old_thumbnail">
                                    </div>
                                    
                                    <div class="form-group">
                                        <button name="update_logo" type="submit" class="btn btn-success">Update</button>
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