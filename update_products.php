<?php

  if(is_file("VT_DATA.php")){
    require_once "VT_DATA.php";
  }else{
    echo "VT_DATA.php bulunamadı.";
    return;
  }
$urun_kodu = $_POST["urun_kodu"];

  $urun_NO =  $_POST["prdct_ID"];
  $urun_ismi =  $_POST["urun_ismi"];
  $birim_fiyati = $_POST["birim_fiyati"];
  $secilen_kategori = $_POST["secilen_kategori"];
  $urun_yayin_durumu = $_POST["urun_yayinlama_durumu"];
  $secilen_dil = 2;

   
 $guncellePDO = null;
 try{

  $guncellePDO = new PDO("mysql:host=".VT_HOST.";dbname=".VT_DB.";charset=utf8",VT_USER,VT_PASS);
  $guncellePDO->beginTransaction();

if(isset($_POST["resim1"])){
	$urun_resmi1 = "catalog/$urun_kodu-1.jpg";
  $update_prdDesc0 = $guncellePDO->prepare("UPDATE sl_product SET status = :status,
  																  price = :price,
  																  image = :image
  															  WHERE product_id = :product_id");
  $update_prdDesc0->bindParam(":status",$urun_yayin_durumu,PDO::PARAM_INT);
  $update_prdDesc0->bindParam(":price",$birim_fiyati,PDO::PARAM_INT);
  $update_prdDesc0->bindParam(":product_id",$urun_NO,PDO::PARAM_INT);
  $update_prdDesc0->bindParam(":image",$urun_resmi1,PDO::PARAM_STR);
  $update_prdDesc0->execute();
  	//RESIM SUNUCUYA KAYDEDİLİYOR
	$kod1 = $_POST["resim1"];
	if(is_file("../image/$urun_resmi1")){
		unlink("../image/$urun_resmi1");
	    file_put_contents("../image/catalog/$urun_kodu-1.jpg",base64_decode($kod1));
	}else{
		 file_put_contents("../image/catalog/$urun_kodu-1.jpg",base64_decode($kod1));
	}	

}else{
	  $update_prdDesc0 = $guncellePDO->prepare("UPDATE sl_product SET status = :status,
  																  price = :price 
  															  WHERE product_id = :product_id");
  $update_prdDesc0->bindParam(":status",$urun_yayin_durumu,PDO::PARAM_INT);
  $update_prdDesc0->bindParam(":price",$birim_fiyati,PDO::PARAM_INT);
  $update_prdDesc0->bindParam(":product_id",$urun_NO,PDO::PARAM_INT);
  $update_prdDesc0->execute();
}

  $update_prdDesc1 = $guncellePDO->prepare("UPDATE sl_product_to_category SET category_id = :kategori_numarasi
 																				 WHERE product_id = :urunID");
 $update_prdDesc1->bindParam(":kategori_numarasi",$secilen_kategori,PDO::PARAM_INT);
 $update_prdDesc1->bindParam(":urunID",$urun_NO,PDO::PARAM_INT);
 $update_prdDesc1->execute();


  $update_prdDesc = $guncellePDO->prepare("UPDATE sl_product_description AS prdc_desc 
  															SET 
  															prdc_desc.name = :name,
  															prdc_desc.language_id = :lang_id,
  															prdc_desc.meta_title = :meta_title
  															WHERE prdc_desc.product_id = :prdct_id AND prdc_desc.language_id = :lang_id_where");
  $update_prdDesc->bindParam(":name",$urun_ismi,PDO::PARAM_STR);
  $update_prdDesc->bindParam(":lang_id",$secilen_dil,PDO::PARAM_INT);
  $update_prdDesc->bindParam(":meta_title",$urun_ismi,PDO::PARAM_STR);
  $update_prdDesc->bindParam(":prdct_id",$urun_NO,PDO::PARAM_INT); 
  $update_prdDesc->bindParam(":lang_id_where",$secilen_dil,PDO::PARAM_INT);
  $update_prdDesc->execute();	


if(isset($_POST["resim2"])){
		$sort_order = 1;
		$urun_resmi2 = "catalog/$urun_kodu-2.jpg";
		$kod2 = $_POST["resim2"];

 		if(is_file("../image/$urun_resmi2")){
				unlink("../image/$urun_resmi2");
			    file_put_contents("../image/catalog/$urun_kodu-2.jpg",base64_decode($kod2));

			        $islem5 = $guncellePDO->prepare("UPDATE sl_product_image AS prdc_img SET 
																				prdc_img.image = :image
																				WHERE 
																				prdc_img.product_id = :product_id
																				AND
																				prdc_img.sort_order = :sort_order");
			$islem5->bindParam(":product_id",$urun_NO,PDO::PARAM_INT);
			$islem5->bindParam(":image",$urun_resmi2,PDO::PARAM_STR);
			$islem5->bindParam(":sort_order",$sort_order,PDO::PARAM_INT);
			$islem5->execute();
	   }else{
		 	    file_put_contents("../image/catalog/$urun_kodu-2.jpg",base64_decode($kod2));

			 	    $islem5 = $guncellePDO->prepare("INSERT INTO sl_product_image (product_id,image,sort_order) 
																VALUES 	(:product_id,:image,:sort_order)");
			$islem5->bindParam(":product_id",$urun_NO,PDO::PARAM_INT);
			$islem5->bindParam(":image",$urun_resmi2,PDO::PARAM_STR);
			$islem5->bindParam(":sort_order",$sort_order,PDO::PARAM_INT);
			$islem5->execute();
	
	   }	

		
}

if(isset($_POST["resim3"])){

		$sort_order = 2;
		$urun_resmi3 = "catalog/$urun_kodu-3.jpg";
		$kod3 = $_POST["resim3"];

		if(is_file("../image/$urun_resmi3")){
			unlink("../image/$urun_resmi3");
	    file_put_contents("../image/catalog/$urun_kodu-3.jpg",base64_decode($kod3));

	   $islem6 = $guncellePDO->prepare("UPDATE sl_product_image AS prdc_img SET 
																				prdc_img.image = :image
																				WHERE 
																				prdc_img.product_id = :product_id
																				AND
																				prdc_img.sort_order = :sort_order");
		$islem6->bindParam(":product_id",$urun_NO,PDO::PARAM_INT);
		$islem6->bindParam(":image",$urun_resmi3,PDO::PARAM_STR);
		$islem6->bindParam(":sort_order",$sort_order,PDO::PARAM_INT);
		$islem6->execute();
	}else{
		 file_put_contents("../image/catalog/$urun_kodu-3.jpg",base64_decode($kod3));

		 $islem6 = $guncellePDO->prepare("INSERT INTO sl_product_image (product_id,image,sort_order) 
															VALUES 	(:product_id,:image,:sort_order)");
		$islem6->bindParam(":product_id",$urun_NO,PDO::PARAM_INT);
		$islem6->bindParam(":image",$urun_resmi3,PDO::PARAM_STR);
		$islem6->bindParam(":sort_order",$sort_order,PDO::PARAM_INT);
		$islem6->execute();
	}
	 

		
	
		
}
 

//AKTIF ISE EKLE
//PASIF ISE SIL

  /*if($urun_yayin_durumu == 1){
       $categori_id = 0;
       $islem4=$update_prdDesc->prepare("INSERT INTO sl_product_to_store (product_id,store_id) VALUES (:product_id,:category_id)");
       $islem4->bindParam(":product_id",$product_ID,PDO::PARAM_INT);
       $islem4->bindParam(":category_id",$categori_id,PDO::PARAM_INT);
       $islem4->execute();
 }else if($urun_yayin_durumu == 0){
     $update_prdDesc2 = $guncellePDO->exec("DELETE FROM sl_product_to_store WHERE product_id = :product_id");
     $update_prdDesc2->bindParam(":product_id",$urun_NO,PDO::PARAM_INT);
 }
*/

/* SUAN IHTIYACIMIZ YOK
  $update_prdImage =  $guncellePDO->exec("UPDATE sl_product_image AS prdc_img SET prdc_desc.image = :pr_image
                                                WHERE prdc_img.product_id = :image_id AND prdc_img.sort_order = 1");
  $update_prdImage->bindParam(":pr_image","VERI",PDO::PARAM_STR);
  $update_prdImage->bindParam(":image_id","VERI",PDO::PARAM_STR);

  $update_prdImage2 =  $guncellePDO->exec("UPDATE sl_product_image AS prdc_img SET prdc_desc.image = :pr_image2
                                                WHERE prdc_img.product_id = :image_id2 AND prdc_img.sort_order = 2");
  $update_prdImage2->bindParam(":pr_image2","VERI",PDO::PARAM_STR);
  $update_prdImage2->bindParam(":image_id2","VERI",PDO::PARAM_STR);
*/


$guncellePDO->commit();
echo "BAŞARILI Guncelleme";

 }catch(PDOException $pdoexp){
   //print $pdoexp;
 	echo "HATALANDI PHP HA";
   $guncellePDO->rollBack();
 }finally{

 }

?>
