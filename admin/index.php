<?php
    require_once '../core/init.php';
    if(!is_logged_in()){
      header('Location: login.php');
    }
    include 'includes/head.php';
    include 'includes/navigation.php';
?>
<center>
    <h1 class="text-center">به پنل مدیریت خوش آمدید</h1><hr>
  </center>
<?php include 'includes/footer.php'; ?>
