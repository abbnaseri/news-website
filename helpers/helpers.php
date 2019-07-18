<?php
function display_errors($errors){
  $dispaly = '<ul class="bg-danger">';
  foreach($errors as $error){
    $dispaly .= '<li class="danger">'.$error.'</li>';
  }
  $dispaly .= '</ul>';
  return $dispaly;
}

function sanitize($dirty){
  return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}


function login($user_id){
  $_SESSION['SBUser'] = $user_id;
  global $db;
  $date = date("Y-m-d H:i:s");
  $db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
  $_SESSION['success_flash'] = 'You are now logged in!';
  header('Location: index.php');
}

function is_logged_in(){
  if (isset($_SESSION['SBUser']) && $_SESSION['SBUser'] >0) {
    return true;
  }
  return false;
}


function login_error_redirect($url = 'login.php'){
  $_SESSION['error_flash'] = 'You dont have permission to access that page';
  header('Location: '.$url);
}

function permission_error_redirect($url = 'login.php'){
  $_SESSION['error_flash'] = 'You must be logged in to access that page';
  header('Location: '.$url);
}


function has_permission($permission = 'admin'){
  global $user_data;
  $permissions = explode(',',$user_data['permissions']);var_dump($permissions);die();
  if(in_array($permission,$permissions,true)){
    return true;
  }
  return false;
}
