(function() {
	tinymce.create('tinymce.plugins.trustindex', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url)
		{
			let jq_url = (typeof ajax_object != "undefined" ? ajax_object.ajax_url : window.ajaxurl || null);

			if(!jq_url)
			{
				return;
			}

			ed.addButton('trustindex', {
				title : 'Add Trustindex widget shortcode',
				cmd : 'add-trustindex-widget',
				image : url + '/../img/trustindex-sign-logo.png',
				text: ''
			});

			ed.addCommand('add-trustindex-widget', function() {

				jQuery.get(jq_url + '?action=list_trustindex_widgets', function( ajax_return_data ) {

					ed.windowManager.open( {
						title: 'Please add an Trustindex widget ID!',
						//html: "<p>hello!</p>",
						body: [
							{
			                    type   : 'container',
			                    name   : 'container',
			                    label  : '',
			                    html   : ajax_return_data
			                },
							{
								type: 'textbox',
								name: 'widget-id',
								placeholder: 'Trustindex widget ID',
								multiline: false,
								minWidth: 200,
								//minHeight: 50,
							}
						],
						onsubmit: function( e ) {
							var ti_widget_id = e.data['widget-id'];
							if (ti_widget_id.length < 10)
							{
								alert("Trustindex ID is missing or too short. Please check, mayba a copy-paste error!");
								return false;
							}
							else
							{
								ed.execCommand('mceInsertContent', 0, '[trustindex data-widget-id="' + ti_widget_id + '"]');
							}
						}
					});
				});

				//select Trustindex widget ID
				jQuery('body').on('click', '.btn-copy-widget-id', function(e){
					let selected_class = "text-danger";
					e.preventDefault();
					let link = jQuery(this);
					let id = link.data('ti-id');
					link.closest(".mce-form").find('input').val(id).trigger("change");

					//color
					link.closest(".mce-form").find('.btn-copy-widget-id.' + selected_class).each(function(i, item){
						jQuery(item).removeClass(selected_class)
							.find(".dashicons").attr("class", "dashicons dashicons-admin-post");
					});
					link.addClass(selected_class)
						.find(".dashicons").attr("class", "dashicons dashicons-yes");
				});
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm)
		{
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function()
		{
			return {
				longname : 'Trustindex Buttons',
				author : 'Trustindex.io - Velvel ltd[www.velvel.hu]',
				authorurl : 'https://www.trustindex.io/',
				infourl : 'https://www.trustindex.io/',
				version : "1.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add( 'trustindex', tinymce.plugins.trustindex );
})();