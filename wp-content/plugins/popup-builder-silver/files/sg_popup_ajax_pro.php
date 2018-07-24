<?php
function sgLazyLoading() {

	$popupId = (int)$_POST['popupId'];
	if($popupId == 0) {
		return;
	}
	$params = "";
	$postType = sgSanitizeAjaxField($_POST['postType']);
	$loadingNumber = (int)$_POST['loadingNumber'];
	$customParams = $_POST['customParams'];
	$defArray = array();

	/* When load first time need add Home page in Wp pages */
	if($loadingNumber == 0) {
		$defArray = array(-1 => 'Home page');
	}

	if($postType == SG_POST_TYPE_PAGE) {
		$pageData = SgPopupPro::getAllData($defArray, 'page', $loadingNumber);
	}
	if($postType == SG_POST_TYPE_POST) {
		$pageData = SgPopupPro::getAllData($defArray, 'post', $loadingNumber);
	}
	if($postType == 'allCustomPosts') {
		$pageData = array();
		foreach ($customParams['customPosts'] as $value) {
			$currentData = SgPopupPro::getAllData(array(), $value, $loadingNumber);
			$pageData += $currentData;
		}
	}

	if($loadingNumber > 0 && count($pageData) == 0) {
		die();
	}

	/* When popup is insert */
	if($popupId != -1) {
		$popup = SGPopup::findById($popupId);
		$options = $popup->getOptions();
		$options = json_decode($options, true);

		if($postType == SG_POST_TYPE_PAGE) {
			$allSelectedPages = $options['allSelectedPages'];
		}
		else if($postType == SG_POST_TYPE_POST) {
			$allSelectedPages = $options['allSelectedPosts'];
		}
		else if($postType == 'allCustomPosts') {
			$allSelectedPages = $options['allSelectedCustomPosts'];
		}
	}

	foreach ($pageData as $key => $value) {
		/* Add Home page in Wp pages array */
		if($popupId != -1) {
			$selected = "";
			if(isset($allSelectedPages) && @in_array($key, $allSelectedPages)) {
				$selected = "selected";
			}
		}
		else {
			$selected = "";
		}

		$params .= "<option value='".$key."' $selected>$value</option>";
	}
	echo $params;
	die();
}
add_action('wp_ajax_lazy_loading', 'sgLazyLoading');

function sgSendNewsletter() {
	
	global $wpdb;
	check_ajax_referer('sgPbNewsLetter', 'ajaxNonce');
	$newslatterData = $_POST['NewsLatterData'];
	/*Change to default status*/
	$updateStatusQuery = $wpdb->prepare("UPDATE ". $wpdb->prefix ."sg_subscribers SET status=0 where subscriptionType = %s",$newslatterData['subsFormType']);
	$wpdb->query($updateStatusQuery);
	$deleteFromErrorLog = $wpdb->prepare("DELETE FROM ". $wpdb->prefix ."sg_subscription_error_log WHERE popupType=%s",$newslatterData['subsFormType']);
	$wpdb->query($deleteFromErrorLog);
	
	wp_schedule_event( time(), 'newsLetterSendEveryMinute', 'sgnewsletter_send_messages', array(json_encode($newslatterData)));
	
	die();
}
add_action('wp_ajax_send_newsletter', 'sgSendNewsletter');