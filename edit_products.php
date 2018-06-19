<?php

header("Content-type= application/json");
  if(file_exists("VT_DATA.php")){
    include_once "VT_DATA.php";
  }else{
    echo "yok";
  }

/*
if(isset($_POST["urun_ID"])){
  $gelen_ID = $_POST["urun_ID"];  //urun ıd GELECEK VERILER ONA GORE CEKILECEK
}else if(empty($_POST["urun_ID"])){

  echo "Duzenleme Sorunu";
}
*/

  $baglantiPDO = null;
  try{
    $baglantiPDO = new PDO("mysql:host=".VT_HOST.";dbname=".VT_DB.";charset=utf8",VT_USER,VT_PASS);
    $json_veriler = array();

    $sorgulama_resim = $baglantiPDO->prepare("SELECT * FROM sl_product_image AS pr_image WHERE pr_image.product_id = 50 ");
    //$sorgulama_resim->bindParam(2,":product_NUM",PDO::PARAM_INT);
    $sorgulama_resim->execute();

    while($satir = $sorgulama_resim->fetch(PDO::FETCH_ASSOC)){
      $e = array();
      $e["prdct_image"] =$satir["image"];
      array_push($json_veriler,$e);
    }

  }catch(PDOException $pdoex){
    print $pdoex;
  }finally{

  }
    echo json_encode($json_veriler);

?>
