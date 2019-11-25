<?php
  ini_set("display_errors", 1);
  
  if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
    $con = mysqli_connect("127.0.0.1", "root", "", "seguranca");

    $user = $_POST['user'];
    $password = $_POST['password'];
    $query = "SELECT user, pass 
              FROM users
              WHERE user = '$user'";

    $result = mysqli_query($con, $query);
    $rows = mysqli_fetch_array($result);
    $count = $result->num_rows; 

    $logged = false;
    $pass = $rows["pass"];

    if( $count > 0 ) {
      $logged = $pass == hash( "sha256", $password ); 
    }

    if( $logged ):
  ?>
      <script type="text/javascript">
        document.addEventListener("DOMContentLoaded",function(){
          new Noty({
            progressBar:false,
            timeout:3000,
            theme:'bootstrap-v4',
            type:'success',
            layout:'topCenter',
              text: 'Usuário Logado!',
          }).show();
        });
      </script>
  <?php 
    redirect( "products.php" ); 
    else :
    ?>
    <script type="text/javascript">
    document.addEventListener("DOMContentLoaded",function(){
      new Noty({
        progressBar:false,
        timeout:3000,
        theme:'bootstrap-v4',
        type:'warning',
        layout:'topCenter',
          text: 'Usuário ou senha incorretos!',
      }).show();
    });
    </script>
  <?php
    endif;
  }

  function redirect($url){
    if (headers_sent()){
      die('<script type="text/javascript">window.location=\''.$url.'\';</script‌​>');
    }else{
      header('Location: ' . $url);
      die();
    }    
}