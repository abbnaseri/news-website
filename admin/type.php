<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/webnews/core/init.php';
    if(!is_logged_in()){
      login_error_redirect();
    }
    include 'includes/head.php';
    include 'includes/navigation.php';
    if (isset($_GET['delete'])) {
      $id = sanitize($_GET['delete']);
      $db->query("DELETE FROM ttype WHERE type='$id'");
    }
    if (isset($_GET['add'])) {
      if($_POST) {
        $type = sanitize($_POST['typen']);
        $description = sanitize($_POST['description']);
        $errors = array();
        $required = array('typen', 'description');
        $dbPath = '';
        foreach ($required as $key) {
          if (empty($_POST[$key])) {
            $errors[] = 'All Fields With and Astrisk are required.'.$key;
            break;
          }
        }
        if (!empty($_FILES)) {
          echo "right";
          var_dump($_FILES);
          echo "hello";
          $photo = $_FILES['photo'];
          $name = $photo['name'];
          $nameArray = explode('.',$name);
          $fileName = $nameArray[0];
          $fileExt = $nameArray[1];
          $mime = explode('/',$photo['type']);
          $mimeType = $mime[0];
          $mimeExt = $mime[1];
          $tmpLoc = $photo['tmp_name'];
          $fileSize = $photo['size'];
          $allowed = array('png', 'jpg', 'jpeg', 'gif');
          $uploadName = md5(microtime()).'.'.$fileExt;
          $uploadPath = BASEURL.'images/typeimage/'.$uploadName;
          $dbPath = '/webnews/images/typeimage/'.$uploadName;
          if ($mimeType != 'image') {
            $errors[] = 'The file must be an image.';
          }
          if (!in_array($fileExt, $allowed)) {
            $errors[] = 'the file must be a png, jpg, jpeg, gif.';
          }
          if ($fileSize > 15000000) {
            $errors[] = 'The file must be under 15MB';
          }
          if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
            $errors[] = 'File extention does not match the file';
          }
          }
        if (!empty($errors)) {
          foreach ($errors as $key) {
            echo $key;
          }
          echo $dbPath;
          echo $uploadPath;
        }else {
          echo $dbPath;
          echo $uploadPath;

          move_uploaded_file($tmpLoc, $uploadPath);
          $insertSql = "INSERT INTO ttype (`type`, `description`, `image`) VALUES ('$type', '$description', '$dbPath')";
          $db->query($insertSql);
          header('Location: type.php');
        }

      }


  ?>
  <h3 class="text-center"><?=((isset($_GET['edit']))?'ویرایش':'افزودن')?> موضوع</h3><hr>
  <form action="type.php?add=1" method="POST" enctype="multipart/form-data">
    <div class="col">
    <div class="row">
      <div class="form-group col-md-3">
        <label for="typen">Type*:</label>
        <input type="text" name="typen" id="typen" class="form-control" value="<?=((isset($_POST['typen']))?sanitize($_POST['typen']):'')?>"/>
      </div>
      <div class="form-group col-md-3">
        <label for="description">Description*:</label>
        <textarea id="description" name="description" class="form-control" rows=6><?=((isset($_POST['description']))?sanitize($_POST['description']):'')?></textarea>
      </div>
      </div>
      <div class="form-group col-md-3">
        <label for="photo">Type photo*:</label>
        <input type="file" id="photo" name="photo" class="form-control">
      </div>
      <div class="col-md-3 col">
        <div class=""><a href="type.php" class="post-title">Cancel</a>
      <input type="submit" value="ADD Type" class="form-control btn btn-success">
    </div><div class="clearfix"></div>
    </div>
</form>
<?php
    }else{
      $sql = "SELECT * FROM ttype ORDER BY type";
      $pquery = $db->query($sql);
  ?>
    <h1 class="text-center">دسته بندی اخبار</h1><hr>
    <div class="text-right" id="add-product-btn">
    <a href="type.php?add=1" class="btn btn-success pull-right">افزودن خبر</a><div class="clearfix"></div>
  </div><hr>
    <center>
    <div class="col-sm-2">
    <table align="center" class="table table-bordered table-striped table-auto text-right">
      <thead>
          <th>انواع خبر</th><th></th>
      </thead>
      <tbody>
        <?php while ($result = mysqli_fetch_assoc($pquery)) : ?>
        <tr>
          <td><?php echo $result['type'] ?></td>
          <td><a href="type.php?delete=<?=$result['type']?>">حذف</a></td>
        </tr>
      <?php endwhile;  ?>
      </tbody>
    </table>
    </div>
  </center>
<?php } include 'includes/footer.php'; ?>
