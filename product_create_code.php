<?php

  if(is_file("VT_DATA.php")){
     include_once "VT_DATA.php";
  }
  $pdovt = null;


  $secilenKategori=htmlspecialchars(trim($_POST["ktg_scm"],""));
  //ESKI YONTEM DI BU ŞİMDİ YENİ YONTEME GECİCEM BU YORUM SATIRI OLARAK KALICAK
 /* if(isset($secilenKategori)){

      switch ($secilenKategori) {
        case "Lokumlar":
          $secilenKategori = "LKM-SLM-";
            break;
          case "Meyveli Şekerlemeler":
          $secilenKategori = "MYV-SLM-";
            break;
          case "Şekerlemeler":
          $secilenKategori = "SKR-SLM-";
            break;
            case "Baharatlar":
          $secilenKategori = "BRT-SLM-";
            break;
            case "Çerezler":
          $secilenKategori = "CRZ-SLM-";  
            break;

        default:
          echo "KATEGORI DISINDA SEÇİLDİ VEYA BASKA BIR HATA <br/>";
          return;
          
          break;
      }//switch  
*/
       try{

    $pdovt = new PDO("mysql:host=".VT_HOST.";dbname=".VT_DB.";charset=utf8",VT_USER,VT_PASS);
    $pdovt->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdovt->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,"SET NAMES UTF8");

     $show_catgry_code = $pdovt->prepare("SELECT urun_kodu FROM sl_category_description 
                                                            WHERE language_id = 2 AND name = '$secilenKategori'");
     $show_catgry_code->execute();
     while($v = $show_catgry_code->fetch(PDO::FETCH_ASSOC)){
        $secilenKategori = $v["urun_kodu"];

     }//WHILE


    
    $show_product = $pdovt->prepare("SELECT * FROM sl_product WHERE model LIKE '%$secilenKategori%' 
                                                                            ORDER BY product_id DESC LIMIT 1");

   $show_product->execute();
   $satirSayisi = $show_product->rowCount();

   if($satirSayisi != 0){
   	while($dinle = $show_product->fetch(PDO::FETCH_ASSOC)){
   	if(strlen($dinle["model"]) == 10){

   		$idCodecreate =  mb_substr($dinle["model"],-2);
   		$idCodecreate += 1;
   		echo $secilenKategori."".$idCodecreate;

   	}else{
   		$idCodecreate =  mb_substr($dinle["model"],-1);
   		$idCodecreate += 1;
   		echo $secilenKategori."".$idCodecreate;
   	}
   		}//WHILE
   
   }else{
   			echo $secilenKategori."1";	
   	
   }
   

  }catch(PDOException $pdoe){
      print $pdoe->getMessage();
  }finally{

  }
  /*}else{
    echo "KATEGORI SECILEMEDI";
  }*/

 

    
?>
