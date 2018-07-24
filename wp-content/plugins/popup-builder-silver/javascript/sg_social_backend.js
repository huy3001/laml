function SGSocialPopup() {

	this.roundButton = '';
}

SGSocialPopup.prototype.init = function() {

	var that = this;

	this.roundButton = jQuery('[name = sgRoundButton]');
	this.jsSocial();

	jQuery('input[name = sgSocialLabel]').change(function() {
		var inputValue = jQuery(this).is(':checked');
		that.options.showLabel = inputValue;
		that.jsSocial();
		that.changeToRoundButtons(that.roundButton.is(':checked'));
	});

	jQuery('select[name = sgSocialShareCount]').on('change',function() {
		var countPosition = jQuery(this).val();
		that.checkCountPosition(countPosition);
		that.changeToRoundButtons(that.roundButton.is(':checked'));
	});

	jQuery('[name = sgRoundButton]').bind('change',function() {
		var inputValue = jQuery(this).is(':checked');
 		that.changeToRoundButtons(inputValue);
	});

	jQuery("[name='sgSocialButtonsSize']").bind('change',function() {
		var fontSize = jQuery('[name="sgSocialButtonsSize"]').val();
		jQuery('#share-btns-container').css({'font-size' : fontSize+"px"});
	});

	jQuery("[name='sgSocialTheme']").bind('change',function() {
		var cosialThemeName = jQuery("[name='sgSocialTheme']").val();
		that.switchTheme();
	});

	jQuery(".js-social-btn-status").bind('change',function() {
		var socialButtonStatus = jQuery(this).is(':checked');
		var socialButtonName = jQuery(this).attr('data-social-button');

		that.buttonShowStatus(socialButtonStatus, socialButtonName);
		that.changeToRoundButtons(that.roundButton.is(':checked'));
	});

	jQuery(".js-social-btn-text").bind('input',function() {
		var btnText = jQuery(this).val();
		var btnType = jQuery(this).attr('data-social-button');

		that.changeButtonText(btnText, btnType);
		that.changeToRoundButtons(that.roundButton.is(':checked'));
	});

	jQuery('.sg-active-url').bind('change', function() {
		var shareUrl = jQuery(this).val();
		that.shareForAdminUrl(shareUrl);
	});

	jQuery('.socialTriger').trigger('change');
	jQuery('select[name = sgSocialShareCount]').trigger('change');
	jQuery("[name='sgSocialButtonsSize']").trigger('change');
	jQuery("[name='sgSocialTheme']").trigger('change');
	jQuery('[name = sgRoundButton]').trigger('change');
	jQuery('.sg-active-url').trigger('change');
};

SGSocialPopup.prototype.checkCountPosition = function(position) {

	if (position == 'false') {
		position = false;
	}
	else if(position == 'true')  {
		position = true;
	}
	else {
		position = position;
	}

	this.options.showCount = position;
	this.jsSocial();
};

/* Add url to admin socails */
SGSocialPopup.prototype.shareForAdminUrl = function(shareUrl) {

	this.options.url = shareUrl;
	this.jsSocial();
};

SGSocialPopup.prototype.changeToRoundButtons = function(inputValue) {

	if(inputValue == true) {
		jQuery('.jssocials-share-link').addClass("js-social-round-btn");
	}
	else {
		jQuery('.jssocials-share-link').removeClass("js-social-round-btn");
	}
};

SGSocialPopup.prototype.switchTheme = function() {

	var newTheme = jQuery("[name=sgSocialTheme]").val();
	var $cssLink = jQuery('#jssocials_theme_tm-css');
	var cssPath = $cssLink.attr("href");
	$cssLink.attr("href", cssPath.replace(this.currentTheme, newTheme));
	this.currentTheme = newTheme;
};

/* Change Social buttons Name for Admin view onchange event */
SGSocialPopup.prototype.changeButtonText = function(buttonText, buttonName) {

	var socialArray = this.options.shares;
	var nameIndex = '';

	for(var index in socialArray) {
		if(socialArray[index] == buttonName && typeof(socialArray[index]) == 'string') {
			nameIndex = index;
		}
		else if(socialArray[index]['share'] == buttonName) {
			nameIndex = index;
		}
	}

	if(jQuery("input[type='checkbox'][data-social-button="+buttonName+"]").is(":checked")) {
		this.options.shares[nameIndex] = {'share': buttonName,'label': buttonText};
		this.jsSocial();
	}

};

SGSocialPopup.prototype.buttonShowStatus = function(socialButtonStatus, socialButtonName) {

	var sharesLength = this.options.shares.length;
	var that = this;
	var buutonCustomName = jQuery("input[type='text'][data-social-button="+socialButtonName+"]").val();

	if(socialButtonStatus) {
		if(!buutonCustomName) {
			this.options.shares[sharesLength] = socialButtonName;
		}
		else {
			this.options.shares[sharesLength] = {'share': socialButtonName,'label': buutonCustomName};
		}
	}
	else {
		var elementIndex = this.options.shares.indexOf(socialButtonName);
		if(elementIndex == -1) {
			for(var i=0; i< sharesLength; i++) {
				if(typeof that.options.shares[i] !== 'string' && that.options.shares[i].share == socialButtonName) {
					elementIndex = i;
				}
			}
		}
		this.options.shares.splice(elementIndex,1);
	}
	this.jsSocial();
};

/* For onload check hide or show */
SGSocialPopup.prototype.buttonsChecked =  function() {

	var that = this;

	var elements = jQuery(".js-social-btn-status");
	this.options.showLabel = jQuery('input[name = sgSocialLabel]').is(':checked');

	var sharesLength = this.options.shares.length;
	jQuery.each(elements, function() {
		var buutonCustomName = jQuery("input[type='text'][data-social-button="+jQuery(this).attr('data-social-button')+"]").val();
		if(jQuery(this).is(":checked")) {
			if(!buutonCustomName) {
				that.options.shares[sharesLength] = jQuery(this).attr('data-social-button');
			}
			else {
				that.options.shares[sharesLength] = {'share': jQuery(this).attr('data-social-button'),'label': buutonCustomName}
			}

			sharesLength++;
		}
	});

	this.jsSocial();
	that.changeToRoundButtons(that.roundButton.is(':checked'));
};

SGSocialPopup.prototype.currentTheme = 'classic';

SGSocialPopup.prototype.options = {

	url: "http://sygnoos.com",
	text: "Google Search Page",
	showLabel: false,
	showCount: true,
	shares: []
};

SGSocialPopup.prototype.jsSocial = function() {

	return jQuery('#share-btns-container').jsSocials(this.options);
};

jQuery(document).ready(function($) {
	
	var objSocial = new SGSocialPopup();
	objSocial.init();
	objSocial.buttonsChecked();
});
