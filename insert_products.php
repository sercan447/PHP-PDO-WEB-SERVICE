<?php

include_once "VT_DATA.php";
  $insertPDO = null;
try{


$urun_ismi="";
if(isset($_POST["urun_ismi"])){
  $urun_ismi = $_POST["urun_ismi"];
}
$birim_fiyati="";
if(isset($_POST["birim_fiyati"])){
  $birim_fiyati = (int)$_POST["birim_fiyati"];
}
$urun_kodu="";
if(isset($_POST["urun_kodu"])){
  $urun_kodu = $_POST["urun_kodu"];
}

$secilen_kategori = "";
if(isset($_POST["secilen_kategori"])){
$secilen_kategori = $_POST["secilen_kategori"];
}
$urun_yayinlama_durumu = "";
if(isset($_POST["urun_yayinlama_durumu"])){
$urun_yayinlama_durumu = $_POST["urun_yayinlama_durumu"];
}


$image1 = "";
if(!empty($_POST["resim_kodu"])){
  $image1 = $_POST["resim_kodu"];
}
$image2="";
if(!empty($_POST["resim_kodu2"])){
  $image2 = $_POST["resim_kodu2"];
}
$image3="";
if(!empty($_POST["resim_kodu3"])){
  $image3 = $_POST["resim_kodu3"];
}
$insertPDO = new PDO("mysql:host=".VT_HOST.";dbname=".VT_DB.";charset=utf8",VT_USER,VT_PASS);
$insertPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$insertPDO->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,"SET NAMES UTF8");

/*'v',0,'OLUS.jpg'*/
//:model,:quantity,:image
//'$urun_kodu',$birim_fiyati,'$urun_resim_ismi'

$insertPDO->beginTransaction();

$urun_resmi = "catalog/$urun_kodu-1.jpg";
$urun_resmi2 = "catalog/$urun_kodu-2.jpg";
$urun_resmi3 = "catalog/$urun_kodu-3.jpg";
$status = 1;
$stock_status_id=6;
$weight_class_id = 1;
$length_class_id = 1;
$sort_order = 1;
$viewed =1;

$islem = $insertPDO->prepare("INSERT INTO sl_product
                                 (model,
                                  quantity,
                                  image,
                                  date_available,
                                  stock_status_id,
                                  weight_class_id,
                                  length_class_id,
                                  sort_order,
                                  status,
                                  viewed,
                                  date_added)
                          VALUES
                          (:model,
                           :quantity,
                           :image,
                           :date_available,
                           :stock_status_id,
                           :weight_class_id,
                           :length_class_id,
                           :sort_order,
                           :status,
                           :viewed,
                           :date_added)");
$islem->bindParam(":model",$urun_kodu,PDO::PARAM_STR);
$islem->bindParam(":quantity",$birim_fiyati,PDO::PARAM_INT);
$islem->bindParam(":image",$urun_resmi,PDO::PARAM_STR);
$islem->bindParam(":date_available",date("y-m-d"));
$islem->bindParam(":stock_status_id",$stock_status_id,PDO::PARAM_INT);
$islem->bindParam(":weight_class_id",$weight_class_id,PDO::PARAM_INT);
$islem->bindParam(":length_class_id",$length_class_id,PDO::PARAM_INT);
$islem->bindParam(":sort_order",$sort_order,PDO::PARAM_INT);
$islem->bindParam(":status",$urun_yayinlama_durumu,PDO::PARAM_INT);
$islem->bindParam(":viewed",$viewed,PDO::PARAM_INT);
$islem->bindParam(":date_added",date("y-m-d H:i:s"));

$islem->execute();

file_put_contents("../image/catalog/$urun_kodu-1.jpg",base64_decode($image1));

$product_ID = $insertPDO->lastInsertId();
$dil_ID = 2;
$name = $urun_ismi;
$meta_title = $urun_ismi;

$islem2 =  $insertPDO->prepare("INSERT INTO sl_product_description(product_id,language_id,name,meta_title) VALUES (:product_id,:language_id,:name,:meta_title)");
$islem2->bindParam(":product_id",$product_ID,PDO::PARAM_INT);
$islem2->bindParam(":language_id",$dil_ID,PDO::PARAM_INT);
$islem2->bindParam(":name",$name,PDO::PARAM_STR);
$islem2->bindParam(":meta_title",$meta_title,PDO::PARAM_STR);
$islem2->execute();

$islem3=$insertPDO->prepare("INSERT INTO sl_product_to_category (product_id,category_id) VALUES (:product_id,:category_id)");
$islem3->bindParam(":product_id",$product_ID,PDO::PARAM_INT);
$islem3->bindParam(":category_id",$secilen_kategori,PDO::PARAM_INT);
$islem3->execute();


$categori_id = 0;
$islem4=$insertPDO->prepare("INSERT INTO sl_product_to_store (product_id,store_id) 
													VALUES (:product_id,:category_id)");
$islem4->bindParam(":product_id",$product_ID,PDO::PARAM_INT);
$islem4->bindParam(":category_id",$categori_id,PDO::PARAM_INT);
$islem4->execute();

if(isset($_POST["resim_kodu2"])){

    $sort_order = 1;
    $islem5 = $insertPDO->prepare("INSERT INTO sl_product_image (product_id,image,sort_order) 
                              VALUES  (:product_id,:image,:sort_order)");
    $islem5->bindParam(":product_id",$product_ID,PDO::PARAM_INT);
    $islem5->bindParam(":image",$urun_resmi2,PDO::PARAM_STR);
    $islem5->bindParam(":sort_order",$sort_order,PDO::PARAM_INT);
    $islem5->execute();

     file_put_contents("../image/catalog/$urun_kodu-2.jpg",base64_decode($image2));
}



if(isset($_POST["resim_kodu3"])){
      $sort_order = 2;
    $islem6 = $insertPDO->prepare("INSERT INTO sl_product_image (product_id,image,sort_order) 
                              VALUES  (:product_id,:image,:sort_order)");
    $islem6->bindParam(":product_id",$product_ID,PDO::PARAM_INT);
    $islem6->bindParam(":image",$urun_resmi3,PDO::PARAM_STR);
    $islem6->bindParam(":sort_order",$sort_order,PDO::PARAM_INT);
    $islem6->execute();

     file_put_contents("../image/catalog/$urun_kodu-3.jpg",base64_decode($image3));
}



  
 
 

  if($islem2->rowCount() > 0){
    echo "BAŞARILI".$insertPDO->lastInsertId();
  }else{
    echo "KAYIT SORUNU";
  }

  $insertPDO->commit();
}catch(PDOException $pdoexp){

  $insertPDO->rollBack();
  echo "HATA ALINIYOR";

}finally{
  echo "FINALLY";
}




?>
