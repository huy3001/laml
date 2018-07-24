function SgSocialFront() {

}

SgSocialFront.prototype.init = function() {

	var sgSocialLabel = '';
	var socialArray = [];

	if(SgSocialParams.pushToBottom == 'on') { /* push to bottom param */
		jQuery('#sgcboxLoadedContent  #share-btns-container').addClass('sg-push-to-bottom');
		SGPopup.isPushToBottom();
	}
	if (SgSocialParams.sgEmailStatus == 'on') {
		if(SgSocialParams.sgMailLable == '') {
			socialArray.push('email');
		}
		else {
			socialArray.push({share:'email', label: SgSocialParams.sgMailLable});
		}
	}
	if (SgSocialParams.sgTwitterStatus == 'on') {
		if(SgSocialParams.sgTwitterLabel == '') {
			socialArray.push('twitter');
		}
		else {
			socialArray.push({share:'twitter', label: SgSocialParams.sgTwitterLabel});
		}
	}
	if (SgSocialParams.fbStatus == 'on') {
		if(SgSocialParams.fbShareLabel == '') {
			socialArray.push('facebook');
		}
		else {
			socialArray.push({share:'facebook', label: SgSocialParams.fbShareLabel});
		}
	}
	if (SgSocialParams.sgGoogleStatus == 'on') {
		if(SgSocialParams.sgGoogLelabel == '') {
			socialArray.push('googleplus');
		}
		else {
			socialArray.push({share:'googleplus', label: SgSocialParams.sgGoogLelabel});
		}
	}
	if (SgSocialParams.sgLinkedinStatus == 'on') {
		if(SgSocialParams.sgLindkinLabel == '') {
			socialArray.push('linkedin');
		}
		else {
			socialArray.push({share:'linkedin', label: SgSocialParams.sgLindkinLabel});
		}

	}
	if (SgSocialParams.sgPinterestStatus == 'on') {
		if(SgSocialParams.sgPinterestLabel == '')  {
			socialArray.push('pinterest');
		}
		else {
			socialArray.push({share:'pinterest', label: SgSocialParams.sgPinterestLabel});
		}
	}
	if (SgSocialParams.sgSocialLabel == 'on') {
		sgSocialLabel = true;
	}
	else {
		sgSocialLabel = false;
	}
	var sgShareUrl = SgSocialParams.sgShareUrl;
	var sgSocialOptions = {
		countUrl: sgShareUrl,
		shares: socialArray,
		showCount : SgSocialParams.sgSocialShareCount == 'false' ? false: SgSocialParams.sgSocialShareCount,
		showLabel : sgSocialLabel
	};
	if(sgShareUrl !== '') {
		sgSocialOptions.url = sgShareUrl;
	}
	
	jQuery('#sgcboxLoadedContent #share-btns-container').jsSocials(sgSocialOptions);
};