<?php
require_once(dirname(__FILE__).'/SGPopup.php');

class SGIframePopup extends SGPopup {
	private $url;

	public function setUrl($url) {
		$this->url = $url;
	}
	public function getUrl() {
		return $this->url;
	}
	public static function create($data, $obj = null) {
		$obj = new self();

		$obj->setUrl($data['iframe']);

		parent::create($data, $obj);
	}

	public function save($data = array()) {

		$editMode = $this->getId()?true:false;

		$res = parent::save($data);
		if ($res===false) {
			return false;
		}

		global $wpdb;
		if ($editMode) {
			$sql = $wpdb->prepare("UPDATE ". $wpdb->prefix ."sg_iframe_popup SET url=%s WHERE id=%d",$this->getUrl(),$this->getId());
			$res = $wpdb->query($sql);
		}
		else {

			$sql = $wpdb->prepare( "INSERT INTO ". $wpdb->prefix ."sg_iframe_popup (id, url) VALUES (%d,%s)",$this->getId(),$this->getUrl());
			$res = $wpdb->query($sql);
		}
		return $res;
	}

	public function getRemoveOptions()
	{
		return array('popup-content-padding' => 1, 'popupContentBgImage' => 1,'contentClick' => 1);
	}

	protected function setCustomOptions($id) {
		global $wpdb;
		$st = $wpdb->prepare("SELECT * FROM ". $wpdb->prefix ."sg_iframe_popup WHERE id = %d",$id);
		$arr = $wpdb->get_row($st,ARRAY_A);
		$this->setUrl($arr['url']);
	}

	protected function getExtraRenderOptions() {

		$options = $this->getOptions();
		$extraOptions =  array('iframe'=>$this->getUrl());
		$optionsArray = json_decode($options,true);
		if(!empty($optionsArray)
			&& $optionsArray['popup-dimension-mode'] == 'responsiveMode') {

			if($optionsArray['popup-responsive-dimension-measure'] == 'auto') {
				$extraOptions['popup-responsive-dimension-measure'] = '60%';
				$extraOptions['height'] = '50%';
			}

		}

		return $extraOptions;
	}

	public  function render() {
		return parent::render();
	}
}