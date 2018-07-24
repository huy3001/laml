<?php
class SgPopupPro
{
	public static function sgPopupExtraSanitize($content)
	{

		return do_shortcode($content);
	}

	public static function showUserResolution($popupId) {

		$obj = SGPopup::findById($popupId);
		if(!$obj) {
			return true;
		}
		$options = json_decode($obj->getOptions(), true);
		$loged = $options['loggedin-user'];
		$userSeperateStatus = $options['sg-user-status'];
		if(empty($userSeperateStatus)) {
			return true;
		}
		$user = self::getUser();
		if(isset($user->data->user_login) && $loged == 'true') {
			return true;
		}
		if(!isset($user->data->user_login) && $loged == 'false') {
			return true;
		}
		return false;
	}

	public static function getUser() {
		return wp_get_current_user();
	}

	public static function getAllData($firstData, $type, $offset)
	{
		$pages = array();
		$allPages = array();
		$wooCategoryPages = array();

		$args = array(
			'offset'           => $offset*SG_POSTS_PER_PAGE,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_status'      => 'publish',
			'suppress_filters' => true
		);
		$prod_cat_args = array(
			'taxonomy'     => 'product_cat', //woocommerce
			'orderby'      => 'name',
			'empty'        => 0
		);

		$wooCategories = get_categories( $prod_cat_args );

		if(!empty($wooCategories)) {
			foreach($wooCategories as $woo_category) {
				$wooCategoryPages[$woo_category->cat_ID] = $woo_category->name." - Category Page";
			}
		}

		if($type == 'post') {
			$args["post_type"] = 'post';
			$args["posts_per_page"] = SG_POSTS_PER_PAGE;
			$pages = get_posts($args);
		}
		if($type == 'page') {
			$args["post_type"] = 'page';
			$args["number"] = SG_POSTS_PER_PAGE;
			$pages = get_pages($args);
		}
		else {
			$args["post_type"] = $type;
			$args["posts_per_page"] = SG_POSTS_PER_PAGE;
			$pages = get_posts($args);
		}

		foreach ($pages as $page) {
			$page = @get_object_vars($page);
			$id = $page['ID'];
			$title = $page['post_title'];
			@$allPages[$id] .= $title;
		}
		$data = $firstData + $allPages;

		if($type == 'page' && !empty($allPages)) {
			$data += $wooCategoryPages;
		}

		return $data;
	}

	public static function multiSelect($name, $isAllSelected, $size, $data, $selectedData)
	{

		if($size < count($data)) {
			$size = count($data);
		}

		$select = '<select multiple data-slectbox="'.$name.'" size="'.$size.'">';

		foreach ($data as $key => $title) {

			$selected = '';
			$optionValue = $key;

			$chekedStatus = @in_array($optionValue, $selectedData);

			if(!empty($selectedData)) {
				$isAllSelected = false;
			}

			if($isAllSelected) {
				$selected = "selected";
			}
			if($chekedStatus) {
				$selected = "selected";
			}

			$select .= "<option value=$optionValue ". @$selected.">".$title."</option>";
		}
		$select .= "</select>";
		return $select;
	}

	public static function allowPopupInAllPages($pageId, $type)
	{
		$popupsId = array();
		$homePageKey = -1; /* for all pages */
		if(defined('ICL_LANGUAGE_CODE')) {
			$homePageKey.='_'.ICL_LANGUAGE_CODE;
		}

		if(SGPopup::findInAllSelectedPages($pageId, $type)) {
            $popups = SGPopup::findInAllSelectedPages($pageId, $type);
        }
        else if(is_home() && $pageId == 0) {
            $popups = SGPopup::findInAllSelectedPages($homePageKey, $type);
        }
        else if(is_front_page()) {
            $popups = SGPopup::findInAllSelectedPages($homePageKey, $type);
        }

		if(!isset($popups[0])) {
			return $popupsId;
		}
		$popups = array_reverse($popups);

		foreach ($popups as $popup) {
			array_push($popupsId, $popup['popupId']);
		}

		return $popupsId;
	}

	public static function popupInSchedule($popupId) {

		$obj = SGPopup::findById($popupId);

		if(empty($obj)) {
			return true;
		}

		$options = $obj->getOptions();
		$options = json_decode($options, true);

		$scheduleStatus = @$options['popup-schedule-status'];
		$scheduleStartTime = @$options['schedule-start-time'];
		$scheduleEndTime = @$options['schedule-end-time'];
		$allSelectedWeekDays  = @$options['schedule-start-weeks'];
		$popupTimeZone = @SgPopupGetData::getPopupTimeZone();

		if($scheduleStatus) {
			$currentWeekDayName = date('D');

			if(@in_array($currentWeekDayName,$allSelectedWeekDays)) {
				$date = new DateTime('now', new DateTimeZone($popupTimeZone));
				$currentHour =  $date->format('H:i');

				$currentHour = strtotime($currentHour);

				$startTime = @strtotime($scheduleStartTime);
				$endTime = @strtotime($scheduleEndTime);

				if(empty($scheduleEndTime)) {
					$endTime = @strtotime("23:59:59");
				}

				if($currentHour >= $startTime && $currentHour <= $endTime) {
					return true;
				}
			}

			return false;
		}
		else {
			return true;
		}
	}

	public static function allowPopupInAllCategories($pageId)
	{
		$popupsId = array();
		$categories = wp_get_post_categories($pageId);

		if(!empty($categories)) {
			foreach ($categories as $category) {

				$popups = SGPopup::findInAllSelectedPages($category, 'categories');

				if(empty($popups)) {
					continue;
				}
				foreach ($popups as $popup) {

					if(!in_array($popup['popupId'], $popupsId)) {
						array_push($popupsId, $popup['popupId']);
					}
				}
			}
			return $popupsId;
		}
		return $popupsId;
	}

	public static function popupInTimeRange($popupId)
	{

		$obj = SGPopup::findById($popupId);

		if(empty($obj)) {
			return true;
		}

		$options = $obj->getOptions();
		$options = json_decode($options, true);
		$timerStatus = @$options['popup-timer-status'];
		$startingDate = @strtotime($options['popup-start-timer']);

		$finishDate = false;
		if(!empty($options['popup-finish-timer'])) {
			$finishDate = @strtotime($options['popup-finish-timer']);
		}

		$popupTimeZone = @SgPopupGetData::getPopupTimeZone();
		$timeDate = new DateTime('now', new DateTimeZone($popupTimeZone));
		$timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));

		if(empty($timerStatus)) { // if not timer for popup
			return true;
		}

		if($finishDate != false) { // when have start and finish date
			if($timeNow > $startingDate && $timeNow < $finishDate) {
				return true;
			}
		}
		else { // when have only start date
			if($timeNow > $startingDate) {
				return true;
			}
		}

		return false;
	}

	public static function isEmptySubsriptionForms() {
		global $wpdb;

		$getRows = $wpdb->get_var("SELECT count(*) FROM ". $wpdb->prefix ."sg_popup WHERE type='subscription'");
		return $getRows;
	}

	public static function popupsIdInAllCategories($categoryType) {

		$allPosts = get_option("SG_ALL_POSTS");
		$popupsId = array();

		if(empty($allPosts)) {
			return $popupsId;
		}
		if(!is_array($allPosts)) {
			$popupsId[] = $allPosts;
			return $popupsId;
		}
		/*In case if home page is latest posts, and if show on all pages option is enabled we need to show popup*/
		if(is_home()  || is_front_page()) {
			$categoryType = 'page';
		}

		foreach ($allPosts as $key => $value) {
			if(in_array($categoryType, $value['popstTypes'])) {
				$postType = $value['id'];
				//if WPML language is equal to current page language
				if(!empty($value['lang']) && defined('ICL_LANGUAGE_CODE') && $value['lang'] != ICL_LANGUAGE_CODE) {
					continue;
				}
				array_push($popupsId, $postType);
			}
		}

		return $popupsId;
	}

	public static function filterForRandomIds($popupIds)
	{
		$popupIds = json_decode($popupIds, true);
		$notRandom = array();
		$random = array();

		if(!empty($popupIds)) {

			foreach($popupIds as $popupId) {
				$currentPopupObj = SGPopup::findById($popupId);
				//If there is no popup found continue iteration
				if(empty($currentPopupObj)) continue;
				$options = $currentPopupObj->getOptions();
				$options =  json_decode($options, true);

				if(!empty($options['randomPopup'])) {
					if(self::mustBeAddToRandomList($popupId, $options)) {
						$random[] = $popupId;
					}

					continue;
				}
				$notRandom[] = $popupId;
			}

			//if there is random data popup make operations, otherwise do nothing
			$countRandomPopups = count($random);
			if($countRandomPopups) {

				$randomKey = array_rand($random, 1);
				$randomPopupId = (int)$random[$randomKey];

				$randomPopup = (array)$randomPopupId;
				$popupIds = array_merge($randomPopup, $notRandom);
			}
		}
		return json_encode($popupIds);
	}

	private static function mustBeAddToRandomList($popupId, $popupOptions)
	{
		$status = false;
		$isActive = SgPopupGetData::isActivePopup($popupId);
		if(empty($_COOKIE['sgPopupDetails'.$popupId]) && !empty($isActive)) {
			$status = true;
		}

		return $status;
	}

	public static function getSubscribersCount()
	{
		global $wpdb;
		$count = $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix .'sg_subscribers');

		return (int)$count;
	}
}
