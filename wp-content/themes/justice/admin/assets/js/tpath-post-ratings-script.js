/*
 ### Post Ratings Plugin v1.0 ###
*/
jQuery(document).ready(function( $ ){
	
	//Init vars
	var ajaxRequestUrl 		= TpathPostRatingsVars.ajaxUrl;
	var nonceValue			= TpathPostRatingsVars.ajaxNonce;
	var rateUpdateAction	= TpathPostRatingsVars.rateUpdateAction;
	var pluginConfigOptions	= TpathPostRatingsVars.pluginConfigOptions;
	var ajaxUpdateErrorText	= TpathPostRatingsVars.ajaxRateUpdateErrorText;
	
	//Init rateit plugin for each rating group setup in plugin config options
	$.each( pluginConfigOptions, function( key, options ){
		
		var ratingGroupUniqueID = '';
			
		//Cache meta key as group id
		ratingGroupUniqueID = options.meta_key.toLowerCase();
		
		//Init plugin for this rating group
		$('.tpath-post-ratings-rateit.' + ratingGroupUniqueID).rateit(
			{ 
				max: 	options.max_rating_size, 
				min: 	options.min_rating_size,
				step: 	options.rating_step_size
			}
		);
		
	});
	
	//Bind our ajax request to the rated/reset event for all rating groups
	$('.tpath-post-ratings-rateit').bind('rated reset', function (e) {

		var ri = $(this);
		
		//Cache rate item vars
		var value 			= ri.rateit('value');
		var itemID 			= ri.data('itemid'); 
		var ratingGroupID	= ri.data('ratinggroupid');
		var disableRating	= ri.data('disablerating');
		
		//maybe we want to disable voting?
		if( disableRating ) {
			ri.rateit('readonly', true);
		}
		
		//Make ajax request to update item rating
		$.ajax({
			url: ajaxRequestUrl,
			data: { 
				action: rateUpdateAction,
				tpathPostRateNonce: nonceValue,
				itemID: itemID, 
				rateValue: value,
				ratingGroup: ratingGroupID
			},
			type: 'POST',
			success: function (data) {
				//Make sure that all rating elements for this post are updated - may be more than one :)
				$('.tpath-post-ratings-rateit.'+itemID+'.'+ratingGroupID).rateit( 'value', value );
			},
			error: function (jxhr, msg, err) {
				alert( ajaxUpdateErrorText );
			}
		});
		
	});
	
});