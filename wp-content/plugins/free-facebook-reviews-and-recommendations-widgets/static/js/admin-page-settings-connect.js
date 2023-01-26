if(typeof Trustindex_JS_loaded == 'undefined')
{
	var Trustindex_JS_loaded = {};
}

Trustindex_JS_loaded.connect = true;

// Autocomplete config
var Trustindex_Connect = null;
jQuery(document).ready(function($) {
	/*************************************************************************/
	/* NO REG MODE */
	Trustindex_Connect = {
		box: $('#trustindex-plugin-settings-page .autocomplete .results'),
		input: $('#trustindex-plugin-settings-page #page-link'),
		button: $('#trustindex-plugin-settings-page .btn-check'),
		form: $('#submit-form'),
		check: function(event) {
			event.preventDefault();

			if(!Trustindex_Connect.regex)
			{
				return false;
			}

			let m = Trustindex_Connect.regex.exec(Trustindex_Connect.input.val().trim());
			if(!Trustindex_Connect.is_regex_valid(m))
			{
				Trustindex_Connect.box.html('<span>'+ Trustindex_Connect.box.data('errortext') +'</span>');
				Trustindex_Connect.box.show();
				return false;
			}

			// support for 2 regexes
			let part1 = m[1] || m[3] || "";
			let part2 = m[2] || m[4] || "";

			let page_id = part1;
			if(part2)
			{
				if(part1)
				{
					page_id += Trustindex_Connect.page_id_separator;
				}

				page_id += part2;
			}

			let valid = true;
			if(Trustindex_Connect.form.data('platform') == 'arukereso')
			{
				page_id = page_id.replace(/^com/, 'bg');
			}
			else if(Trustindex_Connect.form.data('platform') == 'amazon')
			{
				valid = (
					!(page_id.indexOf("stores/") > -1
					|| page_id.indexOf("account/") > -1
					|| (page_id.indexOf("gp/") > -1 && page_id.indexOf("gp/product/") == -1)
					|| page_id.search(/\-\/[^\/]{2}\/[^\/]{2}$/) > -1
					)
					&& page_id.indexOf("product-reviews/") == -1
					&& page_id.indexOf("/AccountInfo/") == -1
					&& page_id.indexOf("/SellerProfileView/") == -1
				);
			}
			else if(Trustindex_Connect.form.data('platform') == 'tripadvisor')
			{
				// set source to first page
				let not_first_page = page_id.match(/\-or[\d]+\-/);
				if (not_first_page && not_first_page[0])
				{
					page_id = page_id.replace(not_first_page[0], '-');
				}

				// add .html if not in page_id
				if (page_id.indexOf(".html") == -1)
				{
					page_id = page_id + ".html";
				}
			}

			// no page_id
			if(page_id.trim() == '' || !valid)
			{
				Trustindex_Connect.box.html('<span>'+ Trustindex_Connect.box.data('errortext') +'</span>');
				Trustindex_Connect.box.show();
				return false;
			}

			Trustindex_Connect.box.hide();

			$('#ti-noreg-page-id').val(page_id);

			// show result
			let page_details = { id: page_id };
			let url = Trustindex_Connect.input.val().trim();

			let div = Trustindex_Connect.form.find('.ti-selected-source');
			Trustindex_Connect.form.find('#ti-noreg-page_details').val(JSON.stringify(page_details));

			div.find('img').attr('src', 'https://cdn.trustindex.io/assets/platform/Facebook/icon.png');
			div.find('.ti-source-info').html('<a target="_blank" href="'+ url +'">'+ url +'</a>');

			Trustindex_Connect.button.addClass('btn-disabled');
			div.fadeIn();
		},
		regex: /facebook\.com\/([^?#]*)/,
		is_regex_valid: function(m) {
			if(!m)
			{
				return false;
			}

			for(let i = 0; i < m.length; i++) {
				if(m[i] === "")
				{
					return false;
				}
			}

			return true;
		},
		page_id_separator: '|',
		async_request: function(callback) {
			// get url params
			let params = new URLSearchParams({
				type: 'facebook',
				page_id: $('#ti-noreg-page-id').val().trim(),
				access_token: $('#ti-noreg-access-token').length ? $('#ti-noreg-access-token').val() : "",
				webhook_url: $('#ti-noreg-webhook-url').val(),
				email: $('#ti-noreg-email').val(),
				token: $('#ti-noreg-connect-token').val(),
				version: $('#ti-noreg-version').val()
			});

			// show popup info
			$('#ti-connect-info').fadeIn();

			// open window
			let ti_window = window.open('https://admin.trustindex.io/source/wordpressPageRequest?' + params.toString(), 'trustindex', 'width=1000,height=1000,menubar=0');

			// wait for process complete
			window.addEventListener('message', function(event) {
				if(event.origin.startsWith('https://admin.trustindex.io/'.replace(/\/$/,'')) && event.data.success)
				{
					ti_window.close();

					$('#ti-connect-info').hide();

					callback($('#ti-noreg-connect-token').val(), event.data.request_id, typeof event.data.manual_download != 'undefined' && event.data.manual_download ? 1 : 0, event.data.place || null);
				}
				if(event.origin.startsWith('https://admin.trustindex.io/'.replace(/\/$/,'')) && !event.data.success)
				{
					ti_window.close();

					// reset connect form, with invalid input message
					Trustindex_Connect.form.find(".ti-selected-source").hide();
					Trustindex_Connect.button.removeClass("btn-disabled");
					Trustindex_Connect.box.html("<span>" + Trustindex_Connect.box.data("errortext") + "</span>");
					Trustindex_Connect.box.show();
				}
			});
		}
	};

	// check button clicked
	if(Trustindex_Connect.button.length)
	{
		Trustindex_Connect.button.click(Trustindex_Connect.check);
	}

	// show loading text on connect
	Trustindex_Connect.form.find('.btn-connect').on('click', function(event) {
		event.preventDefault();

		// change button
		let btn = $(this);

		btn.css('pointer-events', 'none');
		btn.addClass('btn-default').removeClass('btn-primary');
		btn.blur();
		TI_manage_dots(btn);

		Trustindex_Connect.button.css('pointer-events', 'none');

		// do request
		Trustindex_Connect.async_request(function(token, request_id, manual_download, place) {
			$('#ti-noreg-review-download').val(token);
			$('#ti-noreg-review-request-id').val(request_id);
			$('#ti-noreg-manual-download').val(manual_download);

			if(place)
			{
				$("#ti-noreg-page_details").val(JSON.stringify(place));
			}

			Trustindex_Connect.form.submit();
		});
	});

	// show loading text on refresh
	$('#trustindex-plugin-settings-page .btn-refresh').click(function(event) {
		let btn = jQuery(this);

		btn.css('pointer-events', 'none');
		btn.addClass('btn-default').removeClass('btn-primary');
		btn.blur();
		TI_manage_dots(btn);

		jQuery('#trustindex-plugin-settings-page .btn').css('pointer-events', 'none');
	});

	// make async request on review download
	$('.btn-download-reviews').on('click', function(event) {
		event.preventDefault();

		Trustindex_Connect.async_request(function(token, request_id, manual_download, place) {
			if(place)
			{
				$.ajax({
					type: "POST",
					data: { review_download_timestamp: place.timestamp }
				}).always(function(r) {
					location.reload();
				});
			}
			else
			{
				$.ajax({
					type: "POST",
					data: {
						review_download_request: token,
						review_download_request_id: request_id,
						manual_download: manual_download
					}
				}).always(function(r) {
					location.reload();
				});
			}
		});
	});

	// manual download
	$('#review-manual-download').on('click', function(event) {
		event.preventDefault();

		let btn = $(this);

		btn.blur().addClass('btn-disabled');

		TI_manage_dots(btn);

		$.ajax({
			url: location.search.replace(/&tab=[^&]+/, '&tab=setup_no_reg'),
			type: 'POST',
			data: { command: 'review-manual-download' },
			success: function() {
				location.reload();
			},
			error: function() {
				btn.restore();
				btn.addClass('show-tooltip');
			}
		});
	});

	/*************************************************************************/
	/* CONNECT TO TRUSTINDEX */
	var used_emails = [];
	$("#ti-reg-email, #ti-reg-password").blur(function() {
		let email = jQuery("#ti-reg-email").val();

		//if previously checked
		if (jQuery.inArray(email, used_emails) != -1)
		{
			jQuery("#txt-email-used").fadeIn();
			return false;
		}

		jQuery.ajax({
			method: "POST",
			url: "https://admin.trustindex.io/" + "api/userCheckEmail",
			data: { 'email': email, 's': 'wp' },
			dataType: "jsonp",
			success: function(data) {
				//invalid e-mail
				if (data == -1)
				{

				}
				//new e-mail
				else if (data == 0)
				{
					jQuery("#txt-email-used").fadeOut();
				}
				//used e-mail
				else
				{
					let link = jQuery("#txt-email-used").find("a");
					link.html(link.html().replace("$email", email));
					jQuery("#txt-email-used").fadeIn();
					jQuery("#ti-reg-email").val("");

					//register as used email
					used_emails.push(email);
				}
			}
		});
	});

	$("#form-reg").submit(function(e) {
		return !jQuery("#txt-email-used").is(":visible");
	});
});