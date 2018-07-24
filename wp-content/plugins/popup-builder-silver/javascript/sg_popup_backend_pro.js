function backendPro() {

}

backendPro.prototype.dataImport = function() {

	var custom_uploader;
	jQuery('#js-upload-export-file').click(function(e) {
		e.preventDefault();
		var ajaxNonce = jQuery(this).attr('data-ajaxNonce');

		/* If the uploader object has already been created, reopen the dialog */
		if (custom_uploader) {
			custom_uploader.open();
			return;
		}

		/* Extend the wp.media object */
		custom_uploader = wp.media.frames.file_frame = wp.media({
			titleFF: 'Select Export File',
			button: {
				text: 'Select Export File'
			},
			multiple: false,
			library : { type  :  'text/plain'}
		});
		/* When a file is selected, grab the URL and set it as the text field's value */
		custom_uploader.on('select', function() {
			attachment = custom_uploader.state().get('selection').first().toJSON();

			var data = {
				action: 'import_popups',
				ajaxNonce: ajaxNonce,
				attachmentUrl: attachment.url
			};
			jQuery(".js-sg-import-gif").removeClass("sg-hide-element");
			jQuery.post(ajaxurl, data, function(response,d) {
				location.reload();
				jQuery(".js-sg-import-gif").addClass("sg-hide-element");
			});
		});
		/* Open the uploader dialog */
		custom_uploader.open();
	});

};

backendPro.prototype.addSelectboxValuesIntoInput = function() {

	var that = this;
	if(!jQuery(".js-sg-selected-pages").length) {
		return;
	}

	var selectedPages = jQuery(".js-sg-selected-pages").val().split(",");
	var selectedPosts = jQuery(".js-sg-selected-posts").val().split(",");
	var selectedCustomPosts = jQuery(".js-sg-selected-custom-posts").val().split(",");

	jQuery("#add-form").submit(function(e) {

		var pages = jQuery("select[data-slectbox='all-selected-page'] > option");
		var posts = jQuery("select[data-slectbox='all-selected-posts'] > option");
		var customPosts = jQuery("select[data-slectbox='all-selected-custom-posts'] > option");

		selectedPages = that.dataProcesingInHiddenInput(selectedPages, pages);
		selectedPosts = that.dataProcesingInHiddenInput(selectedPosts, posts);
		selectedCustomPosts = that.dataProcesingInHiddenInput(selectedCustomPosts, customPosts);

		jQuery(".js-sg-selected-posts").val(selectedPosts);
		jQuery(".js-sg-selected-pages").val(selectedPages);
		jQuery(".js-sg-selected-custom-posts").val(selectedCustomPosts);
	});
};

backendPro.prototype.dataProcesingInHiddenInput = function(selectedPages, pages) {
	selectedPages = [];

	for(i=0; i<pages.length; i++) {

		var currentOption = pages[i];
		var currentValue = currentOption.value;
		var selected = jQuery(currentOption).is(":selected");
		/*return -1 when does not have that value*/
		var isHaveThisInValues = selectedPages.indexOf(currentOption.value);

		if(selected) {

			if(isHaveThisInValues == '-1') {
				selectedPages.push(currentOption.value);
			}
		}
		else {
			if(isHaveThisInValues != -1) {
				selectedPages.splice(isHaveThisInValues, 1);
			}
		}
	}

	return selectedPages;
};

backendPro.prototype.resetLoadingNumber = function() {
	var that = this;

	jQuery("[name='all-custom-posts[]']").bind("change", function() {
		jQuery("[name='allCustomPosts']").attr("data-loading-number", 0);
		jQuery('.js-all-custom-posts').html("");
		that.prepareToAjax(jQuery("[name='allCustomPosts'][value='selected']"));
	})
};

backendPro.prototype.lazyLoading = function() {
	var that = this;

	jQuery("input[value='selected']:checked").each(function() {
		that.prepareToAjax(jQuery(this));
	});

	jQuery("input[value='selected']").bind("change",function() {
		that.prepareToAjax(jQuery(this));
	});

	jQuery(".js-multiselect").scroll(function(e) {
		var elem = jQuery(e.currentTarget);
	    if (elem[0].scrollHeight - elem.scrollTop() <= elem.outerHeight()) {
	    	var name = jQuery(this).attr("data-sorce");
	    	dataInput = jQuery("[name="+name+"][value='selected']");
	        that.prepareToAjax(dataInput);
	    }
	});


};

/**
 *
 * @since 3.1.5
 *
 * @return array
 */

backendPro.prototype.getAllCustomPosts = function() {

	var values = [];

	jQuery("[name='all-custom-posts[]'] option:selected").each(function() {
		values.push(jQuery(this).val());
	});

	return values;
};

backendPro.prototype.prepareToAjax = function(dataInput) {

	if(dataInput.length != 1) {
		return false;
	}

	var customParams = {};
	var ajaxNoncePages = dataInput.attr('data-ajaxNoncePages');
	var popupId = dataInput.attr("data-popupid");
	var selectboxClass = dataInput.attr("data-selectbox-role");
	var selectBoxSelector = dataInput.attr("data-selectbox-role");
	var postType = dataInput.attr("data-name");
	var loadingNumber = dataInput.attr("data-loading-number");

	if(postType == 'allCustomPosts') {
		customParams.customPosts = this.getAllCustomPosts();
	}

	var selectBoxData = {
		popupId: popupId,
		ajaxNoncePages: ajaxNoncePages,
		selectboxClass: selectboxClass,
		postType: postType,
		selectBoxSelector: selectBoxSelector,
		loadingNumber: loadingNumber,
		dataInput: dataInput,
		customParams: customParams
	};

	this.lazyLoadViaAjax(selectBoxData);
};

backendPro.prototype.lazyLoadViaAjax = function(selectBoxData) {

	var selectboxClass = selectBoxData['selectBoxSelector'];

	var data = {
		action: 'lazy_loading',
		popupId: selectBoxData['popupId'],
		postType: selectBoxData['postType'],
		loadingNumber: selectBoxData['loadingNumber'],
		customParams: selectBoxData['customParams'],
		beforeSend: function() {
			jQuery('.spiner-'+selectBoxData['postType']).removeClass("sg-hide-element");
		},
	};

	jQuery.post(ajaxurl, data, function(response,d) {

		selectBoxData['dataInput'].removeAttr("data-loading-number");
		selectBoxData['dataInput'].attr("data-loading-number",++selectBoxData['loadingNumber']);
		jQuery("."+selectboxClass).append(response);
		jQuery("."+selectboxClass).nextAll(".js-sg-spinner").addClass("sg-hide-element");
	});
};

backendPro.prototype.timepicker = function() {
	if(jQuery('.sg-time-picker').length == 0) return;
	jQuery('.sg-time-picker').datetimepicker({
		datepicker:false,
		format:'H:i'
	});
};

backendPro.prototype.addToSubscribers = function() {
	var that = this;

	jQuery(".sg-add-to-list-button").bind('click', function() {
		var ajaxNonce = jQuery(this).attr('data-ajaxNonce');
		var susbEmail = jQuery(".add-subs-email").val();
		var subsFirstName = jQuery(".subs-first-name").val();
		var subsLastName = jQuery(".subs-last-name").val();
		var listSubscriptonType = [];

		jQuery(".js-sg-newslatter-forms > option").each(function() {
			if(jQuery(this).prop("selected")) {
				listSubscriptonType.push(jQuery(this).val());
			}
		});
		var validateEmail = susbEmail.search(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

		if(validateEmail == -1) {
			jQuery(".sg-email-error").removeClass("sg-hide-element");
			return;
		}
		jQuery(".sg-email-error").addClass("sg-hide-element");

		var data = {
			action: 'add_to_subsribers',
			ajaxNonce: ajaxNonce,
			firstName: subsFirstName,
			lastName: subsLastName,
			email: susbEmail,
			subsType: listSubscriptonType,
			beforeSend: function() {
				jQuery(".js-sg-spinner").removeClass("sg-hide-element");
			}
		};

		that.addToSubscribersViaAjax(data);
	});
};

backendPro.prototype.addToSubscribersViaAjax = function(data) {
	jQuery.post(ajaxurl, data, function(response,d) {
		jQuery(".js-sg-spinner").addClass("sg-hide-element");
		jQuery(".sg-successfully").removeClass("sg-hide-element");
	});
};

backendPro.prototype.fixSublsrcitionBulkCheckbox = function() {
	jQuery('#bulk,.column-bulk').removeClass().addClass('manage-column column-cb check-column');
};

backendPro.prototype.toggleCheckedSubsribers = function() {
	var that = this;
	jQuery('.subs-bulk').each(function() {
		jQuery(this).bind('click', function() {
			var bulkStatus = jQuery(this).prop("checked");
			that.changeCheckedSubscribers(bulkStatus);
		});
	});
};

backendPro.prototype.changeCheckedSubscribers = function(bulkSTatus) {

	jQuery('.subs-delete-checkbox').each(function() {
		jQuery(this).prop( "checked", bulkSTatus );
	})
};

backendPro.prototype.deleteSubscribers = function() {
	var checkedSubscribersList = [];
	var that = this;
	jQuery('.sg-subs-delete-button').bind('click', function() {
		var isSure = confirm('Are you sure?');

		if(!isSure) {
			return;
		}
		var data = {};
		data.ajaxNonce = jQuery(this).attr('data-ajaxNonce');
		jQuery('.subs-delete-checkbox').each(function() {
			var isChecked = jQuery(this).prop('checked');
			if(isChecked) {
				var subscriberId = jQuery(this).attr('data-delete-id');
				checkedSubscribersList.push(subscriberId);
			}
		});
		if(checkedSubscribersList.length == 0) {
			alert('Please select at least one subscriber.');
		}
		else {
			that.deleteSbubsribersViaAjax(checkedSubscribersList, data);
		}
	})
};

backendPro.prototype.deleteSbubsribersViaAjax = function(checkedSubscribersList, subsData) {

	var data = {
		action: 'subsribers_delete',
		ajaxNonce: subsData.ajaxNonce,
		subsribersId: checkedSubscribersList,
		beforeSend: function() {
			jQuery('.spiner-subscribers').removeClass("sg-hide-element");
		},
	};

	jQuery.post(ajaxurl, data, function(response,d) {
		jQuery('.spiner-subscribers').addClass("sg-hide-element");
		jQuery('.subs-delete-checkbox').prop('checked', '');
		window.location.reload();
	});
};

backendPro.prototype.getTinymceContent = function(){
    if (jQuery(".wp-editor-wrap").hasClass("tmce-active")){
        return tinyMCE.activeEditor.getContent();
    }else{
        return jQuery("#sg_newsletter_text").val();
    }
};

backendPro.prototype.sendNewsletter = function() {
	var that = this;

	jQuery('.sg-newsletter-sumbit').bind('click',function() {
		var ajaxNonce = jQuery(this).attr('data-ajaxNonce');
		var subsFormType = jQuery('.js-sg-newslatter-forms option:selected').val();
		var emailsOneTime = jQuery('.sg-emails-in-flow').val();
		var newsletterSubject = jQuery('.sg-newsletter-subject').val();
		var fromEmail = jQuery(".sg-newsletter-from-email").val();
		var validateEmail =  fromEmail.search(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
		if(validateEmail == -1) {
			alert('Please enter a valid email.');
			return;
		}

		var messageBody = that.getTinymceContent();

		var optionData = {};
		optionData.ajaxNonce = ajaxNonce;
		var NewsLatterData = {
			'subsFormType': subsFormType,
			'emailsOneTime': emailsOneTime,
			'fromEmail': fromEmail,
			'newsletterSubject': newsletterSubject,
			'messageBody': messageBody
		};

		that.sendNewsletterViaAjax(NewsLatterData, optionData);
	});
};

backendPro.prototype.sendNewsletterViaAjax = function(NewsLatterData, optionData) {

	var data = {
		action: 'send_newsletter',
		ajaxNonce: optionData.ajaxNonce,
		NewsLatterData: NewsLatterData,
		beforeSend: function() {
			jQuery(".js-sg-send-subsribe").removeClass('sg-hide-element');
		}
	};
	jQuery.post(ajaxurl, data, function(response,d) {
		jQuery(".js-sg-send-subsribe").addClass('sg-hide-element');
		jQuery(".sgpb-newsletter-notice").removeClass('sg-hide-element');
	});
};

backendPro.prototype.addSubscriptionReload = function() {
	var that = this;
	jQuery('.add-subsriber').bind('click', function () {
		that.pageUrl =  window.location.href;
	});
	jQuery(".sg-close").bind('click', function() {
		window.location.reload(that.pageUrl);
		window.location.replace(that.pageUrl);
	});
};

backendPro.prototype.sgDownloadSubsErrorLogs = function() {
	jQuery(".js-sg-newslatter-forms").change(function() {

		var subsType = jQuery(this,'option').val();
		var ajaxNonce = jQuery(this).attr('data-ajaxNonce');

		var data = {
			action: 'subs_error_log_count',
			ajaxNonce: ajaxNonce,
			subsType: subsType
		};
		jQuery.post(ajaxurl, data, function(countErrorLogs,d) {
			if(countErrorLogs != 0) {
				jQuery(".sg-subs-error-list").attr("data-subs-list", subsType);
				jQuery(".sg-subs-error-list").removeClass("sg-hide-element");
			}
			else {
				jQuery(".sg-subs-error-list").attr("data-subs-list",'');
				jQuery(".sg-subs-error-list").addClass("sg-hide-element");
			}
		});
	});
	jQuery(".js-sg-newslatter-forms").trigger("change");
};

backendPro.prototype.popupTimer = function() {

	var startTimerOptions = {
		format:'M d y H:i',
		minDate: 0
	};
	var finishTimerOptions = {
		format:'M d y H:i',
		minDate: 0
	};

	/*  for escape javascript erros if element does not exist */
	if(jQuery('.popup-start-timer').length == 0) return;

	var startCalendar = jQuery('.popup-start-timer').datetimepicker(startTimerOptions);
	var finishCalendar = jQuery('.popup-finish-timer').datetimepicker(finishTimerOptions);

	/* Detect statrt change for disable finish date before current start date */
	startCalendar.change(function() {
		/* Current start date */
		var currentStartDate = jQuery(this).val();
		/*Start date to UTC for for minDate */
		var startDate = new Date(currentStartDate);

		var finishTimerOptions = {
			format:'M d y H:i',
			minDate: startDate
		};
		/*Change finish minimum date disabel days */
		jQuery('.popup-finish-timer').datetimepicker(finishTimerOptions)
	});
};


backendPro.prototype.init = function() {
	this.dataImport();
	this.resetLoadingNumber();
	this.lazyLoading();
	this.addSelectboxValuesIntoInput();
	this.addToSubscribers();
	this.timepicker();
	this.fixSublsrcitionBulkCheckbox();
	this.toggleCheckedSubsribers();
	this.deleteSubscribers();
	this.sendNewsletter();
	this.addSubscriptionReload();
	this.sgDownloadSubsErrorLogs();
	this.popupTimer();
};

jQuery(document).ready(function() {
	var proObj = new backendPro();
	proObj.init();
});
