<?php include('header.php'); 
    $id = $_GET['id'];
?>
<main class="news-detail">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <?php getNewsDetail($id)?>
                    <?php getViews($id)?>
                </div>
                <div class="col-4">
                    <div class="relate-news">
                        <h3 class="main-title">Related News</h3>
                        <?php getReteNews($id)?>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('footer.php'); ?>