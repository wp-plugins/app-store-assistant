<?php
define('DEBUG', false);


//hash_hmac code from comment by Ulrich in http://mierendo.com/software/aws_signed_query/
//sha256.inc.php from http://www.nanolink.ca/pub/sha256/ 

function appStore_amazon_link_handler ($atts,$content=null, $code="") {
	// Get App ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'asin' => '',
		'mode' => '',
		'textmode' => '',
		'showprice' => '',
		'linktext' => ''
	), $atts ) );

	//Don't do anything if the ASIN is blank or non-numeric
	if ($asin=='') return;
	
	$AmazonProductData = appStore_get_amazonData($asin);
	if($AmazonProductData) {
		$itemURLStart = '<a href="'.$AmazonProductData['URL'].'" target="_blank">';
		$itemTitle = $AmazonProductData['Title'];
		$itemPrice = $AmazonProductData['Amount'];
		
		// Get Default Text Link
		if($showprice=="yes") {		
			if($itemPrice == "Not Listed") {
				$itemLinkText = appStore_setting('amazon_textlink_default');
			} else {
				$itemLinkText = appStore_setting('amazon_textlink_price_default');
			}
		} else {
			$itemLinkText = appStore_setting('amazon_textlink_default');
		}

		// Check Text Mode
		switch ($textmode) {
			case "linktext":
				if(isset($linktext)) $itemLinkText = $linktext;	
				break;
			case "defaulttext":
				// Other options could go here	
				break;
			case "itemname":
				if(isset($itemTitle)) $itemLinkText = $itemTitle;	
				break;
		}

		if($showprice=="yes") $itemLinkText .= " $itemPrice";

		// Set Button Image
		$itemButtonImage = '<img src="'.plugins_url( 'images/amazon-buynow-button.png' , ASA_MAIN_FILE ).'" width="220" height="37" alt="'.$asin.'" />';

		switch ($mode) {
			case "text":
				$itemLink = $itemURLStart.$itemLinkText.'</a>';	
				break;
			case "button":
				$itemLink = $itemURLStart.$itemButtonImage.'</a>';	
				break;
			case "both":
				$itemLink = $itemURLStart.$itemLinkText.'</a><br /><br />'.$itemURLStart.$itemButtonImage.'</a><br /><br />';	
				break;
			default:
				$itemLink = $itemURLStart.$itemLinkText.'</a>';	
		}
	} else {
		$itemLink = "ERROR LOADING AMAZON.COM DATA (Check Settings)";
	}
	return $itemLink;
}

function appStore_amazon_handler( $atts,$content=null, $code="") {
	// Get App ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'asin' => '',
		'text' => ''
	), $atts ) );

	//Don't do anything if the ASIN is blank or non-numeric
	if ($asin=='') return;
	
	
	$AmazonProductData = appStore_get_amazonData($asin);	

	switch ($AmazonProductData['ProductGroup']) {
	case "Book":
		$amazonDisplayData = asa_displayAmazonBook($AmazonProductData);
		break;
	case "DVD":
		$amazonDisplayData = asa_displayAmazonDisc($AmazonProductData);
		break;
	default:
		$amazonDisplayData = asa_displayAmazonDefault($AmazonProductData);
	}
	return $amazonDisplayData;
}	
	
	
function appStore_get_amazonData($asin) {
	//Check to see if we have a cached version of the Amazon Product Data.
	$appStore_options = get_option('appStore_amazonData_' . $asin, 'NODATA');		
	
	if($appStore_options == 'NODATA' || $appStore_options['next_check'] < time()) {
		$appStore_options_data = appStore_page_get_amazonXML($asin);
		if($appStore_options_data['Error']) {
			$nextCheck = 10;
		} else {
			$nextCheck = time() + appStore_setting('cache_time_select_box');
			if(appStore_setting('cache_images_locally') == '1') {
				$appStore_options_data = appStore_save_amazonImages_locally($appStore_options_data);
			}
		}		
		
		$appStore_options = array('next_check' => $nextCheck, 'app_data' => $appStore_options_data);
		//echo "------SEALDEBUG----$asin-----".print_r($appStore_options_data,true).'---------------';//Debug
		update_option('appStore_amazonData_' . $asin, $appStore_options);
		
	}
	return $appStore_options['app_data'];
}

function appStore_getBestAmazonImage($asin) {
	$filename = false;
	$firstChoice = CACHE_DIRECTORY."Amazon/".$asin."/LargeImage.png";
	$secondChoice = CACHE_DIRECTORY."Amazon/".$asin."/LargeImage.jpg";
	$thirdChoice = CACHE_DIRECTORY."Amazon/".$asin."/MediumImage.png";
	$fourthChoice = CACHE_DIRECTORY."Amazon/".$asin."/MediumImage.jpg";
	$fifthChoice = CACHE_DIRECTORY."Amazon/".$asin."/SmallImage.png";
	$sixthChoice = CACHE_DIRECTORY."Amazon/".$asin."/SmallImage.jpg";
	$lastChoice = dirname( plugin_basename( __FILE__ ) )."/images/CautionIcon.png";

	if (file_exists($firstChoice)) {
		$filename = $firstChoice;
	} elseif(file_exists($secondChoice)) {
		$filename = $secondChoice;
	} elseif(file_exists($thirdChoice)) {
		$filename = $thirdChoice;
	} elseif(file_exists($fourthChoice)) {
		$filename = $fourthChoice;
	} elseif(file_exists($fifthChoice)) {
		$filename = $fifthChoice;
	} elseif(file_exists($sixthChoice)) {
		$filename = $sixthChoice;
	} elseif(file_exists($lastChoice)) {
		$filename = $lastChoice;
	}
	return $filename;
}

function appStore_save_amazonImages_locally($productData) {
	$asin = $productData['ASIN'];	


	//Save Non-Cached Images incase of problem
	$productData['SmallImage_cached'] = $productData['SmallImage'];
	$productData['MediumImage_cached'] = $productData['MediumImage'];
	$productData['LargeImage_cached'] = $productData['LargeImage'];	
	
	if($productData['SmallImage']) $bestImage = $productData['SmallImage'];
	if($productData['MediumImage']) $bestImage = $productData['MediumImage'];
	if($productData['LargeImage']) $bestImage = $productData['LargeImage'];
	$productData['imageFeatured'] = $bestImage;
	$productData['imageFeatured_cached'] = $bestImage;
	$productData['imageiOS'] = $bestImage;
	$productData['imageiOS_cached'] = $bestImage;
	$productData['imageWidget'] = $bestImage;
	$productData['imageWidget_cached'] = $bestImage;
	$productData['imageRSS'] = $bestImage;
	$productData['imageRSS_cached'] = $bestImage;
	$productData['imageLists'] = $bestImage;
	$productData['imageLists_cached'] = $bestImage;
	$productData['imagePosts'] = $bestImage;
	$productData['imagePosts_cached'] = $bestImage;
	$productData['imageElements'] = $bestImage;
	$productData['imageElements_cached'] = $bestImage;

	if(!is_writeable(CACHE_DIRECTORY)) {
		//Uploads dir isn't writeable. bummer.
		appStore_set_setting('cache_images_locally', '0');
		return;
	} else {
		if(!is_dir(CACHE_DIRECTORY ."Amazon/". $asin)) {
			if(!mkdir(CACHE_DIRECTORY ."Amazon/". $asin, 0755, true)) {
				appStore_set_setting('cache_images_locally', '0');
				return;	
			}
		}
		$urls_to_cache = array();
		if($productData['SmallImage']) $urls_to_cache['SmallImage'] = $productData['SmallImage'];
		if($productData['MediumImage']) $urls_to_cache['MediumImage'] = $productData['MediumImage'];
		if($productData['LargeImage']) $urls_to_cache['LargeImage'] = $productData['LargeImage'];

		foreach($urls_to_cache as $urlname=>$url) {
			$content = appStore_fopen_or_curl($url);
			$info = pathinfo(basename($url));
			$Newpath = CACHE_DIRECTORY ."Amazon/". $asin . '/' . $urlname.".".$info['extension'];
			$Newurl = CACHE_DIRECTORY_URL ."Amazon/". $asin . '/' . $urlname.".".$info['extension'];
			
			if($fp = fopen($Newpath, "w+")) {
				fwrite($fp, $content);
				fclose($fp);
				$productData[$urlname] = $Newurl;
			} else {
				//Couldnt write the file. Permissions must be wrong.
				appStore_set_setting('cache_images_locally', '0');
				return;
			}
		}
		
		$bestFilePath = appStore_getBestAmazonImage($asin);
		$bestFilePathParts = pathinfo($bestFilePath);
		$bestFileName = $bestFilePathParts['filename'];
		$bestFileExt = $bestFilePathParts['extension'];		
		$editor = wp_get_image_editor( $bestFilePath );
 		$size = $editor->get_size();
 		$filePrefix = "asaArtwork_";
		$filePath_Start = CACHE_DIRECTORY."Amazon/". $asin . '/'.$filePrefix;
		$fileURL_Start = CACHE_DIRECTORY_URL."Amazon/". $asin . '/'.$filePrefix;

 		if(appStore_setting('appicon_size_featured') < $size['width']) {
 			$newSize = appStore_setting('appicon_size_featured');
			$editor->resize( $newSize, $newSize, true );
		}
		$filename = $filePath_Start."featured.".$bestFileExt;
		$new_image_info = $editor->save($filename);
		$productData['imageFeatured_cached'] = $fileURL_Start."featured.".$bestFileExt;
		$productData['imageFeatured_path'] = $filePath_Start."featured.".$bestFileExt;

		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_ios') < $size['width']) {
 			$newSize = appStore_setting('appicon_size_ios');
			$editor->resize( $newSize, $newSize, true );
		}
		$filename = $filePath_Start."ios.".$bestFileExt;
		$new_image_info = $editor->save($filename);		
		$productData['imageiOS_cached'] = $fileURL_Start."featured.".$bestFileExt;

		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_rss') < $size['width']) {
 			$newSize = appStore_setting('appicon_size_rss');
			$editor->resize( $newSize, $newSize, true );
		}
		$filename = $filePath_Start."rss.".$bestFileExt;
		$new_image_info = $editor->save($filename);		
		$productData['imageRSS_cached'] = $fileURL_Start."featured.".$bestFileExt;
			
		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_lists') < $size['width']) {
 			$newSize = appStore_setting('appicon_size_lists');
			$editor->resize( $newSize, $newSize, true );
		}
		$filename = $filePath_Start."list.".$bestFileExt;
		$new_image_info = $editor->save($filename);		
		$productData['imageLists_cached'] = $fileURL_Start."featured.".$bestFileExt;

		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_posts') < $size['width']) {
 			$newSize = appStore_setting('appicon_size_posts');
			$editor->resize( $newSize, $newSize, true );
		}
		$filename = $filePath_Start."post.".$bestFileExt;
		$new_image_info = $editor->save($filename);		
		$productData['imagePosts_cached'] = $fileURL_Start."featured.".$bestFileExt;

		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_element') < $size['width']) {
 			$newSize = appStore_setting('appicon_size_element');
			$editor->resize( $newSize, $newSize, true );
		}
		$filename = $filePath_Start."element.".$bestFileExt;
		$new_image_info = $editor->save($filename);		
		$productData['imageElements_cached'] = $fileURL_Start."featured.".$bestFileExt;

	}
	return $productData;
}



function appStore_page_get_amazonXML($asin) {
	//Check to see if AWS Info is filled out in Admin Section
	if(appStore_setting('AWS_API_KEY') == "" || appStore_setting('AWS_API_SECRET_KEY') == "" || appStore_setting('AWS_PARTNER_DOMAIN') == "") {
		$AmazonProductData['asin'] = $asin;
		$AmazonProductData['Description'] = "Error Processing Amazon Item, please check admin settings via the Amazon.com tab.";
		$errorImage = plugins_url( 'images/CautionIcon.png' , ASA_MAIN_FILE );
		$AmazonProductData['SmallImage'] = $errorImage;
		$AmazonProductData['MediumImage'] = $errorImage;
		$AmazonProductData['LargeImage'] = $errorImage;
		$AmazonProductData['Title'] = "Error Message";
		$AmazonProductData['Error'] = "NoKeys";
		return $AmazonProductData;
	}

	$aws_public_api_key = appStore_setting('AWS_API_KEY');
	$aws_secret_api_key = appStore_setting('AWS_API_SECRET_KEY');
	$aws_partner_domain = appStore_setting('AWS_PARTNER_DOMAIN');

	if(appStore_setting('AWS_ASSOCIATE_TAG') == "") {
		$aws_associate_id = "thewebbedseal";
	}else{
		$aws_associate_id = appStore_setting('AWS_ASSOCIATE_TAG');
	}

	$apaapi_errors			= '';
	$apaapi_responsegroup 	= "ItemAttributes,Images,Offers,Reviews,EditorialReview,Tracks";
	$apaapi_operation 		= "ItemLookup";
	$apaapi_idtype	 		= "ASIN";
	$apaapi_id				= $asin;
	
	
	$pxml = aws_signed_request($aws_partner_domain,
		array("Operation"=>$apaapi_operation, 		
			  "ItemId"=>$apaapi_id,
			  "ResponseGroup" => $apaapi_responsegroup,
			  "IdType"=>$apaapi_idtype,
			  "AssociateTag"=>$aws_associate_id ),
			  $aws_public_api_key, $aws_secret_api_key);

	if(!is_array($pxml)){
		$pxml2=$pxml;
		$pxml = array();
		$pxml["itemlookuperrorresponse"]["error"]["code"]["message"] = $pxml2;
	}
	
	if(isset($pxml["itemlookuperrorresponse"]["error"]["code"])){
		$apaapi_errors = $pxml["itemlookuperrorresponse"]["error"]["code"]["message"];
	}
	
	if($apaapi_errors=='exceeded'){
		$AmazonProductData[0] = 'Requests Exceeded';
		$hiddenerrors = "<"."!-- HIDDEN AMAZON PAAPI ERROR: Requests Exceeded -->";
		if($extratext!=''){
			$AmazonProductData[1] = $hiddenerrors.$extratext;
		}
		$AmazonProductData[1] = $hiddenerrors;
	}elseif($apaapi_errors=='no signature match'){
		$AmazonProductData[0] = 'Signature does not match';
		$hiddenerrors = "<"."!-- HIDDEN AMAZON PAAPI ERROR: Signature does not match AWS Signature. Check AWS Keys and Signature method. -->";
		if($extratext!=''){
			$AmazonProductData[1] = $hiddenerrors.$extratext;
		}
		$AmazonProductData[1] = $hiddenerrors;
	}elseif($apaapi_errors=='not valid'){
		$AmazonProductData[0] = 'Not a valid item';
		$hiddenerrors = "<"."!-- HIDDEN AMAZON PAAPI ERROR: The ASIN is Not Valid or may not be available in your region. -->";
		if($extratext!=''){
			$AmazonProductData[1] = $hiddenerrors.$extratext;
		}
		$AmazonProductData[1] = $hiddenerrors;
	}elseif($apaapi_errors!=''){
		$AmazonProductData[0] = $apaapi_errors;
		$hiddenerrors = "<"."!-- HIDDEN AMAZON PAAPI ERROR: ". $apaapi_errors ."-->";
		if($extratext!=''){
			$AmazonProductData[1] = $hiddenerrors.$extratext;
		}
		$AmazonProductData[1] = $hiddenerrors;
	}else{
		$AmazonProductData = cleanAWSresults($pxml);
		//echo "<pre>";echo print_r($AmazonProductData, true);echo "</pre>";
		//echo "<pre>";echo print_r($pxml, true);echo "</pre>";
	}
	return $AmazonProductData;

}


function asa_displayAmazonDisc($Data){
	$displayAmazonDisc = "<!-- Disc Listing -->";

	$displayAmazonDisc .= '<div class="appStore-wrapper"><hr>';
	$displayAmazonDisc .= '	<div id="amazonStore-icon-container">';
	$displayAmazonDisc .= '    <a href="'.$Data['URL'].'" target="_blank"><img src="'.CACHE_DIRECTORY_URL.$Data['imagePosts'].'" alt="'.$Data['Title'].'" border="0" style="float: right; margin: 10px;" /></a>';
	$displayAmazonDisc .= '</div>';


	$displayAmazonDisc .= '<span class="amazonStore-title">'.$Data['Title']."</span><br />";
	if ($Data['Cast']) {
		$displayAmazonDisc .= '<span class="amazonStore-cast">'.$Data['Cast']."</span><br />";
	}
	if ($Data['Director']) {
		$displayAmazonDisc .= '<span class="amazonStore-cast">'.$Data['Director']."<br />";
	}
	if ($Data['Description']) {
		$displayAmazonDisc .= '<div class="amazonStore-description">'.$Data['Description'].'</div><br />';
	}
	if ($Data['Status']) {
		$displayAmazonDisc .= '<span class="amazonStore-status">'.__("Status",'appStoreAssistant').': '.$Data['Status'].'</span><br />';
	}
	if ($Data['ListPrice']) {
		$displayAmazonDisc .= '<span class="amazonStore-listprice-desc">'.__("List Price",'appStoreAssistant').': </span>';
		$displayAmazonDisc .= '<span class="amazonStore-listprice">'. $Data['ListPrice'] .'</span><br />';
	}
	if ($Data['Amount']) {
		$displayAmazonDisc .= '<span class="amazonStore-amazonprice-desc">'.__("Amazon Price",'appStoreAssistant').': </span>';
		$displayAmazonDisc .= '<span class="amazonStore-amazonprice">'. $Data['Amount'] .'</span><br />';
	}
	if (isset($Data->ItemAttributes->ReleaseDate)) {
		$displayAmazonDisc .= '<span class="amazonStore-date">'.__("Disc Released",'appStoreAssistant').': '.date("F j, Y",strtotime($Data->ItemAttributes->ReleaseDate)).'</span><br />';
	}
	if (isset($Data->ItemAttributes->TheatricalReleaseDate)) {
		$displayAmazonDisc .= '<span class="amazonStore-date">'.__("Theatrical Release",'appStoreAssistant').': '.date("F j, Y",strtotime($Data->ItemAttributes->TheatricalReleaseDate)).'</span><br />';
	}
	if($Data['Studio']) {
		$displayAmazonDisc .= '<span class="amazonStore-publisher">'.__("From",'appStoreAssistant').': '. $Data['Studio'] .'</span><br />';
	}

	$displayAmazonDisc .= '<br /><div align="center">';
	$displayAmazonDisc .= '<a href="'.$Data['URL'].'" TARGET="_blank">';
	$displayAmazonDisc .= '<img src="'.plugins_url( 'images/amazon-buynow-button.png' , ASA_MAIN_FILE ).'" width="220" height="37" alt="Buy Now at Amazon" />';
	//$displayAmazonDisc .= '<h2>Click here to view this item at Amazon.com</h2>';
	$displayAmazonDisc .= '</a></div>';
	$displayAmazonDisc .= '	<div style="clear:left;">&nbsp;</div>';
	$displayAmazonDisc .= '</div>';
	return $displayAmazonDisc;

}
function asa_displayAmazonBook($Data){
	$displayAmazonBook = "<!-- Book Listing -->";

	$displayAmazonBook .= '<div class="appStore-wrapper"><hr>';
	$displayAmazonBook .= '	<div id="amazonStore-icon-container">';
		if(appStore_setting('cache_images_locally') == '1') {
			$imageTag = $Data['imagePosts_cached'];
			if(wp_is_mobile()) $imageTag = $Data['imageiOS_cached'];
		} else {
			$imageTag = $Data['imagePosts'];
			if(wp_is_mobile()) $imageTag = $Data['imageiOS'];
		}		
	$displayAmazonBook .= '    <a href="'.$Data['URL'].'" target="_blank"><img src="'.$imageTag.'" alt="'.$Data['Title'].'" border="0" style="float: right; margin: 10px;" /></a>';
	$displayAmazonBook .= '</div>';

	$displayAmazonBook .= '<span class="amazonStore-title">'.$Data['Title']."</span><br />";

	if ($Data['Authors']) {
		$displayAmazonBook .= '<span class="amazonStore-cast">'.$Data['Authors'].'</span><br />';
	}

	if ($Data['Description']) {
		$displayAmazonBook .= '<div class="amazonStore-description">'.$Data['Description'].'</div><br />';
	}
	if ($Data['Publisher']) {
		$displayAmazonBook .= '<span class="amazonStore-publisher">'.__("Publisher",'appStoreAssistant').': '.$Data['Publisher'].'</span><br />';
	}
	if ($Data['Status']) {
		$displayAmazonBook .= '<span class="amazonStore-status">'.__("Status",'appStoreAssistant').': '.$Data['Status'].'</span><br />';
	}
	if ($Data['ListPrice']) {
		$displayAmazonBook .= '<span class="amazonStore-listprice-desc">'.__("List Price",'appStoreAssistant').': </span>';
		$displayAmazonBook .= '<span class="amazonStore-listprice">'. $Data['ListPrice'] .'</span><br />';
	}
	if ($Data['Amount']) {
		$displayAmazonBook .= '<span class="amazonStore-amazonprice-desc">'.__("Amazon Price",'appStoreAssistant').': </span>';
		$displayAmazonBook .= '<span class="amazonStore-amazonprice">'. $Data['Amount'] .'</span><br />';
	}
	if ($Data['ReleaseDate']) {
		$displayAmazonBook .= '<span class="amazonStore-date">'.__("Released",'appStoreAssistant').': '.date("F j, Y",strtotime($Data['ReleaseDate'])).'</span><br />';
	}

	if ($Data['PublishedDate']) {
		$displayAmazonBook .= '<span class="amazonStore-date">'.__("Published",'appStoreAssistant').': '.date("F j, Y",strtotime($Data['PublishedDate'])).'</span><br />';
	}
	$displayAmazonBook .= '<br><div align="center">';
	$displayAmazonBook .= '<a href="'.$Data['URL'].'" TARGET="_blank">';
	$displayAmazonBook .= '<img src="'.plugins_url( 'images/amazon-buynow-button.png' , ASA_MAIN_FILE ).'" width="220" height="37" alt="Buy Now at Amazon" />';
	//$displayAmazonBook .= '<h2>Click here to view this item at Amazon.com</h2>';
	$displayAmazonBook .= '</a></div>';
	$displayAmazonBook .= '	<div style="clear:left;">&nbsp;</div>';
	$displayAmazonBook .= '</div>';
	return $displayAmazonBook;
}

function asa_displayAmazonDefault($Data){
	$displayAmazonDefault = "<!-- Default Listing -->";
	
	$displayAmazonDefault .= '<div class="appStore-wrapper"><hr>';
	$displayAmazonDefault .= '	<div id="amazonStore-icon-container">';
	$displayAmazonDefault .= '    <a href="'.$Data['URL'].'" target="_blank"><img src="'.CACHE_DIRECTORY_URL.$Data['imagePosts'].'" alt="'.$Data['Title'].'" border="0" style="float: right; margin: 10px;" /></a>';
	$displayAmazonDefault .= '</div>';
	$displayAmazonDefault .= '<span class="amazonStore-title">'.$Data['Title']."</span><br />";
	if ($Data['Description']) {
		$displayAmazonDefault .= '<div class="amazonStore-description">'.$Data['Description'].'</div><br />';
	}
	if ($Data['Features']) {
		$displayAmazonDefault .= '<span class="amazonStore-features-desc">'.__("Features",'appStoreAssistant').':</span>'.$Data['Features'].'<br />';
	}
	if ($Data['Manufacturer']) {
		$displayAmazonDefault .= '<span class="amazonStore-publisher">'.__("Manufacturer",'appStoreAssistant').': '.$Data['Manufacturer']."</span><br />";
	}
	if ($Data['Status']) {
		$displayAmazonDefault .= '<span class="amazonStore-status">'.__("Status",'appStoreAssistant').': '.$Data['Status'].'</span><br />';
	}
	if ($Data['ListPrice']) {
		$displayAmazonDefault .= '<span class="amazonStore-listprice-desc">'.__("List Price",'appStoreAssistant').': </span>';
		$displayAmazonDefault .= '<span class="amazonStore-listprice">'. $Data['ListPrice'] .'</span><br />';
	}
	if ($Data['Amount']) {
		$displayAmazonDefault .= '<span class="amazonStore-amazonprice-desc">'.__("Amazon Price",'appStoreAssistant').': </span>';
		$displayAmazonDefault .= '<span class="amazonStore-amazonprice">'. $Data['Amount'] .'</span><br />';
	}
	if (isset($Data->ItemAttributes->ReleaseDate)) {
		$displayAmazonDefault .= '<span class="amazonStore-date">'.__("Disc Released",'appStoreAssistant').': '.date("F j, Y",strtotime($Data->ItemAttributes->ReleaseDate)).'</span><br />';
	}
	$displayAmazonDefault .= '<br><div align="center">';
	$displayAmazonDefault .= '<a href="'.$Data['URL'].'" TARGET="_blank">';
	$displayAmazonDefault .= '<img src="'.plugins_url( 'images/amazon-buynow-button.png' , ASA_MAIN_FILE ).'" width="220" height="37" alt="Buy Now at Amazon" />';
	//$displayAmazonDefault .= '<h2>Click here to view this item at Amazon.com</h2>';
	$displayAmazonDefault .= '</a></div>';
	$displayAmazonDefault .= '	<div style="clear:left;">&nbsp;</div>';
	$displayAmazonDefault .= '</div>';
	return $displayAmazonDefault;
} // end asa_displayAmazonDefault

function cleanAWSresults($Result){
    $Item 					= $Result['ItemLookupResponse']['Items']['Item'];
    $ItemAttr 				= $Item['ItemAttributes'];
  	$ImageSM 				= $Item['SmallImage']['URL'];
  	$ImageMD 				= $Item['MediumImage']['URL'];
  	$ImageLG 				= $Item['LargeImage']['URL'];
  	$lowestNewPrice 		= $Item["OfferSummary"]["LowestNewPrice"]["FormattedPrice"];
  	$lowestUsedPrice 		= $Item["OfferSummary"]["LowestUsedPrice"]["FormattedPrice"];
    $TotalNew 				= $Item["OfferSummary"]["TotalNew"];
    $TotalUsed 				= $Item["OfferSummary"]["TotalUsed"];
    $TotalCollectible 		= $Item["OfferSummary"]["TotalCollectible"];
    $TotalRefurbished 		= $Item["OfferSummary"]["TotalRefurbished"];
	$ProductDescription		= $Item["EditorialReviews"]["EditorialReview"]["Content"];
	$Tracks					= $Item["Tracks"];
	$BookDescription		= $Item["EditorialReviews"]["EditorialReview"]["0"]["Content"];
	$Status 				= $Item['Offers']['Offer']['OfferListing']['Availability'];
	$PriceData				= $Item['Offers']['Offer']['OfferListing']['Price'];
  	
    if(isset($PriceData['FormattedPrice'])) {
    	$CurrencyCode = $PriceData['CurrencyCode'];
    	$Amount = $PriceData['FormattedPrice']." ".$CurrencyCode;
    }else{
    	$Amount = "Not Listed";
    }
  	if($lowestNewPrice=='Too low to display'){
  		$Amount = "Too low to display";
  	}

	if(isset($ItemAttr["ListPrice"]["FormattedPrice"])){
		$ListPrice 		= $ItemAttr["ListPrice"]["FormattedPrice"] . ' ' . $ItemAttr["ListPrice"]["CurrencyCode"];
	}else{
		$ListPrice 		= '0';
	}
	$Author_s = $ItemAttr["Author"];
    if(is_array($Author_s)){
    	$Authors = 'Author';
		if (count($Author_s) > 1) $Authors .= 's :';
		$Authors .= implode(", ", $Author_s);
	}else{
    	$Authors = "Author: ".$Author_s;
    }
	    
    if(is_array($ItemAttr["Binding"])){$Binding = implode(", ", $ItemAttr["Binding"]);}else{$Binding = $ItemAttr["Binding"];}
    if(is_array($ItemAttr["Director"])){
    	$Director = "Directors: ".implode(", ", $ItemAttr["Director"]);
    }else{
    	$Director = "Directed by: ".$ItemAttr["Director"];
    }
    if(is_array($ItemAttr["Actor"])){
    	$Actors = "Actors: ".implode(", ", $ItemAttr["Actor"]);
    }else{
    	$Actors = "Actor: ". $ItemAttr["Actor"];
    }
    if(is_array($ItemAttr["Format"])){$Formats = implode(", ", $ItemAttr["Format"]);}else{$Formats = $ItemAttr["Format"];}
    if(is_array($ItemAttr["Languages"]["Language"])){$Languages = implode(", ", $ItemAttr["Languages"]["Language"]);}else{$Languages = $ItemAttr["Languages"]["Language"];}
    if(is_array($ItemAttr["AudienceRating"])){$Rating = implode(", ", $ItemAttr["AudienceRating"]);}else{$Rating = $ItemAttr["AudienceRating"];}
    if(is_array($ItemAttr["RunningTime"])){$RunTime = $ItemAttr["RunningTime"]["value"].' '.$ItemAttr["RunningTime"]["Units"];}else{$RunTime = '';}
   
    $OfferListingId 		= $Item['Offers']['Offer']['OfferListing']['OfferListingId'];
	$ReleaseDate 	= $ItemAttr["ReleaseDate"];
	$PublishedDate 	= $ItemAttr["PublicationDate"];
	
	if(is_array($ItemAttr["Feature"])){
		$Features = "<ul>";
		foreach ($ItemAttr["Feature"] as $Feature) {
			$Features .= "<li>$Feature</li>";
		}
		$Features .= "</ul>";
	}else{
		$Features = $ItemAttr["Feature"];
	}
	
	switch ($AmazonProductData['ProductGroup']) {
		case "Book":
			$Description = "";
			if ($ProductDescription) {
				$Description = $ProductDescription;
			} elseif($BookDescription) {
				$Description = $BookDescription;
			}
			break;
		case "DVD":
			$Description = "";
			if ($ProductDescription) {
				$Description = $ProductDescription;
			} elseif($BookDescription) {
				$Description = $BookDescription;
			}
			break;
		default:
			$Description = "";
			if ($ProductDescription) {
				$Description = $ProductDescription;
			} elseif($BookDescription) {
				$Description = $BookDescription;
			}
	}
	
    $formattedResults = array('ASIN' => $Item['ASIN'],
                    'ProductGroup' => $Item['ItemAttributes']['ProductGroup'],
				    'SmallImage' => $ImageSM,
				    'MediumImage' => $Item['MediumImage']['URL'],
				    'LargeImage' => $ImageLG,
                    'Title' => $Item['ItemAttributes']['Title'],
                    'URL' => $Item['DetailPageURL'],
                    'Manufacturer' => $ItemAttr['Manufacturer'],
                    'Studio' => $ItemAttr['Studio'],
                    'Publisher' => $ItemAttr['Publisher'],
                    'Status' => $Status,
                    'Features' => $Features,
                    'Tracks' => $Tracks,
                    'Description' => fixCharacters($Description),
                    'ProductDescription' => fixCharacters($ProductDescription),
                    'BookDescription' => fixCharacters($BookDescription),
                    'Amount' => $Amount,
                    'Currency' => $CurrencyCode,
                    'ReleaseDate' => $ReleaseDate,
                    'PublishedDate' => $PublishedDate,
                    'ListPrice' => $ListPrice,
                    'Binding' => $Binding,
                    'Authors' => $Authors,
                    
				    'Director' => $Director,
				    'Cast' => fixCharacters($Actors),
				    'Rating' => $Rating,
				    'Formats' => $Formats,
				    'Languages' => $Languages,
				    'OfferListingId' => $OfferListingId,
				    'RunTime' => $RunTime,
                    'Errors' => $Result['itemlookuperrorresponse']['error']
                   );
                                    
    return $formattedResults;  
} 

function fixCharacters($stringToCheck) {
	//Specific string replaces for ellipsis, etc that you dont want removed but replaced
	$theBad = 	array("“","”","‘","’","…","—","–");
	$theGood = array("\"","\"","'","'","...","-","-");
	$cleanedString = str_replace($theBad,$theGood,$stringToCheck);
	$cleanedString = htmlentities($cleanedString);

	/*
	$trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark
    $trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook
    $trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark
    $trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis
    $trans[chr(134)] = '&dagger;';    // Dagger
    $trans[chr(135)] = '&Dagger;';    // Double Dagger
    $trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent
    $trans[chr(137)] = '&permil;';    // Per Mille Sign
    $trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron
    $trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark
    $trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE
    $trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark
    $trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark
    $trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark
    $trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark
    $trans[chr(149)] = '&bull;';    // Bullet
    $trans[chr(150)] = '&ndash;';    // En Dash
    $trans[chr(151)] = '&mdash;';    // Em Dash
    $trans[chr(152)] = '&tilde;';    // Small Tilde
    $trans[chr(153)] = '&trade;';    // Trade Mark Sign
    $trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron
    $trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark
    $trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE
    $trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
    $trans['euro'] = '&euro;';    // euro currency symbol
    ksort($trans);
    
    foreach ($trans as $badchar => $goodcharacter) {
        $cleanedString = str_replace($badchar, $goodcharacter, $cleanedString);
    }
	
	*/	
		
	
	$theBad = 	array("&lt;","&gt;");
	$theGood = array("<",">");
	$cleanedString = str_replace($theBad,$theGood,$cleanedString);
	return $cleanedString;
}


//GetXMLTree and GetChildren code from http://whoooop.co.uk/2005/03/20/xml-to-array/

function GetXMLTree ($xmldata){
	if($xmldata==''){return False;}
	// we want to know if an error occurs
	ini_set ('track_errors', '1');

	$xmlreaderror = false;

	$parser = xml_parser_create ('ISO-8859-1');
	xml_parser_set_option ($parser, XML_OPTION_SKIP_WHITE, 1);
	xml_parser_set_option ($parser, XML_OPTION_CASE_FOLDING, 0);
	if (!xml_parse_into_struct ($parser, $xmldata, $vals, $index)) {
		$xmlreaderror = true;
	}
	xml_parser_free ($parser);

	if (!$xmlreaderror) {
		$result = array ();
		$i = 0;
		if (isset ($vals [$i]['attributes']))
			foreach (array_keys ($vals [$i]['attributes']) as $attkey)
			$attributes [$attkey] = $vals [$i]['attributes'][$attkey];

		$result [$vals [$i]['tag']] = array_merge ($attributes, GetChildren ($vals, $i, 'open'));
	}
	ini_set ('track_errors', '0');
	return $result;
}

function GetChildren ($vals, &$i, $type){
	if ($type == 'complete') {
		if (isset ($vals [$i]['value']))
			return ($vals [$i]['value']);
		else
			return '';
	}

	$children = array (); // Contains node data

	/* Loop through children */
	while ($vals [++$i]['type'] != 'close') {
		$type = $vals [$i]['type'];
		// first check if we already have one and need to create an array
		if (isset ($children [$vals [$i]['tag']])) {
			if (is_array ($children [$vals [$i]['tag']])) {
				$temp = array_keys ($children [$vals [$i]['tag']]);
				// there is one of these things already and it is itself an array
				if (is_string ($temp [0])) {
					$a = $children [$vals [$i]['tag']];
					unset ($children [$vals [$i]['tag']]);
					$children [$vals [$i]['tag']][0] = $a;
				}
			} else {
				$a = $children [$vals [$i]['tag']];
				unset ($children [$vals [$i]['tag']]);
				$children [$vals [$i]['tag']][0] = $a;
			}

			$children [$vals [$i]['tag']][] = GetChildren ($vals, $i, $type);
		} else
			$children [$vals [$i]['tag']] = GetChildren ($vals, $i, $type);
		// I don't think I need attributes but this is how I would do them:
		if (isset ($vals [$i]['attributes'])) {
			$attributes = array ();
			foreach (array_keys ($vals [$i]['attributes']) as $attkey)
			$attributes [$attkey] = $vals [$i]['attributes'][$attkey];
			// now check: do we already have an array or a value?
			if (isset ($children [$vals [$i]['tag']])) {
				// case where there is an attribute but no value, a complete with an attribute in other words
				if ($children [$vals [$i]['tag']] == '') {
					unset ($children [$vals [$i]['tag']]);
					$children [$vals [$i]['tag']] = $attributes;
				}
				// case where there is an array of identical items with attributes
				elseif (is_array ($children [$vals [$i]['tag']])) {
					$index = count ($children [$vals [$i]['tag']]) - 1;
					// probably also have to check here whether the individual item is also an array or not or what... all a bit messy
					if ($children [$vals [$i]['tag']][$index] == '') {
						unset ($children [$vals [$i]['tag']][$index]);
						$children [$vals [$i]['tag']][$index] = $attributes;
					}
					if(!is_array($children [$vals [$i]['tag']][$index])){
						$children [$vals [$i]['tag']][$index] = $attributes;
					}else{
						$children [$vals [$i]['tag']][$index] = array_merge ($children [$vals [$i]['tag']][$index], $attributes);
					}
				} else {
					$value = $children [$vals [$i]['tag']];
					unset ($children [$vals [$i]['tag']]);
					$children [$vals [$i]['tag']]['value'] = $value;
					$children [$vals [$i]['tag']] = array_merge ($children [$vals [$i]['tag']], $attributes);
				}
			} else
				$children [$vals [$i]['tag']] = $attributes;
		}
	}

	return $children;
}

function aws_hash_hmac($algo, $data, $key, $raw_output=False){
  // RFC 2104 HMAC implementation for php.
  // Creates a sha256 HMAC.
  // Eliminates the need to install mhash to compute a HMAC
  // Hacked by Lance Rushing
  // source: http://www.php.net/manual/en/function.mhash.php
  // modified by Ulrich Mierendorff to work with sha256 and raw output
  
  $b = 64; // block size of md5, sha256 and other hash functions
  if (strlen($key) > $b){
    $key = pack("H*",$algo($key));
  }
  $key = str_pad($key, $b, chr(0x00));
  $ipad = str_pad('', $b, chr(0x36));
  $opad = str_pad('', $b, chr(0x5c));
  $k_ipad = $key ^ $ipad ;
  $k_opad = $key ^ $opad;
  
  $hmac = $algo($k_opad . pack("H*", $algo($k_ipad . $data)));
  if ($raw_output){
    return pack("H*", $hmac);
  }else{
    return $hmac;
  }
} 

//aws_signed_request code from http://mierendo.com/software/aws_signed_query/
function aws_signed_request($region, $params, $public_key, $private_key){
    /*
    Copyright (c) 2009 Ulrich Mierendorff

    Permission is hereby granted, free of charge, to any person obtaining a
    copy of this software and associated documentation files (the "Software"),
    to deal in the Software without restriction, including without limitation
    the rights to use, copy, modify, merge, publish, distribute, sublicense,
    and/or sell copies of the Software, and to permit persons to whom the
    Software is furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
    THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
    DEALINGS IN THE SOFTWARE.
    */
    
    /*
    Parameters:
        $region - the Amazon(r) region (ca,com,co.uk,de,fr,jp)
        $params - an array of parameters, eg. array("Operation"=>"ItemLookup", "ItemId"=>"B000X9FLKM", "ResponseGroup"=>"Small")
        $public_key - your "Access Key ID"
        $private_key - your "Secret Access Key"
    */
    
	global $apip_usefileget, $apip_usecurlget;
	
    // some paramters
    $method = "GET";
    //$host = "ecs.amazonaws.".$region; //old API
    $host = "webservices.amazon.".$region; //new API 12-2011
    $uri = "/onca/xml";
    
    // additional parameters
    $params["Service"] = "AWSECommerceService";
    $params["AWSAccessKeyId"] = $public_key;
    $params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z");
    $params["Version"] = "2011-08-01"; //"2009-03-31";
 	$keyurl = $params['AssociateTag'].$params['IdType'].$params['ItemId'].$params['Operation'];
   
    // sort the parameters
    ksort($params);
    // create the canonicalized query
    $canonicalized_query = array();
    foreach ($params as $param=>$value){
        $param = str_replace("%7E", "~", rawurlencode($param));
        $value = str_replace("%7E", "~", rawurlencode($value));
        $canonicalized_query[] = $param."=".$value;
   }
    $canonicalized_query = implode("&", $canonicalized_query);
  
    // create the string to sign
    $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
   
    // calculate HMAC with SHA256 and base64-encoding
    $signature = base64_encode(aws_hash_hmac("sha256", $string_to_sign, $private_key, True));
    
    // encode the signature for the request
    $signature = str_replace("%7E", "~", rawurlencode($signature));
   
    // create request
    $request = "https://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;

    if(DEBUG){
      echo('<br/><br/>');
      echo($request);
      echo('<br/><br/>');
    }    
    
    // do request
    	// first check cache check
		global $wpdb;
		$body = "";
		$maxage = 1;
		$checksql= "SELECT Body, ( NOW() - Updated ) as Age FROM ".$wpdb->prefix."amazoncache WHERE URL = '" . $keyurl . "' AND NOT( Body LIKE '%AccountLimitExceeded%') AND NOT( Body LIKE '%SignatureDoesNotMatch%') AND NOT( Body LIKE '%InvalidParameterValue%');";
		$result = $wpdb->get_results($checksql);
		
		if (count($result) > 0){
			if ($result[0]->Age <= 6001 && $result[0]->Body != ''){ //that would be 60 min 1 seconds on MYSQL value
				$pxml = GetXMLTree($result[0]->Body);
				return $pxml;
			}else{
				if($apip_usefileget!='0'){
					 $response = file_get_contents($request);
				}elseif($apip_usecurlget!='0'){
				    $ch = curl_init();
				    $timeout = 5;
				    curl_setopt($ch, CURLOPT_URL, $request);
				    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				    $data = curl_exec($ch);
				    curl_close($ch);
				    $response = $data;
				}else{
					$response = False;
				}
			    
				if ($response === False){
					return False;
				}else{
					$xbody = trim(addslashes($response));
					if(strpos($xbody,'AccountLimitExceeded') >= 1){return 'exceeded';}
					if(strpos($xbody,'SignatureDoesNotMatch') >= 1){return 'no signature match';}
					if(strpos($xbody,'InvalidParameterValue') >= 1){return 'not valid';}
					$updatesql ="INSERT IGNORE INTO ".$wpdb->prefix."amazoncache (URL, Body, Updated) VALUES ('$keyurl', '$xbody', NOW()) ON DUPLICATE KEY UPDATE Body='$xbody', Updated=NOW();";
					$wpdb->query($updatesql);
					$pxml = GetXMLTree($response);
					return $pxml;
				}
			}
		}else{ //if not cached (less than 1 hour ago) OR Error in CACHE - get new
			if($apip_usefileget!='0'){
				 $response = file_get_contents($request);
			}elseif($apip_usecurlget!='0'){
			    $ch = curl_init();
			    $timeout = 5;
			    curl_setopt($ch, CURLOPT_URL, $request);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			    $data = curl_exec($ch);
			    curl_close($ch);
			    $response = $data;
			}else{
				$response = False;
				return False;
			}
			$xbody = trim(addslashes($response));
			if(strpos($xbody,'AccountLimitExceeded') >= 1){return 'exceeded';}
			if(strpos($xbody,'SignatureDoesNotMatch') >= 1){return 'no signature match';}
			if(strpos($xbody,'InvalidParameterValue') >= 1){return 'not valid';}
			$updatesql ="INSERT IGNORE INTO ".$wpdb->prefix."amazoncache (URL, Body, Updated) VALUES ('$keyurl', '$xbody', NOW()) ON DUPLICATE KEY UPDATE Body='$xbody', Updated=NOW();";
			$wpdb->query($updatesql);
			$pxml = GetXMLTree($response);
			return $pxml;
		}
	return False;
}

?>