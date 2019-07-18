<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/webnews/core/init.php';
    if(!is_logged_in()){
      login_error_redirect();
    }
    include 'includes/head.php';
    include 'includes/navigation.php';

    if (isset($_GET['delete'])) {
      $id = sanitize($_GET['delete']);
      $db->query("DELETE FROM news WHERE id='$id'");
    }
    $dbPath = '';
    if (isset($_GET['add']) || isset($_GET['edit'])){
      $typeQuery = $db->query("SELECT * FROM ttype");
      $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
      $prenews = ((isset($_POST['preNews']) && $_POST['preNews'] != '')?sanitize($_POST['prenews']):'');
      $textBody = ((isset($_POST['textBody']) && $_POST['textBody'] != '')?sanitize($_POST['textBody']):'');
      $type1 = ((isset($_POST['type']) && $_POST['type'] != '')?sanitize($_POST['type']):'');
      $daten = ((isset($_POST['daten']) && $_POST['daten'] != '')?sanitize($_POST['daten']):'');
      $timen = ((isset($_POST['timen']) && $_POST['timen'] != '')?sanitize($_POST['timen']):'');
      $source = ((isset($_POST['source']) && $_POST['source'] != '')?sanitize($_POST['source']):'');
      $scope = ((isset($_POST['scope']) && $_POST['scope'] != '')?sanitize($_POST['scope']):'');
      $sourceLink = ((isset($_POST['sourcelink']) && $_POST['sourcelink'] != '')?sanitize($_POST['sourcelink']):'');
      $saved_image = '';
      if (isset($_GET['edit'])) {
        $edit_id = (int)$_GET['edit'];
        $newsResults = $db->query("SELECT * FROM news WHERE id='$edit_id'");
        $news = mysqli_fetch_assoc($newsResults);
        if (isset($_GET['delete_image'])) {
          $image_url = $_SERVER['DOCUMENT_ROOT'].$news['image'];echo $image_url;
          unlink($image_url);
          $db->query("UPDATE news SET image = '' WHERE id = '$edit_id'");
          header('Location: addnews.php?edit='.$edit_id);
        }
        $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$news['title']);
        $prenews = ((isset($_POST['prenews']) && $_POST['prenews'] != '')?sanitize($_POST['prenews']):$news['prenews']);
        $textBody = ((isset($_POST['textBody']) && $_POST['textBody'] != '')?sanitize($_POST['textBody']):$news['textBody']);
        $type1 = ((isset($_POST['type']) && $_POST['type'] != '')?sanitize($_POST['type']):$news['type']);
        $daten = ((isset($_POST['daten']) && $_POST['daten'] != '')?sanitize($_POST['daten']):$news['daten']);
        $timen = ((isset($_POST['timen']) && $_POST['timen'] != '')?sanitize($_POST['timen']):$news['timen']);
        $source = ((isset($_POST['source']) && $_POST['source'] != '')?sanitize($_POST['source']):$news['source']);
        $scope = ((isset($_POST['scope']) && $_POST['scope'] != '')?sanitize($_POST['scope']):$news['scope']);
        $sourceLink = ((isset($_POST['sourcelink']) && $_POST['sourcelink'] != '')?sanitize($_POST['sourcelink']):$news['sourcelink']);
        $saved_image = (($news['image'] != '')?$news['image']:'');
        $dbPath = $saved_image;
      }
      if ($_POST) {
        $title = sanitize($_POST['title']);
        $prenews = sanitize($_POST['prenews']);
        $textBody = sanitize($_POST['textBody']);
        $type1 = sanitize($_POST['type']);
        $daten = sanitize($_POST['daten']);
        $timen = sanitize($_POST['timen']);
        $source = sanitize($_POST['source']);
        $sourceLink = sanitize($_POST['sourcelink']);
        $scope = sanitize($_POST['scope']);
        $errors = array();
        $required = array('title', 'prenews', 'textBody', 'source', 'scope', 'sourcelink', 'type', 'daten', 'timen');
        foreach ($required as $field) {
          if ($_POST[$field] == '') {
            $errors[] = 'All Fields With and Astrisk are required.';
            break;
          }
        }
        if (!empty($_FILES)) {
          var_dump($_FILES);
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
          $uploadPath = BASEURL.'images/imgnews/'.$uploadName;
          $dbPath = '/webnews/images/imgnews/'.$uploadName;
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
          echo display_errors($errors);
        }else {
          move_uploaded_file($tmpLoc, $uploadPath);
          $insertSql = "INSERT INTO news (`title`, `prenews`, `textBody`, `image`, `source`, `scope`, `sourcelink`, `type`, `timen`, `daten`) VALUES ('$title', '$prenews','$textBody', '$dbPath', '$source',
             '$scope', '$sourceLink', '$type1', '$timen', '$daten')";
             if (isset($_GET['edit'])) {
               $insertSql = "UPDATE news SET title = '$title', prenews = '$prenews', textBody = '$textBody', image = '$dbPath', source = '$source', scope = '$scope', sourcelink = '$sourceLink', type = '$type1',
               timen = '$timen', daten = '$daten' WHERE id = '$edit_id'";
             }
          $db->query($insertSql);
          header('Location: addnews.php');
        }
      }
?>
    <hr><h2 class="text-center"><?=((isset($_GET['edit']))?'ویرایش':'افزودن');?> اخبار</h2><hr>
    <form action="addnews.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
      <div class="col">
      <div class="row">
        <div class="form-group col-md-3">
          <label for="title">Title*:</label>
          <textarea name="title" class="form-control" id="title" rows=6><?=$title?></textarea>
        </div>
        <div class="form-group col-md-3">
          <label for="prenews">Abstract*:</label>
          <textarea id="prenews" name="prenews" class="form-control" rows=6><?=$prenews;?></textarea>
        </div>
        <div class="form-group col-md-3">
          <label for="textBody">text Body*:</label>
          <textarea id="textBody" name="textBody" class="form-control" rows=6><?=$textBody;?></textarea>
        </div>
    </div>
    <div class="row">
      <div class="form-group col-sm-2">
        <label for="type">Type*:</label>
        <select class="form-control" id="type" name="type">
          <option value=""<?=(($type1 == '')?' selected':'')?>></option>
            <?php while($type = mysqli_fetch_assoc($typeQuery)): ?>
            <option value="<?=$type['type'];?>"<?=(($type1 == $type['type'])?' selected':'')?>><?=$type['type'];?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group col-sm-2">
        <label for="daten">Date*:</label>
        <input type="date" name="daten" id="daten" class="form-control" value="<?=$daten;?>">
      </div>
      <div class="form-group col-sm-2">
        <label for="timen">Time*:</label>
        <input type="text" name="timen" id="timen" class="form-control" value="<?=$timen;?>">
      </div>
    </div>
    <div class="row">
      <div class="form-group col-sm-2">
        <label for="source">source*:</label>
        <input type="text" name="source" id="source" class="form-control" value="<?=$source;?>">
      </div>
      <div class="form-group col-sm-2">
        <label for="sourcelink">sourcelink*:</label>
        <input type="text" name="sourcelink" id="sourcelink" class="form-control" value="<?=$sourceLink?>">
      </div>
      <div class="form-group col-sm-2">
        <label for="scope">scope*:</label>
        <input type="text" name="scope" id="scope" class="form-control" value="<?=$scope?>">
      </div>
    </div>
    <div class="form-group col-md-4">
      <?php   if($saved_image != ''): ?>
        <div class="saved-image"><img src="<?=$saved_image;?>" alt="saved image"/><br>
          <a href="addnews.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
        </div>
      <?php else: ?>
      <label for="photo">News Photo:</label>
      <input type="file" name="photo" id="photo" class="form-control">
    <?php endif; ?>
    </div>
  </div>
  <div class="col-md-3 col">
    <div class=""><a href="addnews.php" class="post-title">Cancel</a>
  <input type="submit" value="<?=((isset($_GET['edit']))?'Edit news':'Add news');?>" class="form-control btn btn-success">
</div><div class="clearfix"></div>
    </form>
  <?php  }else{
    $sql = "SELECT * FROM news WHERE deleted = 0";
    $presults = $db->query($sql);
  ?>
    <h1 class="text-center">اخبار</h1><hr>
    <div class="text-right" id="add-product-btn">
    <a href="addnews.php?add=1" class="btn btn-success pull-right">افزودن خبر</a><div class="clearfix"></div>
  </div>
    <hr>
    <table align="right" class="table table-bordered table-condensed table-striped text-right">
      <thead><th></th><th>ساعت</th><th>تاریخ</th><th>موضوع</th><th>تیتر</th><th>شماره</th></thead>
      <tbody>
        <?php while($product = mysqli_fetch_assoc($presults)): ?>
          <tr>
            <td class="text-left">
              <a href='addnews.php?delete=<?=$product['id']?>'><span style="display:inline-block; width: YOURWIDTH;">حذف</span></a></br>
              <a href='addnews.php?edit=<?=$product['id']?>'><span style="display:inline-block; width: YOURWIDTH;">ویرایش</span></a>
            </td>
            <td><?=$product['timen']?></td>
            <td><?=$product['daten']?></td>
            <td><?=$product['type']?></td>
            <td><?=$product['title']?></td>
            <td><?=$product['id']?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
</div>
<?php }include 'includes/footer.php'; ?>
