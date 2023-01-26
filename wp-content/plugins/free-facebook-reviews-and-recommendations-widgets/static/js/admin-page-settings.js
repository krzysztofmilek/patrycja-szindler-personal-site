if(typeof Trustindex_JS_loaded == 'undefined')
{
	var Trustindex_JS_loaded = {};
}

Trustindex_JS_loaded.unique = true;

jQuery(document).ready(function($) {
	/*************************************************************************/
	/* NO REG MODE */
	//FB LOGIN
	$(".btn-connect-public").click(function(e){
		e.preventDefault();

		let button = $(this);

		let ti_window = window.open("https://admin.trustindex.io/" + "source/edit2?type=Facebook&referrer=public", "trustindex", "width=1000,height=1000,menubar=0");

		window.addEventListener('message', function(event) {
			// IMPORTANT: check the origin of the data!
			if (event.origin.startsWith('https://admin.trustindex.io/'.replace(/\/$/,''))) {
				// The data was sent from your site.
				let page = event.data;

				if (page.id)
				{
					$("#ti-noreg-page_details").val(JSON.stringify(page));
					ti_window.close();
					button.closest("form").submit();
				}
			} else {
				// The data was NOT sent from your site!
				return;
			}
		});

		$('#ti-connect-info').fadeIn();
		let timer = setInterval(function() {
			if(ti_window.closed) {
				$('#ti-connect-info').hide();

				clearInterval(timer);
			}
		}, 1000);

		return false;
	});

	/*************************************************************************/
	/* URL PART CUTTER */
	$("#trustindex-plugin-settings-page [data-cut-url-part]").change(function(e){
		obj = $(this);

		let url_parts = obj.val().split(obj.data("cut-url-part"));
		if (url_parts.length > 1)
		{
			url_parts.shift();
		}

		obj.val(url_parts);
	});

	/*************************************************************************/
	/* LOADING */
	$("#trustindex-plugin-settings-page [data-loading-text]").on('click', function(e) {

		let btn = $(this);
		let go_loading = true;

		//debounce
		if (btn.html().search(btn.data("loading-text")) == -1)
		{

			//if there is a invalid form
			if (btn.closest("form").length)
			{
				let form = btn.closest("form");
				form.find("input:visible, select").each(function(i, input){
					if (!input.checkValidity())
					{
						go_loading = false;
						return false;
					}
				})
			}

			if (go_loading)
			{
				TI_manage_dots(btn);
			}
		}
	});

	/*************************************************************************/
	/* AUTOCLICK */
	if($("#trustindex-plugin-settings-page [data-autoclick]").length)
	{
		setTimeout(function(){ $("#trustindex-plugin-settings-page [data-autoclick]")[0].click(); }, 3000);
	}

	/*************************************************************************/
	/* ZOOM PICTURE */
	$(".zoomable-pic").click(function(e){
		e.preventDefault();

		let img = $(this);
		if (img.attr("style"))
		{
			img.removeAttr("style");
		}
		else
		{
			img.css("max-width", "inherit");
		}
	});
});