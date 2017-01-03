<?php global $tpath_options; ?>
jQuery.noConflict();

<?php if( isset( $tpath_options['tpath_disable_blog_pagination'] ) && $tpath_options['tpath_disable_blog_pagination'] ) { ?>

jQuery(function($){
	$(window).load(function() {			
		var curPage = 1;
		var pagesNum = $('ul.pagination').find("a.page-numbers:not('.current, .next, .prev'):last").text();
	
		var $container = $('#archive-posts-container');
		$container.infinitescroll({
			loading: {
				msg: null,
				finishedMsg : '<span class="all-loaded">All Posts displayed</span>',
				img: '<?php echo TEMPLATETHEME_URL . "/images/ajax-loader.gif"; ?>',
				msgText: ""
			},
			navSelector  : 'ul.pagination',
			nextSelector : 'ul.pagination li a.next',
			itemSelector : 'article.post',
			errorCallback: function() {
				if($container.hasClass('grid-layout')) {
					$container.isotope('layout');
				}
			}
		}, function( newElements ) {
			var $newElems = $( newElements );
			
			curPage++;

			if(curPage == pagesNum) {
				$(window).unbind('.infscr');
			}
			
			$newElems.css({ opacity: 0 });
			$newElems.imagesLoaded(function() {
				$newElems.animate({ opacity: 1 }, 300, "linear");
				if($container.hasClass('grid-layout')) {
					$container.masonry('appended', $newElems);
				}
			});
			
			if(Modernizr.mq('only screen and (min-width: 1025px)')) {
				var gridwidth = ($('.grid-col-2').width() / 2) - 10;
				$('.grid-col-2 .grid-posts').css('width', gridwidth);
	
				var gridwidth = ($('.grid-col-3').width() / 3) - 15;
				$('.grid-col-3 .grid-posts').css('width', gridwidth);
	
				var gridwidth = ($('.grid-col-4').width() / 4) - 15;
				$('.grid-col-4 .grid-posts').css('width', gridwidth);
			}	
			
			if(Modernizr.mq('only screen and (max-width: 1024px) and (min-width: 768px)')) {
				if( $('body').hasClass( 'three-col-middle' ) || $('body').hasClass( 'three-col-right' ) || $('body').hasClass( 'three-col-left' ) ) {
					$('.three-col-middle .grid-col-2 .grid-posts, .three-col-right .grid-col-2 .grid-posts, .three-col-left .grid-col-2 .grid-posts, .three-col-middle .grid-col-3 .grid-posts, .three-col-right .grid-col-3 .grid-posts, .three-col-left .grid-col-3 .grid-posts, .three-col-middle .grid-col-4 .grid-posts, .three-col-right .grid-col-4 .grid-posts, .three-col-left .grid-col-4 .grid-posts').imagesLoaded( function() {
						$('.three-col-middle .grid-col-2 .grid-posts, .three-col-right .grid-col-2 .grid-posts, .three-col-left .grid-col-2 .grid-posts, .three-col-middle .grid-col-3 .grid-posts, .three-col-right .grid-col-3 .grid-posts, .three-col-left .grid-col-3 .grid-posts, .three-col-middle .grid-col-4 .grid-posts, .three-col-right .grid-col-4 .grid-posts, .three-col-left .grid-col-4 .grid-posts').css('width', '100%');
						$('.three-col-middle .grid-col-2, .three-col-right .grid-col-2, .three-col-left .grid-col-2, .three-col-middle .grid-col-3, .three-col-right .grid-col-3, .three-col-left .grid-col-3, .three-col-middle .grid-col-4, .three-col-right .grid-col-4, .three-col-left .grid-col-4').masonry({
							columnWidth: '.grid-posts',
							gutter: 0
						});
					});
				} else {
					var gridwidth = ($('.grid-col-2, .grid-col-3, .grid-col-4').width() / 2) - 15;
					$('.grid-col-2 .grid-posts, .grid-col-3 .grid-posts, .grid-col-4 .grid-posts').css('width', gridwidth);
				}
			}
			
			if(Modernizr.mq('only screen and (max-width: 767px)')) {
				$('.grid-col-2 .grid-posts, .grid-col-3 .grid-posts, .grid-col-4 .grid-posts').imagesLoaded( function() {
					$('.grid-col-2 .grid-posts, .grid-col-3 .grid-posts, .grid-col-4 .grid-posts').css('width', '100%');
					$('.grid-col-2, .grid-col-3, .grid-col-4').masonry({
						columnWidth: '.grid-posts',
						gutter: 0
					});
				});
			}			
			
			$newElems.find('audio,video').mediaelementplayer();
			
			$newElems.find("a[rel^='prettyPhoto'], a[data-rel^='prettyPhoto']").prettyPhoto({social_tools: false, deeplinking: false});
			
			$newElems.find('.posted-date .entry-date').each(function(){
				var post_date = $(this).text();
				var date_arr = post_date.split(/ +/);
				if(typeof date_arr !== 'undefined' && date_arr.length > 0) {
					$(this).html("");
					
					if( date_arr[0] !== undefined ) {
						$(this).append('<span class="date">' + date_arr[0] + '</span>');
					}
					
					if( date_arr[1] !== undefined ) {
						$(this).append('<span class="month">' + date_arr[1] + '</span>');
					}
					
					if( date_arr[2] !== undefined ) {
						$(this).append('<span class="year">' + date_arr[2] + '</span>');
					}
				}
			});
			
			$newElems.find('.owl-carousel.blog-carousel-slider').each( function() {
				initBlogSlider();
			});
			
			if($container.hasClass('grid-layout')) {
				$container.isotope('layout');
			}	
			
		});
	});
});
<?php } ?>

jQuery(window).load(function() {
	var curPage = 1;
	var pagesNum = jQuery('ul.pagination').find("a.page-numbers:not('.current, .next, .prev'):last").text();
	
	var $container = jQuery('#tpath-posts-infinite-container');
	$container.infinitescroll({
		loading: {
			msg: null,
			finishedMsg : '<span class="all-loaded">All Posts displayed</span>',
			img: '<?php echo TEMPLATETHEME_URL . "/images/ajax-loader.gif"; ?>',
			msgText: ""
		},		
		navSelector  : 'ul.pagination',
		nextSelector : 'ul.pagination li a.next',
		itemSelector : 'article.post',
		errorCallback: function() {
	    	if($container.hasClass('grid-layout')) {
	    		$container.isotope('layout');
	    	}
	    }
	}, function( posts ) {
	
		var $newPosts = jQuery( posts );
		
		curPage++;

		if(curPage == pagesNum) {
			jQuery(window).unbind('.infscr');
		}	
				
		$newPosts.css({ opacity: 0 });
		$newPosts.imagesLoaded(function() {
			$newPosts.animate({ opacity: 1 }, 300, "linear");
			if($container.hasClass('grid-layout')) {
				$container.masonry('appended', $newPosts);
			}
		});		
				
		if(Modernizr.mq('only screen and (min-width: 1025px)')) {
			var gridwidth = (jQuery('.grid-col-2').width() / 2) - 10;
			jQuery('.grid-col-2 .grid-posts').css('width', gridwidth);				

			var gridwidth = (jQuery('.grid-col-3').width() / 3) - 15;
			jQuery('.grid-col-3 .grid-posts').css('width', gridwidth);

			var gridwidth = (jQuery('.grid-col-4').width() / 4) - 15;
			jQuery('.grid-col-4 .grid-posts').css('width', gridwidth);
		}
		
		if(Modernizr.mq('only screen and (max-width: 1024px) and (min-width: 768px)')) {
			if( jQuery('body').hasClass( 'three-col-middle' ) || jQuery('body').hasClass( 'three-col-right' ) || jQuery('body').hasClass( 'three-col-left' ) ) {
				jQuery('.three-col-middle .grid-col-2 .grid-posts, .three-col-right .grid-col-2 .grid-posts, .three-col-left .grid-col-2 .grid-posts, .three-col-middle .grid-col-3 .grid-posts, .three-col-right .grid-col-3 .grid-posts, .three-col-left .grid-col-3 .grid-posts, .three-col-middle .grid-col-4 .grid-posts, .three-col-right .grid-col-4 .grid-posts, .three-col-left .grid-col-4 .grid-posts').imagesLoaded( function() {
					jQuery('.three-col-middle .grid-col-2 .grid-posts, .three-col-right .grid-col-2 .grid-posts, .three-col-left .grid-col-2 .grid-posts, .three-col-middle .grid-col-3 .grid-posts, .three-col-right .grid-col-3 .grid-posts, .three-col-left .grid-col-3 .grid-posts, .three-col-middle .grid-col-4 .grid-posts, .three-col-right .grid-col-4 .grid-posts, .three-col-left .grid-col-4 .grid-posts').css('width', '100%');
					$('.three-col-middle .grid-col-2, .three-col-right .grid-col-2, .three-col-left .grid-col-2, .three-col-middle .grid-col-3, .three-col-right .grid-col-3, .three-col-left .grid-col-3, .three-col-middle .grid-col-4, .three-col-right .grid-col-4, .three-col-left .grid-col-4').masonry({
						columnWidth: '.grid-posts',
						gutter: 0
					});
				});
			} else {
				var gridwidth = (jQuery('.grid-col-2, .grid-col-3, .grid-col-4').width() / 2) - 15;
				jQuery('.grid-col-2 .grid-posts, .grid-col-3 .grid-posts, .grid-col-4 .grid-posts').css('width', gridwidth);
			}
		}
		
		if(Modernizr.mq('only screen and (max-width: 767px)')) {
			jQuery('.grid-col-2 .grid-posts, .grid-col-3 .grid-posts, .grid-col-4 .grid-posts').imagesLoaded( function() {
				jQuery('.grid-col-2 .grid-posts, .grid-col-3 .grid-posts, .grid-col-4 .grid-posts').css('width', '100%');
				$('.grid-col-2, .grid-col-3, .grid-col-4').masonry({
					columnWidth: '.grid-posts',
					gutter: 0
				});
			});
		}		
		
		$newPosts.find('audio,video').mediaelementplayer();
		
		$newPosts.find("a[rel^='prettyPhoto'], a[data-rel^='prettyPhoto']").prettyPhoto({social_tools: false, deeplinking: false});
		
		$newPosts.find('.posted-date .entry-date').each(function(){
			var post_date = jQuery(this).text();
			var date_arr = post_date.split(/ +/);
			if(typeof date_arr !== 'undefined' && date_arr.length > 0) {
				jQuery(this).html("");
				
				if( date_arr[0] !== undefined ) {
					jQuery(this).append('<span class="date">' + date_arr[0] + '</span>');
				}
				
				if( date_arr[1] !== undefined ) {
					jQuery(this).append('<span class="month">' + date_arr[1] + '</span>');
				}
				
				if( date_arr[2] !== undefined ) {
					jQuery(this).append('<span class="year">' + date_arr[2] + '</span>');
				}
			}
		});
		
		$newPosts.find('.owl-carousel.blog-carousel-slider').each( function() {
			initBlogSlider();
		});
		
		if($container.hasClass('grid-layout')) {
			$container.isotope('layout');
		}
		
	});
});

<?php if( is_page_template( 'template-contact.php' ) && $tpath_options['tpath_show_google_map_contact'] && $tpath_options['tpath_gmap_address'] ) {
	$tpath_addresses = explode('|', $tpath_options['tpath_gmap_address']);
	$markers = '';
	$marker_img = '';
	if( $tpath_options['tpath_gmap_marker_icon'] ) {
		$marker_img = $tpath_options['tpath_gmap_marker_icon'];
	}
	else {
		$marker_img = TEMPLATETHEME_URL . '/images/map-marker.png';
	}
	
	$map_info = '';
	$map_info = $tpath_options['tpath_gmap_content'];
	
	if( isset( $map_info ) && $map_info == '' ) {
		$map_info = $addresses;
	}
	
	foreach($tpath_addresses as $addresses) {
		$markers .= '{address: "'.$addresses.'", data: "'.$map_info.'", options:{icon: "'.esc_url( $marker_img ).'"}},';
	}
	
	if( $tpath_options['tpath_gmap_popup'] ) {
		$events = 'click: function(marker, event, context){
							var map = $(this).gmap3("get"),
							infowindow = $(this).gmap3({get:{name:"infowindow"}});
							if (infowindow){
								infowindow.open(map, marker);
								infowindow.setContent(context.data);
							} else {
								$(this).gmap3({
									infowindow:{
										anchor:marker, 
										options:{content: context.data}
									}
								});
							}
							} ';
	} else {
		$events = 'mouseover: function(marker, event, context){
							var map = $(this).gmap3("get"),
							infowindow = $(this).gmap3({get:{name:"infowindow"}});
							if (infowindow){
							  infowindow.open(map, marker);
							  infowindow.setContent(context.data);
							} else {
								$(this).gmap3({
									infowindow:{
										anchor:marker, 
										options:{content: context.data}
									}
								});
							}
							},
							mouseout: function(){
							var infowindow = $(this).gmap3({get:{name:"infowindow"}});
								if (infowindow){
									infowindow.close();
								}
							} ';
	}
?>				
jQuery(function($){
	$('#tpath_gmap').gmap3({
		map:{
		  options:{
			styles: [ { "featureType": "landscape", "stylers": [ { "color": "#E2E2E2" } ] },{ "featureType": "road.highway", "stylers": [ { "color": "#B2B2B2" } ] },{ "featureType": "road.arterial", "stylers": [ { "color": "#FDFDFD" } ] },{ "featureType": "water", "stylers": [ { "color": "#D9D9D9" } ] },{ "elementType": "labels.text.fill", "stylers": [ { "color": "#d3cfcf" } ] },{ "featureType": "poi", "stylers": [ { "color": "#C8C8C8" } ] },{ "elementType": "labels.text", "stylers": [ { "color": "#000000" }, { "saturation": 1 }, { "weight": 0.1 } ] } ]
		  }
		},
		getlatlng:{
			address: "<?php echo esc_html( $tpath_addresses[0] ); ?>",
			callback: function(results){
				if ( !results ) return;
				$(this).gmap3({
					map:{
						options:{
							center: results[0].geometry.location,
							zoom: <?php echo esc_attr( $tpath_options['tpath_gmap_zoom_level'] ); ?>,
							mapTypeId: google.maps.MapTypeId.<?php echo esc_attr( $tpath_options['tpath_gmap_type'] ); ?>,
							scrollwheel: <?php if( $tpath_options['tpath_gmap_scrollwheel'] ) { ?>false<?php } else { ?>true<?php } ?>,
							scaleControl: <?php if( $tpath_options['tpath_gmap_scale'] ) { ?>false<?php } else { ?>true<?php } ?>,
							zoomControl: <?php if( $tpath_options['tpath_gmap_zoomcontrol'] ) {?>false<?php } else { ?>true<?php } ?>,
							panControl: <?php if( $tpath_options['tpath_gmap_zoomcontrol'] ) {?>false<?php } else { ?>true<?php } ?>,
						}
					},
					marker:{
						<?php echo 'values:[' . $markers .']'; ?>,
						<?php echo 'events:{' . $events . '}'; ?>
					},
				});
			}
		}
	});
});
<?php } 

if( $tpath_options['tpath_sticky_header'] != '' && $tpath_options['tpath_sticky_header'] == 1 ) { ?>
jQuery(window).load(function() {
	jQuery('body').addClass('header-sticky');
	var num = 50;
	jQuery(window).on('scroll', function () {
		if (jQuery(window).scrollTop() > num) {
			jQuery('.header-main-section').addClass('is-sticky');
		} else {
			jQuery('.header-main-section').removeClass('is-sticky');
		}
	});
});
<?php } ?>