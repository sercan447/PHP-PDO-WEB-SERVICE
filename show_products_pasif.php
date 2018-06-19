  <?php

  if(is_file("VT_DATA.php")){
    require_once "VT_DATA.php";
  }else{
    echo "yok";
  }

  $baglantiPDO = null;
  	//PASIF
  	$query = "SELECT prdct.product_id,
              prdct.model,
              prdct_desc.name,
              prdct.image,
              prdct.price,
              prdct.date_available,
              prdct.status,
              prdct_categ.category_id
              FROM sl_product AS prdct
              INNER JOIN sl_product_description AS prdct_desc
              INNER JOIN sl_product_to_category AS prdct_categ
              WHERE prdct.product_id = prdct_desc.product_id
              AND prdct_desc.language_id = 2
              AND prdct.product_id = prdct_categ.product_id
              AND prdct.status = 0
              GROUP BY prdct.product_id";


  try{
    $baglantiPDO = new PDO("mysql:host=".VT_HOST.";dbname=".VT_DB.";charset=utf8",VT_USER,VT_PASS);
    $sorgulama = $baglantiPDO->prepare($query);

    $sorgulama->execute();
    $json_veriler = array();

    while($rows = $sorgulama->fetch(PDO::FETCH_ASSOC)){
      $d = array();
      $d["product_id"] = $rows["product_id"];
      $d["model"] = $rows["model"];
      $d["name"] =  $rows["name"];
      $d["fiyat"] = $rows["price"];
      $d["tarih"] = $rows["date_available"];
      $d["yayin"] = $rows["status"];
      $d["kategori"] = $rows["category_id"];  
      $d["image"] = "http://alfatoptancilik.com/image/".$rows["image"];

      array_push($json_veriler,$d);

    }//WHILE
  }catch(PDOException $pdoex){
    print $pdoex;
  }finally{

  }

    echo json_encode($json_veriler);
    

?>
