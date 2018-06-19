<?php 
	include_once "VT_DATA.php";

	$kategori_AD = $_POST["kategori_adi"];

	 function CODEING($text){

		$kod_create = "";
	if(strlen($text) >= 5){

		$kod_create  = mb_strtoupper(mb_substr($text, 0,1));
		$kod_create .= mb_strtoupper(mb_substr($text,3,1));
		$kod_create .= mb_strtoupper(mb_substr($text,5,1));
	}else {
		$kod_create  = mb_strtoupper(mb_substr($text, 0,1));
		$kod_create .= mb_strtoupper(mb_substr($text,3,1));
	}
		return $kod_create."-SLM-";
}//FUNCTION ->


$insertPDO = null;
	try{

	$insertPDO = new PDO("mysql:host=".VT_HOST.";dbname=".VT_DB.";charset=utf8",VT_USER,VT_PASS);
	$insertPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$insertPDO->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,"SET NAMES UTF8");

echo $kategori_AD;
	$insertPDO->beginTransaction();


	$image = "";
	$parent_id = 0;
	$top = 1;
	$columni = 1;
	$sort_order = 0;
	$status = 1;
	$date_added = date("y-m-d H:i:s");
	$date_modified = date("y-m-d H:i:s");

	$isle = $insertPDO->prepare("INSERT INTO sl_category(image,parent_id,top,/*column,*/sort_order,status,date_added,date_modified) VALUES (:image,:parent_id,:top,/*:column,*/:sort_order,:status,:date_added,:date_modified)");

    $isle->bindParam(":image",$image);
	$isle->bindParam(":parent_id",$parent_id);
	$isle->bindParam(":top",$top);
	//$isle->bindParam(":column",$columni);
	$isle->bindParam(":sort_order",$sort_order);
	$isle->bindParam(":status",$status);
	$isle->bindParam(":date_added",$date_added);
	$isle->bindParam(":date_modified",$date_modified);
	$isle->execute();


////////////////////////////////////////////////////
	$Categori_ID = $insertPDO->lastInsertId();
	$language_id = 2;
	$meta_title = $kategori_AD;

	$isle2 = $insertPDO->prepare("INSERT INTO sl_category_description
									(category_id,language_id,name,meta_title,urun_kodu)
									VALUES (:category_id,:language_id,:name,:meta_title,:urun_kodu)");
	$isle2->bindParam(":category_id",$Categori_ID,PDO::PARAM_INT);
	$isle2->bindParam(":language_id",$language_id,PDO::PARAM_INT);
	$isle2->bindParam(":name",$kategori_AD,PDO::PARAM_STR);
	$isle2->bindParam(":meta_title",$meta_title,PDO::PARAM_STR);
	$isle2->bindParam(":urun_kodu",CODEING($kategori_AD));
	$isle2->execute();
////////////////////////////////////////////////////////

	$language_id = 1;
	$meta_title = $kategori_AD;

	$isle3 = $insertPDO->prepare("INSERT INTO sl_category_description
									(category_id,language_id,name,meta_title)
									VALUES (:category_id,:language_id,:name,:meta_title)");
	$isle3->bindParam(":category_id",$Categori_ID,PDO::PARAM_INT);
	$isle3->bindParam(":language_id",$language_id,PDO::PARAM_INT);
	$isle3->bindParam(":name",$kategori_AD,PDO::PARAM_STR);
	$isle3->bindParam(":meta_title",$meta_title,PDO::PARAM_STR);
	$isle3->execute();

	////////////////////////////////////////////

		$store_id = 0;


		$isle4 = $insertPDO->prepare("INSERT INTO sl_category_to_store (category_id,store_id) 
									VALUES (:category_id,:store_id)");
		$isle4->bindParam(":category_id",$Categori_ID,PDO::PARAM_INT);
		$isle4->bindParam(":store_id",$store_id,PDO::PARAM_INT);
		$isle4->execute();

	//////////////////////////////////////////////////////////

		$layout_id = 0;

		$isle5 = $insertPDO->prepare("INSERT INTO sl_category_to_layout (category_id,store_id,layout_id)
									VALUES (:category_id,:store_id,:layout_id)");
		$isle5->bindParam(":category_id",$Categori_ID,PDO::PARAM_INT);
		$isle5->bindParam(":store_id",$store_id,PDO::PARAM_INT);
		$isle5->bindParam(":layout_id",$layout_id,PDO::PARAM_INT);
		$isle5->execute();

		//////////////////////////////////////////////////////////////////////////

		$path_id = $Categori_ID;
		$level = 0;

		$isle6 = $insertPDO->prepare("INSERT INTO sl_category_path (category_id,path_id,level)
									VALUES (:category_id,:path_id,:level)");
		$isle6->bindParam(":category_id",$Categori_ID,PDO::PARAM_INT);
		$isle6->bindParam(":path_id",$path_id,PDO::PARAM_INT);
		$isle6->bindParam(":level",$level,PDO::PARAM_INT);
		$isle6->execute();

	///////////////////////////////////////////
	$insertPDO->commit();
	echo "KATEGORI SAVE";
	}catch(PDOException $pdoet){

		 $insertPDO->rollBack();
		 ECHO "verı ekleme hatalandı". $pdoet->getMessage();
	}finally{

	}
	

?>