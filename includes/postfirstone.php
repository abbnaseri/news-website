<?php
$sql = "SELECT * FROM ttype";
$pquery = $db->query($sql);
?>

<div class="col-12 col-md-6 col-lg-4">
    <!-- Single Featured Post -->
    <?php while ($news = mysqli_fetch_assoc($pquery)) : ?>
    <div class="single-blog-post small-featured-post d-flex text-right">
        <div class="post-thumb">
            <a href='view/category.php?type=<?php echo $news['type'] ?>'><img src="<?php echo $news['image'] ?>" alt=""></a>
        </div>
        <div class="post-data">
            <a href='view/category.php?type=<?php echo $news['type'] ?>' class="post-catagory"><?php echo $news['type'] ?></a>
            <div class="post-meta">
                <a href='view/category.php?type=<?php echo $news['type'] ?>' class="post-title">
                    <h6>مشروح اخبار</h6>
                </a>
            </div>
        </div>
    </div>
  <?php endwhile; ?>
</div>
