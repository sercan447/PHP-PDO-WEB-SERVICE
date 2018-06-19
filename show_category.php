<?php

if(file_exists("VT_DATA.php")){
  include_once "VT_DATA.php";
}else{
  print "VT_DATA INCLUDE SORUNU";
  return;
}
$baglanma = null;
try{

    $baglanma = new PDO("mysql:host=".VT_HOST.";dbname=".VT_DB.";charset=utf8",VT_USER,VT_PASS);
    $query = $baglanma->prepare("SELECT * FROM sl_category_description WHERE language_id=2 ORDER BY category_id DESC");
    $query->execute();


    $json_data = array();
      while($we = $query->fetch(PDO::FETCH_ASSOC)){
        $e = array();
        $e["categori_id"] = $we["category_id"];
        $e["kategori"] = $we["name"];
        //$e["meta_descripton"] = $we["meta_descripton"];

        array_push($json_data,$e);
      }

     print json_encode($json_data);
      //echo $json_data[0]["categori_id"];  //EN SON eklenen categorinin ID SI alınıyor.


}catch(PDOException $pdoe){
  print $pdoe->getMessage();
}finally{

}

?>
