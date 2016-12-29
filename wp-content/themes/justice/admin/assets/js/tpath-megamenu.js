/*
 * Tpath Megamenu Framework
 * 
 */

( function( $ ) {

	"use strict";
	
	var tpath_megamenu = {

		menu_item_move: function() {
			$(document).on( 'mouseup', '.menu-item-bar', function( event, ui ) {
				if( ! $(event.target).is('a') ) {
					setTimeout( tpath_megamenu.update_megamenu_fields, 200 );
				}
			});
		},

		update_megamenu_status: function() {

			$(document).on( 'click', '.edit-menu-item-tpath-megamenu-status', function() {
				var parent_menu_item = $( this ).parents( '.menu-item:eq(0)' );

				if( $( this ).is( ':checked' ) ) {
					parent_menu_item.addClass( 'tpath-megamenu-active' );
				} else 	{
					parent_menu_item.removeClass( 'tpath-megamenu-active' );
				}

				tpath_megamenu.update_megamenu_fields();
			});
		},

		update_megamenu_fields: function() {
			var menu_items = $( '.menu-item');

			menu_items.each( function( i ) 	{

				var tpath_megamenu_status = $( '.edit-menu-item-tpath-megamenu-status', this );

				if( ! $(this).is( '.menu-item-depth-0' ) ) {
					var check_against = menu_items.filter( ':eq('+(i-1)+')' );

					if( check_against.is( '.tpath-megamenu-active' ) ) {

						tpath_megamenu_status.attr( 'checked', 'checked' );
						$(this).addClass( 'tpath-megamenu-active' );
					} else {
						tpath_megamenu_status.attr( 'checked', '' );
						$(this).removeClass( 'tpath-megamenu-active' );
					}
				} else {
					if( tpath_megamenu_status.attr( 'checked' ) ) {
						$(this).addClass( 'tpath-megamenu-active' );
					}
				}
			});
		}

	};
	
	$(document).ready(function(){
	
		tpath_megamenu.menu_item_move();
		tpath_megamenu.update_megamenu_status();
		tpath_megamenu.update_megamenu_fields();
		
	});
	
})( jQuery );