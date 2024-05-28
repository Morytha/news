<?php 
    include('sidebar.php');
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>New Contents</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="type">
                                            <option selected>Select Type</option>
                                            <option value="National">National</option>
                                            <option value="International">International</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-select" name="category">
                                            <option selected>Select Category</option>
                                            <option value="Sport">Sport</option>
                                            <option value="Social">Social</option>
                                            <option value="Entertainment">Entertainment</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="d-flex">Thumbnail  (<p style="color: red;">Size 350x200</p>)</label>
                                        <input type="file" class="form-control" name="thumbnail">
                                    </div>
                                    <div class="form-group">
                                        <label class="d-flex">Banner  (<p style="color: red;">Size 730x415</p>)</label>
                                        <input type="file" class="form-control" name="banner">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button name="btn_upload" type="submit" class="btn btn-primary">Upload</button>
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