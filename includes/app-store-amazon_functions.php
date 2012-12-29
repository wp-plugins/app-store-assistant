<?php
define('DEBUG', false);


//hash_hmac code from comment by Ulrich in http://mierendo.com/software/aws_signed_query/
//sha256.inc.php from http://www.nanolink.ca/pub/sha256/ 



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
                    'ProductDescription' => $ProductDescription,
                    'BookDescription' => $BookDescription,
                    'Amount' => $Amount,
                    'Currency' => $CurrencyCode,
                    'ReleaseDate' => $ReleaseDate,
                    'PublishedDate' => $PublishedDate,
                    'ListPrice' => $ListPrice,
                    'Binding' => $Binding,
                    'Authors' => $Authors,
                    
				    'Director' => $Director,
				    'Cast' => $Actors,
				    'Rating' => $Rating,
				    'Formats' => $Formats,
				    'Languages' => $Languages,
				    'OfferListingId' => $OfferListingId,
				    'RunTime' => $RunTime,
                    'Errors' => $Result['itemlookuperrorresponse']['error']
                   );
    return $formattedResults;  
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