<?php
$sql1 = "SELECT * FROM news ORDER BY timen desc, daten desc LIMIT 1";
$sql2 = "SELECT * FROM news ORDER BY timen desc, daten desc LIMIT 1,3";
$pquery = $db->query($sql1);
$squery = $db->query($sql2);
?>


<div class="col-12 col-md-6 col-lg-8">
    <div class="row">

        <!-- Single Featured Post -->
        <div class="col-12 col-lg-7">
            <?php while($news1 = mysqli_fetch_assoc($pquery)) : ?>
            <div class="single-blog-post featured-post">
                <div class="post-thumb">
                    <a href="#"><img src="<?php echo $news1['image'] ?>" alt=""></a>
                </div>
                <div class="post-data">
                    <span lang="fa"><a href="#" class="post-catagory text-right"><?php echo $news1['type'] ?></a></span>
                    <a href='view/index.php?id=<?php echo $news1['id'] ?>' class="post-title">
                       <h6 class="text-right"><?php echo $news1['title'] ?></h6>
                    </a>
                    <div class="post-meta">
                        <span lang="fa"><p class="post-author text-right"><?php echo $news1['source'] ?> توسط</p></span>
                        <span lang="fa"><p class="post-excerp text-right"><?php echo $news1['prenews'] ?></P></span>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>


        <div class="col-12 col-lg-5">
            <!-- Single Featured Post -->
            <?php while($news2 = mysqli_fetch_assoc($squery)) : ?>
            <div class="single-blog-post featured-post-2">
                <div class="post-thumb">
                    <a href="#"><img src="<?php echo $news2['image'] ?>" alt=""></a>
                </div>
                <div class="post-data text-right">
                    <a href="#" class="post-catagory"><?php echo $news2['type'] ?></a>
                    <div class="post-meta">
                        <a href='view/index.php?id=<?php echo $news2['id'] ?>' class="post-title">
                            <span lang="fa"><h6><?php echo $news2['title'] ?></h6><span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

    </div>
</div>
