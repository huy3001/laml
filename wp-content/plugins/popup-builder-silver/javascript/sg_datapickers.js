function SgPickers() {

}

SgPickers.prototype.init = function() {

	jQuery(".sg-calndar").addClass("input-width-static");

	jQuery('.sg-calndar').bind("click",function() {
		jQuery("#ui-datepicker-div").css({'z-index': 9999});
	});
};

jQuery(document).ready(function($){

	var pickersObj = new SgPickers();
	pickersObj.init();
});