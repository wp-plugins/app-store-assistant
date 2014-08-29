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

function appStore_handler_amazon_raw ( $atts,$content=null, $code="" ) {
	// Get App ID and more_info_text from shortcode
	extract( shortcode_atts( array('asin' => ''	), $atts ) );

	//Don't do anything if the ASIN is blank or non-numeric
	if ($asin=='') return;
	$appStore_options_data = appStore_page_get_amazonXML($asin);
	$output = '<div class="debug">';
	$output .= "RAW DATA FOR $asin <br />";
	$output .= '<pre>';
	$output .= print_r($appStore_options_data,true);
	$output .= '</pre>';
	$output .= '</div>';
	return $output;
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
	$amazonDisplayData = appStore_displayAmazonItem($AmazonProductData);
	return $amazonDisplayData;
}	
	
	
function appStore_get_amazonData($asin) {
	//Check to see if we have a cached version of the Amazon Product Data.
	$appStore_options = get_option('appStore_amazonData_' . $asin, 'NODATA');		
	//$appStore_options = 'NODATA'; //SEALDEBUG - ALWAYS REFRESH
	
	$nextCheck = (isset($appStore_options['next_check']) ? $appStore_options['next_check'] : '');
	if($appStore_options == 'NODATA' || $nextCheck < time()) {
		$appStore_options_data = appStore_page_get_amazonXML($asin);

		if(isset($appStore_options_data['Error'])) {
			$nextCheck = 10;
		} else {
			$nextCheck = time() + appStore_setting('cache_time_select_box');
			if(appStore_setting('cache_images_locally') == '1') {
				$appStore_options_data = appStore_save_amazonImages_locally($appStore_options_data);
			}
		}		
		
		$appStore_options = array('next_check' => $nextCheck, 'app_data' => $appStore_options_data);
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
				
		$productData['error'] = true;
		$productData['errormessage'] = $bestFilePath;
		return $productData;
			
		//Check to see if image exists
		if (is_writable ( $bestFilePath )) {
			$x = 1;	
		}
				
		$editor = wp_get_image_editor( $bestFilePath );
 		$size = $editor->get_size();
 		$filePrefix = "asaArtwork_";
		$filePath_Start = CACHE_DIRECTORY."Amazon/". $asin . '/'.$filePrefix;
		$fileURL_Start = CACHE_DIRECTORY_URL."Amazon/". $asin . '/'.$filePrefix;

 		if(appStore_setting('appicon_size_featured_w') < $size['width'] || appStore_setting('appicon_size_featured_h') < $size['height']) {
 			$newSize_w = appStore_setting('appicon_size_featured_w');
 			$newSize_h = appStore_setting('appicon_size_featured_h');
 			$newSize_c = (appStore_setting('appicon_size_featured_c') ? true : false);
			$editor->resize( $newSize_w, $newSize_h, $newSize_c  );
		}
		$filename = $filePath_Start."featured.".$bestFileExt;
		$new_image_info = $editor->save($filename);
		$productData['imageFeatured_cached'] = $fileURL_Start."featured.".$bestFileExt;
		$productData['imageFeatured_path'] = $filePath_Start."featured.".$bestFileExt;

		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_ios_w') < $size['width'] || appStore_setting('appicon_size_ios_h') < $size['height']) {
 			$newSize_w = appStore_setting('appicon_size_ios_w');
 			$newSize_h = appStore_setting('appicon_size_ios_h');
 			$newSize_c = (appStore_setting('appicon_size_ios_c') ? true : false);
			$editor->resize( $newSize_w, $newSize_h, $newSize_c  );
		}
		$filename = $filePath_Start."ios.".$bestFileExt;
		$new_image_info = $editor->save($filename);		
		$productData['imageiOS_cached'] = $fileURL_Start."featured.".$bestFileExt;

		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_rss_w') < $size['width'] || appStore_setting('appicon_size_rss_h') < $size['height']) {
 			$newSize_w = appStore_setting('appicon_size_rss_w');
 			$newSize_h = appStore_setting('appicon_size_rss_h');
 			$newSize_c = (appStore_setting('appicon_size_rss_c') ? true : false);
			$editor->resize( $newSize_w, $newSize_h, $newSize_c  );
		}
		$filename = $filePath_Start."rss.".$bestFileExt;
		$new_image_info = $editor->save($filename);		
		$productData['imageRSS_cached'] = $fileURL_Start."featured.".$bestFileExt;
			
		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_lists_w') < $size['width'] || appStore_setting('appicon_size_lists_h') < $size['height']) {
 			$newSize_w = appStore_setting('appicon_size_lists_w');
 			$newSize_h = appStore_setting('appicon_size_lists_h');
 			$newSize_c = (appStore_setting('appicon_size_lists_c') ? true : false);
			$editor->resize( $newSize_w, $newSize_h, $newSize_c  );
		}
		$filename = $filePath_Start."list.".$bestFileExt;
		$new_image_info = $editor->save($filename);		
		$productData['imageLists_cached'] = $fileURL_Start."featured.".$bestFileExt;

		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_posts_w') < $size['width'] || appStore_setting('appicon_size_posts_h') < $size['height']) {
 			$newSize_w = appStore_setting('appicon_size_posts_w');
 			$newSize_h = appStore_setting('appicon_size_posts_h');
 			$newSize_c = (appStore_setting('appicon_size_posts_c') ? true : false);
			$editor->resize( $newSize_w, $newSize_h, $newSize_c  );
		}
		$filename = $filePath_Start."post.".$bestFileExt;
		$new_image_info = $editor->save($filename);		
		$productData['imagePosts_cached'] = $fileURL_Start."featured.".$bestFileExt;

		$editor = wp_get_image_editor( $bestFilePath );
 		if(appStore_setting('appicon_size_element_w') < $size['width'] || appStore_setting('appicon_size_element_h') < $size['height']) {
 			$newSize_w = appStore_setting('appicon_size_element_w');
 			$newSize_h = appStore_setting('appicon_size_element_h');
 			$newSize_c = (appStore_setting('appicon_size_element_c') ? true : false);
			$editor->resize( $newSize_w, $newSize_h, $newSize_c  );
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
	
	
	$pxml = asa_aws_signed_request($aws_partner_domain,
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
		
	if(isset($pxml['ItemLookupResponse']['Items']['Request']['Errors']['Error'])) {
		echo "Error processing Amazon.com lookup:<br />";
		echo $pxml['ItemLookupResponse']['Items']['Request']['Errors']['Error']['Code']."<br />";
		echo $pxml['ItemLookupResponse']['Items']['Request']['Errors']['Error']['Message']."<br />";
		exit;
	}
	
	//Check for errors from Amazon.com
	if($pxml['ItemLookupResponse']['Items']['Request']['IsValid'] == "False") {
		echo "Error processing Amazon.com lookup:<br />";
		echo $pxml['ItemLookupResponse']['Items']['Request']['Errors']['Error']['Code']."<br />";
		echo $pxml['ItemLookupResponse']['Items']['Request']['Errors']['Error']['Message']."<br />";
		exit;
	}


	//print_r($pxml);
	
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

function appStore_displayAmazonItem($Data){
	$displayAmazonItem = "<!-- Default Listing -->";	

	//$displayAmazonItem .= '-------SEALDEBUG--------'.print_r($Data,true).'---------------';//Debug
	$displayAmazonItem .= '<div class="appStore-wrapper"><hr>';
	$displayAmazonItem .= '	<div id="amazonStore-icon-container">';
	
	//$displayAmazonItem .= $Data['Debug'];
	
	if(appStore_setting('cache_images_locally') == '1') {
		$imageTag = $Data['imagePosts_cached'];
	} else {
		$imageTag = $Data['imagePosts'];
	}	
	
	$displayAmazonItem .= '    <a href="'.$Data['URL'].'" target="_blank"><img src="'.$imageTag.'" alt="'.$Data['Title'].'" border="0" style="float: right; margin: 10px;" /></a>';
	$displayAmazonItem .= '</div>';
	$displayAmazonItem .= '<span class="amazonStore-title">'.$Data['Title']."</span><br />";
	if (isset($Data['Description'])) {
		$displayAmazonItem .= '<div class="amazonStore-description">'.$Data['Description'].'</div><br />';
	}
	$Feature_s = (isset($Data['Features']) ? $Data['Features'] : '');
	
	if (is_array($Feature_s)) {
		$displayAmazonItem .= '<span class="amazonStore-features-desc">'.__("Details",'appStoreAssistant').':</span><br />';
		
		$displayAmazonItem .= "<ul>";
		foreach ($Feature_s as $Feature) {
			if (is_array($Feature)) {
				foreach ($Feature as $Feature_Item) {
					$displayAmazonItem .= '<li>'.$Feature_Item.'</li>';
				}
			} else {
				$displayAmazonItem .= '<li>'.$Feature.'</li>';
			}
		}
		$displayAmazonItem .= "</ul>";
	}
	if ($Data['Manufacturer']) {
		$displayAmazonItem .= '<span class="amazonStore-publisher">'.__("Manufacturer",'appStoreAssistant').': '.$Data['Manufacturer']."</span><br />";
	}
	if ($Data['Status']) {
		$displayAmazonItem .= '<span class="amazonStore-status">'.__("Status",'appStoreAssistant').': '.$Data['Status'].'</span><br />';
	}
	if ($Data['ListPrice']) {
		$displayAmazonItem .= '<span class="amazonStore-listprice-desc">'.__("List Price",'appStoreAssistant').': </span>';
		$displayAmazonItem .= '<span class="amazonStore-listprice">'. $Data['ListPrice'] .'</span><br />';
	}
	if ($Data['Amount']) {
		$displayAmazonItem .= '<span class="amazonStore-amazonprice-desc">'.__("Amazon Price",'appStoreAssistant').': </span>';
		$displayAmazonItem .= '<span class="amazonStore-amazonprice">'. $Data['Amount'] .'</span><br />';
	}
	if (isset($Data->ItemAttributes->ReleaseDate)) {
		$displayAmazonItem .= '<span class="amazonStore-date">'.__("Disc Released",'appStoreAssistant').': '.date("F j, Y",strtotime($Data->ItemAttributes->ReleaseDate)).'</span><br />';
	}
	$displayAmazonItem .= '<br><div align="center">';
	$displayAmazonItem .= '<a href="'.$Data['URL'].'" TARGET="_blank">';
	$displayAmazonItem .= '<img src="'.plugins_url( 'images/amazon-buynow-button.png' , ASA_MAIN_FILE ).'" width="220" height="37" alt="Buy Now at Amazon" />';
	//$displayAmazonItem .= '<h2>Click here to view this item at Amazon.com</h2>';
	$displayAmazonItem .= '</a></div>';
	$displayAmazonItem .= '	<div style="clear:left;">&nbsp;</div>';
	$displayAmazonItem .= '</div>';
	return $displayAmazonItem;
} // end appStore_displayAmazonItem

function cleanAWSresults($Result){

	$Errors = (isset($Result['itemlookuperrorresponse']['error']) ? $Result['itemlookuperrorresponse']['error'] : '');

	//$formattedResults['Debug'] = '<pre>'.print_r($Result,true).'</pre>';
	$formattedResults['Debug'] = '<!-- '.print_r($Result,true).'-->';
	
	$CurrencyCode = '';
    $Item 					= $Result['ItemLookupResponse']['Items']['Item'];
    $ItemAttr 				= $Item['ItemAttributes'];

	$ProductGroup = $Item['ItemAttributes']['ProductGroup'];

	$formattedResults['ASIN'] = $Item['ASIN'];
	$formattedResults['ProductGroup'] = $ProductGroup;

	// Universal Items
    if (isset($Item['ImageSets']['ImageSet'][0]['SmallImage']['URL'])) $formattedResults['SmallImage'] = $Item['ImageSets']['ImageSet'][0]['SmallImage']['URL'];
    if (isset($Item['ImageSets']['ImageSet']['SmallImage']['URL'])) $formattedResults['SmallImage'] = $Item['ImageSets']['ImageSet']['SmallImage']['URL'];	
    if (isset($Item['ImageSets']['ImageSet'][0]['MediumImage']['URL'])) $formattedResults['MediumImage'] = $Item['ImageSets']['ImageSet'][0]['MediumImage']['URL'];
    if (isset($Item['ImageSets']['ImageSet']['MediumImage']['URL'])) $formattedResults['MediumImage'] = $Item['ImageSets']['ImageSet']['MediumImage']['URL'];
    if (isset($Item['ImageSets']['ImageSet'][0]['LargeImage']['URL'])) $formattedResults['LargeImage'] = $Item['ImageSets']['ImageSet'][0]['LargeImage']['URL'];
    if (isset($Item['ImageSets']['ImageSet']['LargeImage']['URL'])) $formattedResults['LargeImage'] = $Item['ImageSets']['ImageSet']['LargeImage']['URL'];
	$formattedResults['Title'] = $Item['ItemAttributes']['Title'];
    $formattedResults['URL'] = $Item['DetailPageURL'];
	$formattedResults['Manufacturer'] = (isset($ItemAttr['Manufacturer']) ? $ItemAttr['Manufacturer'] : '');
    $formattedResults['Studio'] = (isset($ItemAttr['Studio']) ? $ItemAttr['Studio'] : '');
    $formattedResults['Publisher'] = (isset($ItemAttr['Publisher']) ? $ItemAttr['Publisher'] : '');
	$Binding_s = (isset($Item['ItemAttributes']['Binding']) ? $Item['ItemAttributes']['Binding'] : '');
	$formattedResults['Binding'] = (is_array($Binding_s) ? implode(', ', $Binding_s) : $Binding_s);
  	$formattedResults['ListPrice'] = (isset($Item['ItemAttributes']['ListPrice']['FormattedPrice']) ? $Item['ItemAttributes']['ListPrice']['FormattedPrice'].' '.$Item['ItemAttributes']['ListPrice']['CurrencyCode'] : '');
	$formattedResults['ReleaseDate'] = (isset($Item['ItemAttributes']['ReleaseDate']) ? __('Released','appStoreAssistant').': '.$Item['ItemAttributes']['ReleaseDate'] : '');
    if (isset($Item['EditorialReviews']['EditorialReview']['1']['Content'])) $formattedResults['Description'] = fixCharacters($Item['EditorialReviews']['EditorialReview']['1']['Content']);
    if (isset($Item['EditorialReviews']['EditorialReview']['0']['Content'])) $formattedResults['Description'] = fixCharacters($Item['EditorialReviews']['EditorialReview']['0']['Content']);
    if (isset($Item['EditorialReviews']['EditorialReview']['Content'])) $formattedResults['Description'] = fixCharacters($Item['EditorialReviews']['EditorialReview']['Content']);    
	$formattedResults['Status'] = (isset($Item['Offers']['Offer']['OfferListing']['Availability']) ? $Item['Offers']['Offer']['OfferListing']['Availability'] : '');
	$PriceData = (isset($Item['Offers']['Offer']['OfferListing']['Price']) ? $Item['Offers']['Offer']['OfferListing']['Price'] : '');
  	$lowestNewPrice = (isset($Item['OfferSummary']['LowestNewPrice']['FormattedPrice']) ? $Item['OfferSummary']['LowestNewPrice']['FormattedPrice'] : '');
  	$lowestUsedPrice = (isset($Item['OfferSummary']['LowestUsedPrice']['FormattedPrice']) ? $Item['OfferSummary']['LowestUsedPrice']['FormattedPrice'] : '');  	
    if(isset($PriceData['FormattedPrice'])) {
    	$CurrencyCode = $PriceData['CurrencyCode'];
    	$Amount = $PriceData['FormattedPrice'].' '.$CurrencyCode;
    }else{
    	$Amount = 'Not Listed';
    }
  	if($lowestNewPrice=='Too low to display'){
  		$Amount = 'Too low to display';
  	}
	$formattedResults['Amount'] = $Amount;
	$formattedResults['CurrencyCode'] = (isset($PriceData['CurrencyCode']) ? $PriceData['CurrencyCode'] : '');


  	$Language_s = (isset($Item['ItemAttributes']['Languages']['Language']) ? $Item['ItemAttributes']['Languages']['Language'] : '');
	//$formattedResults['Languages'] = (is_array($Language_s) ? __('Languages','appStoreAssistant').': '.implode(', ', $Language_s) : __('Language','appStoreAssistant').': '.$Language_s);
	//$formattedResults['Languages'] = print_r($Language_s,true);


	$formattedResults['OfferListingId'] = (isset($Item['Offers']['Offer']['OfferListing']['OfferListingId']) ? $Item['Offers']['Offer']['OfferListing']['OfferListingId'] : '');

	$formattedResults['SalesNotes']['TotalNew'] = (isset($Item['OfferSummary']['TotalNew']) ? $Item['OfferSummary']['TotalNew'] : '');
	$formattedResults['SalesNotes']['TotalUsed'] = (isset($Item['OfferSummary']['TotalUsed']) ? $Item['OfferSummary']['TotalUsed'] : '');
	$formattedResults['SalesNotes']['TotalCollectible'] = (isset($Item['OfferSummary']['TotalCollectible']) ? $Item['OfferSummary']['TotalCollectible'] : '');
	$formattedResults['SalesNotes']['TotalRefurbished'] = (isset($Item['OfferSummary']['TotalRefurbished']) ? $Item['OfferSummary']['TotalRefurbished'] : '');

	// ProductGroup Specific Items
	switch ($ProductGroup) {
		//DVD Product Group
		case "DVD":
			$Actor_s = (isset($Item['ItemAttributes']['Actor']) ? $Item['ItemAttributes']['Actor'] : '');
			if(is_array($Actor_s)) {
				$Actors = '<ul>';
				foreach ($Actor_s as $Actor) {
					$Actors .= '<li>'.fixCharacters($Actor).'</li>';
				}
				$Actors .= '</ul>';
				$formattedResults['Features']['Cast'] = __('Cast','appStoreAssistant').': '.$Actors;
			}
			//$formattedResults['Features']['Cast'] = $Actor_s ;//fixCharacters($Cast);
			if (isset($Item['ItemAttributes']['AspectRatio'])) $formattedResults['Features']['AspectRatio'] = __('Aspect Ratio','appStoreAssistant').': '.$Item['ItemAttributes']['AspectRatio'];
			if (isset($Item['ItemAttributes']['AudienceRating'])) $formattedResults['Features']['Rating'] = __('Rating','appStoreAssistant').': '.$Item['ItemAttributes']['AudienceRating'];
			$Creator_s = (isset($Item['ItemAttributes']['Creator']) ? $Item['ItemAttributes']['Creator'] : '');
			if(is_array($Creator_s)) {
				if (isset($Creator_s['Role']) && isset($Creator['value'])) {
					$Creators = $Creator_s['Role'].': '.$Creator_s['value'];
					$CreatorsCount = 1;
				} else {
					$Creators = null;
					$CreatorsCount = 0;
					foreach ($Creator_s as $Creator) {
						if(isset($Creator['Role']) && isset($Creator['value'])) {
							$Creators[] = $Creator['Role'].': '.$Creator['value'];
						$CreatorsCount++;
						}
					}
				}
				if( $CreatorsCount> 0 ) $formattedResults['Features']['Creators'] = $Creators;
			}
			$Director_s = (isset($Item['ItemAttributes']['Director']) ? $Item['ItemAttributes']['Director'] : '');
			$formattedResults['Features']['Director'] = (is_array($Director_s) ? __('Directors','appStoreAssistant').': '.implode(', ', $Director_s) : __('Directed by','appStoreAssistant').': '.$Director_s);
			$formattedResults['Features']['Edition'] = (isset($Item['ItemAttributes']['Edition']) ? __('Edition','appStoreAssistant').': '.$Item['ItemAttributes']['Edition'] : '');
			if (isset($Item['ItemAttributes']['Feature'])) $formattedResults['Features']['Features'] = $Item['ItemAttributes']['Feature'];
			$Format_s = (isset($Item['ItemAttributes']['Format']) ? $Item['ItemAttributes']['Format'] : '');
			if(is_array($Format_s)) {
				$Formats = "Features:<ul>";
				foreach ($Format_s as $Format) {
					$Formats .= '<li>'.$Format.'</li>';
				}
				$Formats .= "</ul>";
				$formattedResults['Features']['Formats'] = __('Formats','appStoreAssistant').': '.$Formats;
			}
			$formattedResults['Features']['Label'] = (isset($Item['ItemAttributes']['Label']) ? __('Released by','appStoreAssistant').': '.$Item['ItemAttributes']['Label'] : '');
			$formattedResults['Features']['NumberOfDiscs'] = (isset($Item['ItemAttributes']['NumberOfDiscs']) ? __('Discs','appStoreAssistant').': '.$Item['ItemAttributes']['NumberOfDiscs'] : '');
			$formattedResults['Features']['PictureFormat'] = (isset($Item['ItemAttributes']['PictureFormat']) ? __('Picture Format','appStoreAssistant').': '.$Item['ItemAttributes']['PictureFormat'] : '');
			$RunTime_s = (isset($Item['ItemAttributes']['RunningTime']) ? $Item['ItemAttributes']['RunningTime'] : '');
			$formattedResults['Features']['RunTime'] = (is_array($RunTime_s) ? __('Run Time','appStoreAssistant').': '.$RunTime_s['@value'].' '.$RunTime_s['@attributes']['Units'] : '');
			$formattedResults['Features']['Studio'] = (isset($Item['ItemAttributes']['Studio']) ? __('Studio','appStoreAssistant').': '.$Item['ItemAttributes']['Studio'] : '');
			break;
		//Music Product Group
		case "Music":
			$Creator_s = (isset($Item['ItemAttributes']['Creator']) ? $Item['ItemAttributes']['Creator'] : '');
			if(is_array($Creator_s)) {
				$Creators = "";
				if (isset($Creator_s['@attributes']['Role'])) {
					$Creators = $Creator_s['@attributes']['Role'].': '.$Creator_s['@value'];
				} else {
					foreach ($Creator_s as $Creator) {
						if(isset($Creator['@attributes']['Role']) && isset($Creator['@value'])) {
							$Creators[] = $Creator['@attributes']['Role'].': '.$Creator['@value'];
						}
					}
				}
				$formattedResults['Features']['Creators'] = $Creators;
			}
			if (isset($Item['ItemAttributes']['Format'])) $Format_s = $Item['ItemAttributes']['Format'];
			if (is_array($Format_s)) {
				$Formats = "Features:<ul>";
				foreach ($Format_s as $Format) {
					$Formats .= '<li>'.$Format.'</li>';
				}
				$Formats .= "</ul>";
				$formattedResults['Features']['Formats'] = $Formats;
			}
			if (isset($Item['ItemAttributes']['Label'])) $formattedResults['Features']['Label'] =  __('Released by','appStoreAssistant').': '.$Item['ItemAttributes']['Label'];
			if (isset($Item['ItemAttributes']['NumberOfDiscs'])) $formattedResults['Features']['NumberOfDiscs'] =  __('Discs','appStoreAssistant').': '.$Item['ItemAttributes']['NumberOfDiscs'];
			if (isset($Item['ItemAttributes']['Studio'])) $formattedResults['Features']['Studio'] =  __('Studio','appStoreAssistant').': '.$Item['ItemAttributes']['Studio'];
			if (isset($Item['Tracks']['Disc'])) $formattedResults['Features']['Tracks'] = appStore_GetAmazonTracks($Item['Tracks']['Disc']);
			if (isset($Item['ItemAttributes']['PublicationDate'])) $formattedResults['Features']['PublishedDate'] = $Item['ItemAttributes']['PublicationDate'];
			
			break;
		//Books Product Group
		case "Book":
			$Author_s = (isset($Item['ItemAttributes']['Author']) ? $Item['ItemAttributes']['Author'] : '');
			if(is_array($Author_s)){
				$Authors = 'Author';
				if (count($Author_s) > 1) $Authors .= 's :';
				$Authors .= implode(', ', $Author_s);
			}else{
				$Authors = 'Author: '.$Author_s;
			}
			$formattedResults['Features']['Authors'] = $Authors;
			$formattedResults['Features']['Edition'] = (isset($Item['ItemAttributes']['Edition']) ? __('Edition','appStoreAssistant').': '.$Item['ItemAttributes']['Edition'] : '');
			$formattedResults['Features']['ISBN'] = (isset($Item['ItemAttributes']['ISBN']) ? 'ISBN: '.$Item['ItemAttributes']['ISBN'] : '');
			$formattedResults['Features']['Label'] = (isset($Item['ItemAttributes']['Label']) ? __('Publisher','appStoreAssistant').': '.$Item['ItemAttributes']['Label'] : '');
			$formattedResults['Features']['NumberOfPages'] = (isset($Item['ItemAttributes']['NumberOfPages']) ? __('Pages','appStoreAssistant').': '.$Item['ItemAttributes']['NumberOfPages'] : '');

			break;
		//eBooks Product Group
		case "eBooks":
			$Author_s = (isset($Item['ItemAttributes']['Author']) ? $Item['ItemAttributes']['Author'] : '');
			if(is_array($Author_s)){
				$Authors = 'Author';
				if (count($Author_s) > 1) $Authors .= 's :';
				$Authors .= implode(', ', $Author_s);
			}else{
				$Authors = 'Author: '.$Author_s;
			}
			$formattedResults['Features']['Authors'] = $Authors;
			$Format_s = (isset($Item['ItemAttributes']['Format']) ? $Item['ItemAttributes']['Format'] : '');
			if(is_array($Format_s)) {
				$Formats = "<ul>";
				foreach ($Format_s as $Format) {
					$Formats .= '<li>'.$Format.'</li>';
				}
				$Formats .= "</ul>";
				$formattedResults['Features']['Formats'] = __('Formats','appStoreAssistant').': '.$Formats;
			}
			$formattedResults['Features']['Label'] = (isset($Item['ItemAttributes']['Label']) ? __('Publisher','appStoreAssistant').': '.$Item['ItemAttributes']['Label'] : '');
			$formattedResults['Features']['NumberOfPages'] = (isset($Item['ItemAttributes']['NumberOfPages']) ? __('Pages','appStoreAssistant').': '.$Item['ItemAttributes']['NumberOfPages'] : '');

			break;
		//Mobile Application Product Group
		case "Mobile Application":
			$Feature_s = (isset($Item['ItemAttributes']['Feature']) ? $Item['ItemAttributes']['Feature'] : '');
			$formattedResults['Features']['Features'] = $Feature_s;
			$formattedResults['Features']['HardwarePlatform'] = (isset($Item['ItemAttributes']['HardwarePlatform']) ? __('Hardware Platform','appStoreAssistant').': '.$Item['ItemAttributes']['HardwarePlatform'] : '');
			$IsAdultProduct = (isset($Item['ItemAttributes']['IsAdultProduct']) ? $Item['ItemAttributes']['IsAdultProduct'] : 'NO');
			if ($IsAdultProduct == 1) $formattedResults['Features']['IsAdultProduct'] = __('Adult Content','appStoreAssistant');
			$formattedResults['Features']['OperatingSystem'] = (isset($Item['ItemAttributes']['OperatingSystem']) ? __('Operating System','appStoreAssistant').': '.$Item['ItemAttributes']['OperatingSystem'] : '');
			break;
		// Default Product Group
		default:
			if (isset($Item['ItemAttributes']['Color'])) $formattedResults['Features']['Color'] = __('Color','appStoreAssistant').': '.$Item['ItemAttributes']['Color'];
			if (isset($Item['ItemAttributes']['Feature'])) $formattedResults['Features']['Features'] = $Item['ItemAttributes']['Feature'];
			$IsAdultProduct = (isset($Item['ItemAttributes']['IsAdultProduct']) ? $Item['ItemAttributes']['IsAdultProduct'] : 'NO');
			if ($IsAdultProduct == 1) $formattedResults['Features']['IsAdultProduct'] = __('Adult Content','appStoreAssistant');
			$IsAutographed = (isset($Item['ItemAttributes']['IsAutographed']) ? $Item['ItemAttributes']['IsAutographed'] : 'NO');
			if ($IsAutographed == 1) $formattedResults['Features']['IsAutographed'] = __('Autographed','appStoreAssistant');
			$IsMemorabilia = (isset($Item['ItemAttributes']['IsMemorabilia']) ? $Item['ItemAttributes']['IsMemorabilia'] : 'NO');
			if ($IsMemorabilia == 1) $formattedResults['Features']['IsMemorabilia'] = __('Memorabilia','appStoreAssistant');
			if (isset($Item['ItemAttributes']['LegalDisclaimer'])) $formattedResults['Features']['LegalDisclaimer'] = $Item['ItemAttributes']['LegalDisclaimer'];
			if (isset($Item['ItemAttributes']['Model'])) $formattedResults['Features']['Model'] = __('Model','appStoreAssistant').': '.$Item['ItemAttributes']['Model'];
			if (isset($Item['ItemAttributes']['MPN'])) $formattedResults['Features']['MPN'] = __('MPN','appStoreAssistant').': '.$Item['ItemAttributes']['MPN'];
			if (isset($Item['ItemAttributes']['Size'])) $formattedResults['Features']['Size'] = __('Size','appStoreAssistant').': '.$Item['ItemAttributes']['Size'];
			if (isset($Item['ItemAttributes']['Warranty'])) $formattedResults['Features']['Warranty'] = __('Warranty','appStoreAssistant').': '.$Item['ItemAttributes']['Warranty'];
			break;
	}                                    
    return $formattedResults;  
}

function appStore_GetAmazonTracks($TracksArray) {
	if (isset($TracksArray[0]['Track'])) {
		$TracksDisplay = "Discs:<ul>";
		foreach ($TracksArray as $Disc => $Tracks) {
			$DiscNumber = $Disc + 1;
			$TracksDisplay .= "<li>Disc $DiscNumber:<ol>";
			foreach ($Tracks['Track'] as $Track) {
				if(isset($Track['@value'])) $TracksDisplay .= '<li>'.$Track['@value'].'</li>';
			}
			$TracksDisplay .= "</ol>";
		}
		$TracksDisplay .= "</ul>";
	} else {

		$TracksDisplay = "Tracks:<ol>";
		foreach ($TracksArray['Track'] as $Track) {
			if(isset($Track['@value'])) $TracksDisplay .= '<li>'.$Track['@value'].'</li>';
		}
		$TracksDisplay .= "</ol>";
	}

	return $TracksDisplay;
}

function fixCharacters($stringToCheck) {
	//Specific string replaces for ellipsis, etc that you dont want removed but replaced
	$theBad = 	array("“","”","‘","’","…","—","–","<div>","</div>");
	$theGood = array("\"","\"","'","'","...","-","-","","");
	$cleanedString = str_ireplace($theBad,$theGood,$stringToCheck);

	//$cleanedString = htmlentities($cleanedString,ENT_QUOTES);
	if (version_compare(phpversion(), '5.4', '<')) {
		// php version isn't high enough
		$cleanedString = str_replace('&Acirc;', '', $cleanedString);
	} else {
		$cleanedString = htmlentities($cleanedString,ENT_SUBSTITUTE);
		//$cleanedString = htmlentities($cleanedString,ENT_DISALLOWED);
	}
	
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
	$cleanedString = str_ireplace($theBad,$theGood,$cleanedString); // Put Back HTML commands
	$cleanedString = preg_replace('@\x{FFFD}@u', '', $cleanedString); // Remove &#xFFFD; or &#65533; or 
	//echo "------SEALDEBUG--OUT2-------\r\r\r".print_r($cleanedString,true)."\r\r\r---------------";//Debug
	
	return $cleanedString;
}

//	 and asa_GetChildren code from http://whoooop.co.uk/2005/03/20/xml-to-array/
//
function asa_GetXMLTree ($xmldata){
	if($xmldata==''){return False;}
	// we want to know if an error occurs
	ini_set ('track_errors', '1');

	$xmlreaderror = false;

	$parser = xml_parser_create ('');
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

		$result [$vals [$i]['tag']] = array_merge ($attributes, asa_GetChildren ($vals, $i, 'open'));
	}
	ini_set ('track_errors', '0');
	return $result;
}

function asa_GetChildren ($vals, &$i, $type){
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

			$children [$vals [$i]['tag']][] = asa_GetChildren ($vals, $i, $type);
		} else
			$children [$vals [$i]['tag']] = asa_GetChildren ($vals, $i, $type);
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

function asa_aws_hash_hmac($algo, $data, $key, $raw_output=False){
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

//asa_aws_signed_request code from http://mierendo.com/software/aws_signed_query/
function asa_aws_signed_request($region, $params, $public_key, $private_key){
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
    $host = "webservices.amazon.".$region; //new API 12-2011
    $uri = "/onca/xml";
    
    // additional parameters
    $params["Service"] = "AWSECommerceService";
    $params["AWSAccessKeyId"] = $public_key;
    // GMT timestamp
    $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
    // API version
    $params["Version"] = "2011-08-01"; //"2009-03-31";
 	$keyurl = $params['AssociateTag'].$params['IdType'].$params['ItemId'].$params['Operation'];
   
    // sort the parameters
    ksort($params);
    
    // create the canonicalized query
    $canonicalized_query = array();
    foreach ($params as $param=>$value)
    {
        $param = str_replace('%7E', '~', rawurlencode($param));
        $value = str_replace('%7E', '~', rawurlencode($value));
        $canonicalized_query[] = $param.'='.$value;
    }
    $canonicalized_query = implode('&', $canonicalized_query);
    
    // create the string to sign
    $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
    
    // calculate HMAC with SHA256 and base64-encoding
    $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $private_key, TRUE));
    
    // encode the signature for the request
    $signature = str_replace('%7E', '~', rawurlencode($signature));
    
    // create request
    $request = 'http://'.$host.$uri.'?'.$canonicalized_query.'&Signature='.$signature;

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
				//$pxml = asa_GetXMLTree($result[0]->Body);
				$pxml = XML2Array::createArray($result[0]->Body);
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
					//$pxml = asa_GetXMLTree($response);
					$pxml = XML2Array::createArray($response);
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
			//$pxml = asa_GetXMLTree($response);
			$pxml = XML2Array::createArray($response);
			return $pxml;
		}
	return False;
}

/**
 * XML2Array: A class to convert XML to array in PHP
 * It returns the array which can be converted back to XML using the Array2XML script
 * It takes an XML string or a DOMDocument object as an input.
 *
 * See Array2XML: http://www.lalit.org/lab/convert-php-array-to-xml-with-attributes
 *
 * Author : Lalit Patel
 * Website: http://www.lalit.org/lab/convert-xml-to-array-in-php-xml2array
 * License: Apache License 2.0
 *          http://www.apache.org/licenses/LICENSE-2.0
 * Version: 0.1 (07 Dec 2011)
 * Version: 0.2 (04 Mar 2012)
 * 			Fixed typo 'DomDocument' to 'DOMDocument'
 *
 * Usage:
 *       $array = XML2Array::createArray($xml);
 */

class XML2Array {

    private static $xml = null;
	private static $encoding = 'UTF-8';

    /**
     * Initialize the root XML node [optional]
     * @param $version
     * @param $encoding
     * @param $format_output
     */
    public static function init($version = '1.0', $encoding = 'UTF-8', $format_output = true) {
        self::$xml = new DOMDocument($version, $encoding);
        self::$xml->formatOutput = $format_output;
		self::$encoding = $encoding;
    }

    /**
     * Convert an XML to Array
     * @param string $node_name - name of the root node to be converted
     * @param array $arr - aray to be converterd
     * @return DOMDocument
     */
    public static function &createArray($input_xml) {
        $xml = self::getXMLRoot();
		if(is_string($input_xml)) {
			$parsed = $xml->loadXML($input_xml);
			if(!$parsed) {
				throw new Exception('[XML2Array] Error parsing the XML string.');
			}
		} else {
			if(get_class($input_xml) != 'DOMDocument') {
				throw new Exception('[XML2Array] The input XML object should be of type: DOMDocument.');
			}
			$xml = self::$xml = $input_xml;
		}
		$array[$xml->documentElement->tagName] = self::convert($xml->documentElement);
        self::$xml = null;    // clear the xml node in the class for 2nd time use.
        return $array;
    }

    /**
     * Convert an Array to XML
     * @param mixed $node - XML as a string or as an object of DOMDocument
     * @return mixed
     */
    private static function &convert($node) {
		$output = array();

		switch ($node->nodeType) {
			case XML_CDATA_SECTION_NODE:
				$output['@cdata'] = trim($node->textContent);
				break;

			case XML_TEXT_NODE:
				$output = trim($node->textContent);
				break;

			case XML_ELEMENT_NODE:

				// for each child node, call the covert function recursively
				for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
					$child = $node->childNodes->item($i);
					$v = self::convert($child);
					if(isset($child->tagName)) {
						$t = $child->tagName;

						// assume more nodes of same kind are coming
						if(!isset($output[$t])) {
							$output[$t] = array();
						}
						$output[$t][] = $v;
					} else {
						//check if it is not an empty text node
						if($v !== '') {
							$output = $v;
						}
					}
				}

				if(is_array($output)) {
					// if only one node of its kind, assign it directly instead if array($value);
					foreach ($output as $t => $v) {
						if(is_array($v) && count($v)==1) {
							$output[$t] = $v[0];
						}
					}
					if(empty($output)) {
						//for empty nodes
						$output = '';
					}
				}

				// loop through the attributes and collect them
				if($node->attributes->length) {
					$a = array();
					foreach($node->attributes as $attrName => $attrNode) {
						$a[$attrName] = (string) $attrNode->value;
					}
					// if its an leaf node, store the value in @value instead of directly storing it.
					if(!is_array($output)) {
						$output = array('@value' => $output);
					}
					$output['@attributes'] = $a;
				}
				break;
		}
		return $output;
    }

    /*
     * Get the root XML node, if there isn't one, create it.
     */
    private static function getXMLRoot(){
        if(empty(self::$xml)) {
            self::init();
        }
        return self::$xml;
    }
}


?>