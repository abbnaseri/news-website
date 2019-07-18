<?php
    $sql = "SELECT * FROM news where id=$id";
    $pquery = $db->query($sql);
?>
<div class="col-12 col-md-6 col-lg-8">
  <?php while ($news = mysqli_fetch_assoc($pquery)) : ?>
        <!-- Single Featured Post -->
                <p class="lead text-right"><i class="fa fa-user"></i><?php echo $news['source']; ?>
                </p>
                <hr>
                <p class="text-right"><i class="fa fa-calendar"></i><?php echo $news['daten'];?> </br> <?php echo $news['timen']; ?></p>

                <hr>
                <img src="<?php echo $news['image']; ?>" class="img-responsive">
                <hr>
                <p class="lead text-right"><?php echo $news['title']; ?></p>
                <?php
                    $text = $news['textBody'];
                    $newtext = str_replace("\n", "</br>",$text);
                 ?>
                <p class="text-dark text-right"><?php echo $newtext; ?></p>
       <center><p><strong>TELERAMA NEWS</strong>
       <?php endwhile; ?>
</div>
