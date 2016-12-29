jQuery.noConflict();
jQuery(document).ready(function($){

	$('.tpath-radio-img-img').click(function(){
		$(this).parent().parent().find('.tpath-radio-img-img').removeClass('tpath-radio-img-selected');
		$(this).addClass('tpath-radio-img-selected');
	});
	
	$('.tpath-radio-img-label, .tpath-radio-img-radio').hide();
	$('.tpath-radio-img-img').show();
	
	$('.icon-tooltip').tooltip();	
	
	$('.tpath-meta-color').wpColorPicker();
	
	$('select.chosen-select').select2({placeholder: "Select Options", allowClear: true});
	var filters = new Array();
	$(".chosen-select").on("change", function(e) {
		if( filters.length === 0 ) {
			var filters_string = $(this).parent().find('.chosen-order').val();
			if( filters_string != '' ) {
				var filters_array = filters_string.split(',');				
				filters = new Array();	
				$.each(filters_array, function(i) {
					if( filters_array[i] != '' ) {						
						filters.push(filters_array[i]);	
					}
				});
			} else if( filters_string === null ) {
				filters = new Array();
			}			
			$(this).parent().find('.chosen-order').val('');			
		}
		
		if( e.val === null ) {
			$(this).parent().find('.chosen-order').val('');
			filters = new Array();
		}
				
		if( typeof e.added != "undefined" ) {
			var add_id = e.added.id;			
			filters.push(add_id);			
		}
		
		if( typeof e.removed != "undefined" ) {		
			var remove_id = e.removed.id;			
			var found = $.inArray(remove_id, filters);			
			if (found >= 0) {
				// Element was found, remove it.
				filters.splice(found, 1);
			}
		}
		
		$(this).parent().find('.chosen-order').val(filters);
		
	});
	
	$(".chosen-select").on("select2-removing", function(e) { 
		
		if( filters.length === 0 ) {
			var filters_string = $(this).parent().find('.chosen-order').val();
			if( filters_string != '' ) {
				var filters_array = filters_string.split(',');	
				filters = new Array();
				$.each(filters_array, function(i) {
					if( filters_array[i] != '' ) {						
						filters.push(filters_array[i]);						
					}
				});
			} else if( filters_string === null ) {
				filters = new Array();
			}
			$(this).parent().find('.chosen-order').val('');
		}
	});
	
	$(".chosen-select").on("select2-removed", function(e) {		
		
		var remove_id = e.choice.id;
		
		var found = $.inArray(remove_id, filters);		
		if (found >= 0) {
			// Element was found, remove it.
			filters.splice(found, 1);
		}
		$(this).parent().find('.chosen-order').val(filters);
	});
	
	/*function tpathcolor() {
		//Color picker
		$('.tpath-color').wpColorPicker();
	}
	tpathcolor();*/
	
	// Uploader
	// Only show remove button when needed
	$('.tpath-meta-upload').each(function() {
		if ( ! $(this).val() ) {
			$(this).parent('.field-upload').find('.tpath_meta_remove_button').hide();
		}
	});

	// Uploading files
	var file_frame, upload_btn;

	$(document).on( 'click', '.tpath_meta_upload_button', function( event ){

		event.preventDefault();
		
		upload_btn = $(this);

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}
		
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select image',
			button: {
				text: 'Upload image',
			},						
			multiple: false
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();
			
			upload_btn.parent('.field-upload').find('.tpath-meta-upload').val( attachment.url );
			upload_btn.parent('.field-upload').find('.tpath_meta_remove_button').show();
					
		});
		
		// Finally, open the modal.
		if( file_frame ) {
			file_frame.open();
		}
		
	});

	$(document).on( 'click', '.tpath_meta_remove_button', function( event ){	
		$(this).parent('.field-upload').find('.tpath-meta-upload').val('');
		$(this).parent('.field-upload').find('.tpath_meta_remove_button').hide();		
		return false;
	});
	
	// Range Slider	
	$('.tpath-rangeslider').each(function() {
		
		var obj   		= $(this);
		var slider_id   = "#" + obj.data('id');
		var val   		= obj.data('val');
		var min_val		= obj.data('min');
		var max_val		= obj.data('max');
		var step  		= obj.data('step');
		
		//slider init
		obj.slider({
			value: val,
			min: min_val,
			max: max_val,
			step: step,
			range: "min",
			slide: function( event, ui ) {
				$(slider_id).val( ui.value );
			}
		});
		
	});
	
	// Icon Selection
    $('.tpath-iconpicker i').live('click', function( event ) {
			
        event.preventDefault();		
		
		var fontName = $(this).attr('data-original-title');
		
		 if($(this).hasClass('selected')) {
            $(this).removeClass('selected');
			$(this).parent().parent().find('input').attr('value', '');
        } else {
            $('.tpath-iconpicker i').removeClass('selected');
            $(this).addClass('selected');
			$(this).parent().parent().find('input').attr('value', fontName);
        }
		
		return false;
		        
    });
	
	// assign jUI sortable
	$('.clone-pricing-column').sortable({
		placeholder: "sortable-column-placeholder",
		items: ".pricing-new-column",
		cancel: ":input, .description",
		cursor: 'move',
		revert: true
	});		
	
	initPickers = $('.clone-pricing-column').find('input:text.tpath-color');
	
	initColorPickers( initPickers );
	
	$('.tpath_pricing_clone_feature').live('click', function( event ) {
			event.stopImmediatePropagation();

			var row_template = $(event.target).closest('div.tpath_metabox_field').find('.tpath_metabox_field.repeatable').clone(true);

			row_template.addClass('cloned');
			var row_count = $(this).closest('div.tpath_metabox_field').find('.tpath_metabox_field.cloned').length + 1;
			
			//var column_count = $(this).closest('.pricing-new-column.cloned').find('#tpathpricing_tb['+column_count+'][column_id]').length;
			
			row_template.find('input, textarea').each(function() {
				$(this).attr('name', this.id.replace('%r', row_count));
				$(this).attr('id', this.id.replace('%r', row_count));
				$(this).attr('value', '');
				
				/*if( $(this).attr('id') == 'tpathpricing_tb[%c][features]['+row_count+']' ) {
					$(this).attr('name', this.id.replace('%c', column_count));
					$(this).attr('id', this.id.replace('%c', column_count));
				}	*/			
			});
			
			row_template.insertBefore($(this).closest('div.tpath_metabox_field').find('.tpath_metabox_field.repeatable'));
			row_template.removeClass('repeatable');
			//row_template.show();
			
			//$('.repeat-sortable').sortable('destroy');
			// Unbind all event handlers!
			//$('.repeat-sortable').unbind();
			
			//$('.repeat-sortable').sortable();	
			
			//$(".repeat-sortable").sortable({ connectWith: '.repeat-sortable' });
			
			return false;
	});
	
	$('.tpath-clone-remove').live('click', function( event ) {
			event.preventDefault();
			$(this).parent('.cloned').remove();
			
			return false;
	});
	
	//$('.pricing-new-column.repeatable').hide();
	
	$(document).on('click', '.tpath_pricing_clone_column', function( event ) {
			event.stopImmediatePropagation();

			var column_template = $(event.target).closest('div.clone-pricing-column').find('.pricing-new-column.repeatable').clone(true);

			column_template.addClass('cloned');
			var column_count = $(event.target).closest('div.clone-pricing-column').find('.pricing-new-column.cloned').length + 1;
			var old_column_count = column_count - 1;
			
			var repeat_div = $(event.target).closest('div.clone-pricing-column').find('.pricing-new-column.repeatable');
			
			//repeat_div.find('input, select, textarea').each(function() {
				//$(this).attr('name', this.id.replace('%c', column_count));
				//$(this).attr('id', this.id.replace('%c', column_count));
			//});
			
			column_template.find('input, select, textarea').each(function() {
				$(this).attr('name', this.id.replace('%c', column_count));
				$(this).attr('id', this.id.replace('%c', column_count));
				
				//$(this).attr('name', this.id.replace(old_column_count, column_count));
				//$(this).attr('id', this.id.replace(old_column_count, column_count));
				
				if( $(this).attr('id') != 'tpathpricing_tb['+column_count+'][features][%r]' ) {
					$(this).attr('name', this.id.replace('%r', column_count));
					$(this).attr('id', this.id.replace('%r', column_count));					
				}	
				
				if( $(this).hasClass( 'colorpicker' ) ) {
					$(this).removeClass('colorpicker');
					$(this).addClass('tpath-color');
				}
				
				/*if( $(this).attr('id') == 'tpathpricing_tb['+column_count+'][bg_color]' ) {
							
					//$.getScript($(this).data('url'));
					$.getScript( $(this).data('url') , function( data, textStatus, jqxhr ) {
						
					});
				
					alert('true');
				
				}*/
				
				//$(this).parent().parent().find('label').attr('for', this.id.replace('0', row_count)); 
			});
			
			$(this).closest('div.clone-pricing-column').find('#tpath_pricing_column_count').attr('value', column_count);
			column_template.insertBefore($(this).closest('div.clone-pricing-column').find('.pricing-new-column.repeatable'));
			column_template.removeClass('repeatable');
			
			column_template.show();
			
			//$('.tpath-color').wpColorPicker();
			
			initPickers = column_template.find('input:text.tpath-color');
			
			initColorPickers( initPickers );
			
			//$(".repeat-sortable").sortable( "refresh" );
			
			return false;
	});
	
	/*$('.wp-color-result').live('click', function( event ) {
		event.preventDefault();
			$(this).closest('span').find('input').css('display', 'block');
			$(this).closest('div').find('.iris-picker').css('display', 'block');
		return false;
	});
	*/
	$('.tpath-clone-column-remove').live('click', function( event ) {
			event.preventDefault();
			
			old_column_count = $(this).parent('.cloned').closest('div.clone-pricing-column').find('#tpath_pricing_column_count').attr('value');
			$(this).parent('.cloned').closest('div.clone-pricing-column').find('#tpath_pricing_column_count').attr('value', old_column_count - 1 );
			$(this).parent('.cloned').remove();
			
			return false;
	});
	
	function initColorPickers( selector ) {
		
		if ( ! selector.length ) {
			return;
		}
		if (typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function') {
						
			selector.wpColorPicker();

		} else {
			selector.each( function(i) {
				$(this).after('<div id="picker-' + i + '" style="z-index: 1000; background: #EEE; border: 1px solid #CCC; position: absolute; display: block;"></div>');
				$('#picker-' + i).hide().farbtastic($(this));
			})
			.focus( function() {
				$(this).next().show();
			})
			.blur( function() {
				$(this).next().hide();
			});
		}
				
	};
	
	$(document).on('click', '.tpath_portfolio_clone_section_add', function( event ) {
			event.stopImmediatePropagation();

			var column_template = $(event.target).closest('div.clone-portfolio-row').find('.portfolio-section.repeatable').clone(true);

			column_template.addClass('cloned');
			var column_count = $(this).closest('div.clone-portfolio-row').find('.portfolio-section.cloned').length + 1;
			var old_column_count = column_count - 1;
			
			column_template.find('input, select, textarea').each(function() {
				$(this).attr('name', this.id.replace('%r', column_count));
				$(this).attr('id', this.id.replace('%r', column_count));
				
				$(this).attr('name', this.id.replace(old_column_count, column_count));
				$(this).attr('id', this.id.replace(old_column_count, column_count));
			});
			
			$(this).closest('div.clone-portfolio-row').find('#tpath_portfolio_section_count').attr('value', column_count);
			column_template.insertBefore($(this).closest('div.clone-portfolio-row').find('.portfolio-section.repeatable')).fadeIn("slow");
			column_template.removeClass('repeatable');
			
			return false;
	});	
	
	$('.tpath_portfolio_clone_section_remove').live('click', function( event ) {
			event.preventDefault();
			
			old_column_count = $(this).parent('.cloned').closest('div.clone-portfolio-row').find('#tpath_portfolio_section_count').attr('value');
			$(this).parent('.cloned').closest('div.clone-portfolio-row').find('#tpath_portfolio_section_count').attr('value', old_column_count - 1 );
			$(this).parent('.cloned').remove();
			
			return false;
	});

});