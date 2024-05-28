<?php 
    include('sidebar.php');
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Add Follow Us</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Label</label>
                                        <input type="text" class="form-control" name="label">
                                    </div>
                                    <div class="form-group">
                                        <label class="d-flex">Icon  </label>
                                        <input type="file" class="form-control" name="icon">
                                    </div>
                                    <div class="form-group">
                                        <label>Url</label>
                                        <input type="text" class="form-control" name="url">
                                    </div>
                                    <div class="form-group">
                                        <button name="btn_save" type="submit" class="btn btn-primary">Save</button>
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