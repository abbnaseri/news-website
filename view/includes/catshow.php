<?php
      $sql = "SELECT * FROM news WHERE type='$type'";
      $pquery = $db->query($sql);
?>
<div class="col-12 col-md-6 col-lg-8">
<div class="row">
<div class="card-group">
  <div class="card-columns">
    <?php while ($news1 = mysqli_fetch_assoc($pquery)) : ?>
    <div class="card">
      <img src="<?php echo $news1['image'] ?>" class="card-img-top" alt="...">
      <div class="card-body">
        <div class="post-data">
        <a href="index.php?id=<?php echo $news1['id'] ?>" class="post-title"><h5 class="card-title"><?php echo $news1['title'] ?></h5></a>
        <p class="card-text"><?php echo $news1['prenews'] ?></p>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
  </div>
</div>
</div>
</div>
