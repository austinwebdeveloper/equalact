<?php

// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path = TEMPLATE_TINYMCE_DIR . '/css/font-awesome.css';
if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	$icons['fa ' . $match[1]] = $match[1];
}

// Simple icons list
$simpleicons = '/\.(icon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$simplelineicons_path = TEMPLATE_TINYMCE_DIR . '/css/simple-line-icons.css';
if( file_exists( $simplelineicons_path ) ) {
	@$licon_subject = file_get_contents($simplelineicons_path);
}

preg_match_all($simpleicons, $licon_subject, $licon_matches, PREG_SET_ORDER);

$line_icons = array();

foreach($licon_matches as $licon_match){
	$line_icons[$licon_match[1]] = $licon_match[2];
}

$list_icons = array ( 'fa fa-th-list' => 'fa-th-list', 'fa fa-check' => 'fa-check', 'fa fa-times' => 'fa-times', 'fa fa-tag' => 'fa-tag', 'fa fa-tags' => 'fa-tags', 'fa fa-list' => 'fa-list', 'fa fa-pencil' => 'fa-pencil', 'fa fa-check-square-o' => 'fa-check-square-o', 'fa fa-plus' => 'fa-plus', 'fa fa-minus' => 'fa-minus', 'fa fa-hand-o-right' => 'fa-hand-o-right', 'fa fa-hand-o-up' => 'fa-hand-o-up', 'fa fa-hand-o-down' => 'fa-hand-o-down', 'fa fa-list-ul' => 'fa-list-ul', 'fa fa-circle-o' => 'fa-circle-o', 'fa fa-angle-double-right' => 'fa-angle-double-right', 'flaticon flaticon-check70' => 'flaticon-check70' );

$animations = array ( 'none' => 'None', 'bounce' => 'Bounce', 'flash' => 'Flash', 'pulse' => 'Pulse', 'rubberBand' => 'Rubber Band', 'shake' => 'Shake', 'swing' => 'Swing', 'tada' => 'Tada', 'wobble' => 'Wobble', 'bounceIn' => 'Bounce In', 'bounceInDown' => 'Bounce In Down', 'bounceInLeft' => 'Bounce In Left', 'bounceInRight' => 'Bounce In Right', 'bounceInUp' => 'Bounce In Up', 'bounceOut' => 'Bounce Out', 'bounceOutDown' => 'Bounce Out Down', 'bounceOutLeft' => 'Bounce Out Left', 'bounceOutRight' => 'Bounce Out Right', 'bounceOutUp' => 'Bounce Out Up', 'fadeIn' => 'Fade In', 'fadeInDown' => 'Fade In Down', 'fadeInDownBig' => 'Fade In Down Big', 'fadeInLeft' => 'Fade In Left', 'fadeInLeftBig' => 'Fade In Left Big', 'fadeInRight' => 'Fade In Right', 'fadeInRightBig' => 'Fade In Right Big', 'fadeInUp' => 'Fade In Up', 'fadeInUpBig' => 'Fade In Up Big', 'fadeOut' => 'Fade Out', 'fadeOutDown' => 'Fade Out Down', 'fadeOutDownBig' => 'Fade Out Down Big', 'fadeOutLeft' => 'Fade Out Left', 'fadeOutLeftBig' => 'Fade Out Left Big', 'fadeOutRight' => 'Fade Out Right', 'fadeOutRightBig' => 'Fade Out Right Big', 'fadeOutUp' => 'Fade Out Up', 'fadeOutUpBig' => 'Fade Out Up Big', 'flip' => 'Flip', 'flipInX' => 'Flip In X', 'flipInY' => 'Flip In Y', 'flipOutX' => 'Flip Out X', 'flipOutY' => 'Flip Out Y', 'lightSpeedIn' => 'Light Speed In', 'rotateIn' => 'Rotate In', 'rotateInDownLeft' => 'Rotate In Down Left', 'rotateInDownRight' => 'Rotate In Down Right', 'rotateInUpLeft' => 'Rotate In Up Left', 'rotateInUpRight' => 'Rotate In Up Right', 'rotateOut' => 'Rotate Out', 'rotateOutDownLeft' => 'Rotate Out Down Left', 'rotateOutDownRight' => 'Rotate Out Down Right', 'rotateOutUpLeft' => 'Rotate Out Up Left', 'rotateOutUpRight' => 'Rotate Out Up Right', 'hinge' => 'Hinge', 'rollIn' => 'Roll In', 'rollOut' => 'Roll Out', 'zoomIn' => 'Zoom In', 'zoomInDown' => 'Zoom In Down', 'zoomInLeft' => 'Zoom In Left', 'zoomInRight' => 'Zoom In Right', 'zoomInUp' => 'Zoom In Up', 'zoomOut' => 'Zoom Out', 'zoomOutDown' => 'Zoom Out Down', 'zoomOutLeft' => 'Zoom Out Left', 'zoomOutRight' => 'Zoom Out Right', 'zoomOutUp' => 'Zoom Out Up' );

$image_url = TEMPLATE_TINYMCE_URI . '/images/';

// Get Taxonomy Term List
function tpath_taxonomy_term_list($taxonomy, $post_type, $msg) {
			
	$list_groups = get_categories('taxonomy='.$taxonomy.'&post_type='.$post_type.'');
		$groups_list[0] = $msg;
		if( !empty($list_groups) ) {
			foreach ($list_groups as $groups) {
				$group_name = $groups->name;
				$termid = $groups->term_id;		
				$groups_list[$termid] = $group_name;
			}
		}
	
		if( isset($groups_list) ) {
			return $groups_list;
		}
	
}

// Pages Lists
function tpath_pages_lists() {
	
	$args = array(
		'post_type' 		=> 'page',
		'post_status' 		=> 'publish',
		'hierarchical' 		=> 1,		
		'sort_order' 		=> 'ASC',
		'sort_column' 		=> 'post_title',
	  );
		
	$pages = get_pages($args);
	
	$pages_list[0] = "Select";
	
	if( !empty($pages) ) {
		foreach ($pages as $page) {
			$page_name = $page->post_title;
			$page_id = $page->ID;		
			$pages_list[$page_id] = $page_name;
		}
	}

	if(isset($pages_list)) {
		return $pages_list;
	}	
}

/* =============================================================
 *  Shortcode Selection Config
 * ============================================================= */

$tpath_shortcodes['tpath-sc-generator'] = array(
	'no_preview' 	=> true,
	'params' 		=> array(),
	'shortcode' 	=> '',
	'popup_title' 	=> ''
);

/* =============================================================
 *	Alert Config
 * ============================================================= */

$tpath_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(			
			'type' 		=> 'select',
			'label' 	=> __('Alert Type', 'TemplateCore'),
			'desc' 		=> __('Select alert type', 'TemplateCore'),
			'options'	=> array(				
				'success' 	=> 'Success',
				'info' 		=> 'Info',
				'warning'	=> 'Warning',
				'danger' 	=> 'Danger'
			)
		),
		'content' => array(
			'std' 	=> 'Your Alert Content!',
			'type' 	=> 'textarea',
			'label' => __('Alert Content', 'TemplateCore'),
			'desc' 	=> __('Add the alert\'s content', 'TemplateCore'),
		),
		'dismissable' => array(			
			'type' 	=> 'select',
			'label' => __('Alert Dismissable', 'TemplateCore'),
			'desc'	=> __('Select to show close button in alert.', 'TemplateCore'),
			'options'	=> array(				
				'yes' 	=> 'Yes',
				'no' 	=> 'No'
			)
		),
		'animation_type' => array(			
			'type' 		=> 'select',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),
	'shortcode' 	=> '[tpath_alert type="{{type}}" close="{{dismissable}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]{{content}}[/tpath_alert]',
	'popup_title' 	=> __('Alert Shortcode', 'TemplateCore')
);

/* =============================================================
 *	Button Config
 * ============================================================= */

$tpath_shortcodes['button'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'url'	=> array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Button URL', 'TemplateCore'),
			'desc' 	=> __('Add the button\'s url. Ex: http://example.com', 'TemplateCore')
		),
		'style'	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Button Style', 'TemplateCore'),
			'desc' 		=> __('Select the button\'s color', 'TemplateCore'),
			'options' 	=> array(
				'default'		=> 'Default',
				'inverse' 		=> 'Black',
				'primary' 		=> 'Blue',
				'custom' 		=> 'Custom',
				'border' 		=> 'Border',
				'transparent' 	=> 'Transparent',
				'info' 			=> 'Light Blue',
				'success' 		=> 'Green',
				'warning' 		=> 'Orange',
				'danger' 		=> 'Red',
			)
		),
		'size' => array(
			'type' 		=> 'select',
			'label' 	=> __('Button Size', 'TemplateCore'),
			'desc' 		=> __('Select the button\'s size', 'TemplateCore'),
			'options' 	=> array(
				'default' 	=> 'Default',				
				'mini'		=> 'Extra Small',
				'small'		=> 'Small',
				'large' 	=> 'Large'
			)
		),
		'target' => array(
			'type' 		=> 'select',
			'label' 	=> __('Button Target', 'TemplateCore'),
			'desc' 		=> __('_self = open in same window. <br /> _blank = open in new window', 'TemplateCore'),
			'options' 	=> array(
				'_self' 	=> '_self',
				'_blank' 	=> '_blank'
			)
		),
		'content' => array(
			'std' 	=> 'Button Text',
			'type' 	=> 'text',
			'label' => __('Button\'s Text', 'TemplateCore'),
			'desc' 	=> __('Add the button\'s text', 'TemplateCore'),
		),
		'bg_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Background Color', 'TemplateCore'),
			'desc' 	=> __('Button Background Color. It only works if choosed "Custom" style for button.', 'TemplateCore'),
		),
		'bg_hover_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Background Hover Color', 'TemplateCore'),
			'desc' 	=> __('Button Background Hover Color. It only works if choosed "Custom" style for button.', 'TemplateCore'),
		),
		'textcolor' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Text Color', 'TemplateCore'),
			'desc' 	=> __('Button Text Color. Leave blank for default.', 'TemplateCore'),
		),
		'texthovercolor' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Text Hover Color', 'TemplateCore'),
			'desc' 	=> __('Button Text Hover Color. Leave blank for default.', 'TemplateCore'),
		),
		'border_width' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Border Width', 'TemplateCore'),
			'desc' 	=> __('Enter border width for button. Ex: 2 or 3.', 'TemplateCore'),
		),
		'border_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Border Color', 'TemplateCore'),
			'desc' 	=> __('Button Border Color. Leave blank for default.', 'TemplateCore'),
		),
		'border_hover_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Border Hover Color', 'TemplateCore'),
			'desc' 	=> __('Button Border Hover Color. Leave blank for default.', 'TemplateCore'),
		),
		'icon' => array(
			'type' 		=> 'iconpicker',
			'label' 	=> __('Select Icon', 'TemplateCore'),
			'desc' 		=> __('Click an icon to select, click again to deselect', 'TemplateCore'),
			'options' 	=> $icons			
		),
		'icon_position' => array(
			'type' 		=> 'select',
			'label' 	=> __('Icon Position', 'TemplateCore'),
			'desc' 		=> __('Select the position of the icon', 'TemplateCore'),
			'options' 	=> array(
				'left' 		=> 'Left',
				'right' 	=> 'Right',				
			)
		),
		'extra_class' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Button Extra Class', 'TemplateCore'),
			'desc' 	=> __('Add the button extra class.', 'TemplateCore'),
		),
		'animation_type' => array(			
			'type' 		=> 'select',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),
	'shortcode' 	=> '[tpath_button url="{{url}}" style="{{style}}" size="{{size}}" color="{{textcolor}}" hover_color="{{texthovercolor}}" bg_color="{{bg_color}}" bg_hover_color="{{bg_hover_color}}" border_width="{{border_width}}" border_color="{{border_color}}" border_hover_color="{{border_hover_color}}" icon="{{icon}}" icon_pos="{{icon_position}}" extra_class="{{extra_class}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}" target="{{target}}"]{{content}}[/tpath_button]',
	'popup_title' 	=> __('Button Shortcode', 'TemplateCore')
);

/* =============================================================
 *	Columns Config
 * ============================================================= */
 
$tpath_shortcodes['columns'] = array(		
	'no_preview' 	=> true,
	'params' 		=> array(	
		'container' => array(
			'type' 	=> 'select',
			'label' => __('Container', 'TemplateCore'),
			'desc' 	=> __('Choose to append container div to the columns.', 'TemplateCore'),
			'options'	=> array(
				'no'	=> 'No',
				'yes'	=> 'Yes'						
			)
		),
		'container_class'  => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Container Extra Class', 'TemplateCore'),
			'desc' 	=> __('Enter extra class for container.', 'TemplateCore')
		),
	),
	'child_shortcode' => array(
		'params' 	=> array(
			'column' => array(
				'type' 		=> 'select',
				'label' 	=> __('Column Size', 'TemplateCore'),
				'desc' 		=> __('Select the width of the column.', 'TemplateCore'),
				'options' 	=> array(
					'1' 	=> 'Size 1 (8.33%)',
					'2' 	=> 'Size 2 (16.67%)',
					'3' 	=> 'Size 3 (25%)',
					'4' 	=> 'Size 4 (33.33%)',
					'5' 	=> 'Size 5 (41.67%)',
					'6' 	=> 'Size 6 (50%)',
					'7' 	=> 'Size 7 (58.33%)',
					'8' 	=> 'Size 8 (66.67%)',
					'9' 	=> 'Size 9 (75%)',
					'10' 	=> 'Size 10 (83.33%)',
					'11' 	=> 'Size 11 (91.67%)',
					'12' 	=> 'Size 12 (100%)'
				)
			),
			'content' => array(
				'std' 	=> 'Your Content !',
				'type' 	=> 'textarea',
				'label' => __('Column Content', 'TemplateCore'),
				'desc' 	=> __('Add the column content.', 'TemplateCore'),
			),
			'column_class'  => array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Column Extra Class', 'TemplateCore'),
				'desc' 	=> __('Enter extra class for column.', 'TemplateCore')
			),
			'animation_type' => array(			
				'type' 		=> 'select',
				'label' 	=> __('Animation Type', 'TemplateCore'),
				'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
				'options'	=> $animations
			),
			'animation_delay' => array(
				'std' 		=> '500',
				'type' 		=> 'text',
				'label' 	=> __('Animation Delay', 'TemplateCore'),
				'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
			),
		),
		'shortcode' 	=> '[tpath_column size="{{column}}" column_class="{{column_class}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]{{content}}[/tpath_column]',
		'clone_button' 	=> __('Add New Column', 'TemplateCore')
	),
	'shortcode' 	=> '[tpath_columns container="{{container}}" container_class="{{container_class}}"]{{child_shortcode}}[/tpath_columns]',
	'popup_title' 	=> __('Columns Shortcode', 'TemplateCore'),
);

/* =============================================================
 *	Client Slider Config
 * ============================================================= */
 
$tpath_shortcodes['client_slider'] = array(
	'params' 		=> array(),	
	'no_preview' 	=> true,		
	'child_shortcode' => array(
		'params' 	=> array(
			'url'	=> array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Client Link', 'TemplateCore'),
				'desc' 	=> __('Add the client\'s website url. Ex: http://example.com', 'TemplateCore')
			),
			'target' => array(
				'type' 		=> 'select',
				'label' 	=> __('Link Target', 'TemplateCore'),
				'desc' 		=> __('_self = open in same window. <br /> _blank = open in new window', 'TemplateCore'),
				'options' 	=> array(
					'_self' 	=> '_self',
					'_blank' 	=> '_blank'
				)
			),
			'image' => array(
				'type' 	=> 'media',
				'label' => __('Upload Image', 'TemplateCore'),
				'desc' 	=> __('Upload the client image.', 'TemplateCore')
			),
			'alt' => array(
				'std' 	=> 'Image',
				'type' 	=> 'text',
				'label' => __('Image Alt Text', 'TemplateCore'),
				'desc' 	=> __('If an image cannot be viewed the alt attribute text will be shown', 'TemplateCore')
			)			
		),
		'shortcode' 	=> '[tpath_client link="{{url}}" target="{{target}}" image="{{image}}" alt="{{alt}}"]',
		'clone_button' 	=> __('Add New Client', 'TemplateCore')
	),
	'shortcode' 	=> '[tpath_client_slider]{{child_shortcode}}[/tpath_client_slider]',
	'popup_title' 	=> __('Client Slider Shortcode', 'TemplateCore'),
);

/* =============================================================
 *	Dropcap Config
 * ============================================================= */

$tpath_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'content' => array(
			'std' 	=> 'Z',
			'type' 	=> 'textarea',
			'label' => __( 'Dropcap Letter', 'TemplateCore' ),
			'desc' 	=> __( 'Enter the letter to be used as dropcap', 'TemplateCore' ),
		),
		'textcolor' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Dropcap Color', 'TemplateCore'),
			'desc' 	=> __('Dropcap Color. Leave blank for default.', 'TemplateCore' ),
		),
	),
	'shortcode' 	=> '[tpath_dropcap color="{{textcolor}}"]{{content}}[/tpath_dropcap]',
	'popup_title' 	=> __( 'Dropcap Shortcode', 'TemplateCore' )
);


/* =============================================================
 *	Highlight Config
 * ============================================================= */

$tpath_shortcodes['highlight'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'bg_color' => array(
			'type' 	=> 'colorpicker',
			'label' => __('Highlight Background Color', 'TemplateCore'),
			'desc' 	=> __('Choose a highlight background color', 'TemplateCore')
		),
		'color'  => array(
			'type' 	=> 'colorpicker',
			'label' => __('Highlight Text Color', 'TemplateCore'),
			'desc' 	=> __('Choose a highlight text color', 'TemplateCore')
		),
		'content' => array(
			'std' 	=> 'Your Content !',
			'type' 	=> 'textarea',
			'label' => __( 'Content to Hightlight', 'TemplateCore' ),
			'desc' 	=> __( 'Enter the content to be highlighted', 'TemplateCore' ),
		)

	),
	'shortcode' 	=> '[tpath_highlight color="{{color}}" bg_color="{{bg_color}}"]{{content}}[/tpath_highlight]',
	'popup_title' 	=> __( 'Highlight Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	List Item Config
 * ============================================================= */

$tpath_shortcodes['listitem'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'icon' 	=> array(
			'type' 		=> 'iconpicker',
			'label' 	=> __('Select Icon', 'TemplateCore'),
			'desc' 		=> __('Click an icon to select, click again to deselect', 'TemplateCore'),
			'options' 	=> $list_icons
		),
		'iconcolor' => array(
			'type' 	=> 'colorpicker',
			'label' => __('Icon Color', 'TemplateCore'),
			'desc' 	=> __('Leave blank for default', 'TemplateCore')
		),
		'iconbgcolor' => array(
			'type' 	=> 'colorpicker',
			'label' => __('Icon Background Color', 'TemplateCore'),
			'desc' 	=> __('Leave blank for default color', 'TemplateCore')
		),
		'icontype' => array(
			'type' 	=> 'select',
			'label' => __('Icon Type', 'TemplateCore'),
			'desc' 	=> __('Choose to display of icon', 'TemplateCore'),
			'options'	=> array(
				'none'		=> 'None',
				'circle'	=> 'Circle',
				'square' 	=> 'Square'
			)
		),
		'listinline' => array(
			'type' 	=> 'select',
			'label' => __('Inline List Type', 'TemplateCore'),
			'desc' 	=> __('Choose to display of list items inline', 'TemplateCore'),
			'options'	=> array(
				'yes'	=> 'Yes',
				'no'	=> 'No'				
			)
		),
		'animation_type' => array(			
			'type' 		=> 'select',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),
		
	'child_shortcode' => array(
		'params' 	=> array(
			'content' 	=> array(
				'std' 	=> 'Your Content',
				'type' 	=> 'textarea',
				'label' => __( 'List Item Content', 'TemplateCore' ),
				'desc' 	=> __( 'Enter list item content', 'TemplateCore' ),
			),
		),
		'shortcode' 	=> '&lt;li&gt;{{content}}&lt;/li&gt;',
		'clone_button' 	=> __('Add New List Item', 'TemplateCore')
	),
	'shortcode' 	=> '[tpath_listitem icon="{{icon}}" iconcolor="{{iconcolor}}" iconbgcolor="{{iconbgcolor}}" icontype="{{icontype}}" listinline="{{listinline}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]&lt;ul&gt;{{child_shortcode}}&lt;/ul&gt;[/tpath_listitem]',
	'popup_title' 	=> __('List Item Shortcode', 'TemplateCore'),
);

/* =============================================================
 *	Fontawesome Config
 * ============================================================= */

$tpath_shortcodes['fontawesome'] = array(
	'no_preview' => true,
	'params'	 => array(
		'icon' 		=> array(
			'type' 		=> 'iconpicker',
			'label' 	=> __('Select Icon', 'TemplateCore'),
			'desc' 		=> __('Click an icon to select, click again to deselect', 'TemplateCore'),
			'options' 	=> $icons
		),
		'icontype' => array(
			'type' 		=> 'select',
			'label' 	=> __('Icon Type', 'TemplateCore'),
			'desc' 		=> __('Choose to display of icon. If "none" background and border icon wont displayed.', 'TemplateCore'),
			'options'	=> array(
				'none'		=> 'None',
				'circle'	=> 'Circle',
				'square' 	=> 'Square'
			)
		),
		'size' => array(
			'type' 		=> 'select',
			'label' 	=> __('Icon Size', 'TemplateCore'),
			'desc' 		=> __('Select the size of the icon', 'TemplateCore'),
			'options' 	=> array(
				'small' 	=> 'Small',				
				'medium' 	=> 'Medium',
				'large' 	=> 'Large'				
			)
		),
		'iconcolor' => array(
			'type' 	=> 'colorpicker',
			'label' => __('Icon Color', 'TemplateCore'),
			'desc' 	=> __('Leave blank for default color', 'TemplateCore')
		),
		'iconbgcolor' => array(
			'type' 	=> 'colorpicker',
			'label' => __('Icon Background Color', 'TemplateCore'),
			'desc' 	=> __('Leave blank for default color', 'TemplateCore')
		),
		'bordercolor' => array(
			'type' 	=> 'colorpicker',
			'label' => __('Icon Border Color', 'TemplateCore'),
			'desc' 	=> __('Leave blank for default color', 'TemplateCore')
		),
		'border_width' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Border Width', 'TemplateCore'),
			'desc' 	=> __('Enter border width for icon. Ex: 2 or 3.', 'TemplateCore'),
		),
		'animation_type' => array(			
			'type' 		=> 'select',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),
	'shortcode' 	=> '[tpath_fontawesome icon="{{icon}}" icontype="{{icontype}}" size="{{size}}" iconcolor="{{iconcolor}}" iconbgcolor="{{iconbgcolor}}" bordercolor="{{bordercolor}}" borderwidth="{{border_width}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]',
	'popup_title' 	=> __( 'Font Awesome Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Google Map Config
 * ============================================================= */

$tpath_shortcodes['googlemap'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'type' 	 => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Map Type', 'TemplateCore'),
			'desc' 		=> __('Select the type of google map', 'TemplateCore'),
			'options' 	=> array(
				'roadmap' 	=> 'Roadmap',
				'satellite' => 'Satellite',
				'hybrid' 	=> 'Hybrid',
				'terrain' 	=> 'Terrain'
			)
		),
		'width' => array(
			'std' 	=> '100%',
			'type' 	=> 'text',
			'label' => __('Map Width', 'TemplateCore'),
			'desc' 	=> __('Map Width in Percentage or Pixels. Ex: 300px or 100%', 'TemplateCore')
		),
		'height' => array(
			'std' 	=> '350px',
			'type' 	=> 'text',
			'label' => __('Map Height', 'TemplateCore'),
			'desc' 	=> __('Map Height in Pixels. Ex: 350px', 'TemplateCore')
		),
		'zoom' => array(
			'std' 		=> 5,
			'type' 		=> 'text',
			'label' 	=> __('Zoom Level', 'TemplateCore'),
			'desc' 		=> __('Higher number will be more zoomed in.', 'TemplateCore')		
		),
		'onclick' => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Show Map Address on Click', 'TemplateCore'),
			'desc' 		=> 'Display map address tooltip by clicking marker in the map',
			'options' 	=> array(
				'yes' 	=> 'Yes',
				'no' 	=> 'No'				
			)
		),
		'scrollwheel' => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Enable Map Scrollwheel', 'TemplateCore'),
			'desc' 		=> __('Enable zooming using a mouse\'s scroll wheel', 'TemplateCore'),
			'options' 	=> array(
				'yes' 	=> 'Yes',
				'no' 	=> 'No'				
			)
		),
		'scale' => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Show Map Scale Control', 'TemplateCore'),
			'desc' 		=> __('Display the map scale', 'TemplateCore'),
			'options' 	=> array(
				'yes' 	=> 'Yes',
				'no' 	=> 'No'				
			)
		),
		'zoom_pancontrol' => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Show Pan Control', 'TemplateCore'),
			'desc' 		=> __('Displays pan control on Map', 'TemplateCore'),
			'options' 	=> array(
				'yes' 	=> 'Yes',
				'no' 	=> 'No'				
			)
		),
		'marker_image' => array(
			'type' 	=> 'media',
			'std'		=> '',
			'label' => __('Marker Image', 'TemplateCore'),
			'desc' 	=> __('Upload an marker image to display marker on your locations', 'TemplateCore')
		),	
		'content' => array(
			'std' 	=> 'Address',
			'type' 	=> 'textarea',
			'label' => __( 'Address', 'TemplateCore' ),
			'desc' 	=> __( 'Add address to show marker on map. To show multiple marker locations on map, to separate addresses by using | symbol. <br />Ex: Address 1|Address 2', 'TemplateCore' ),
		),
		'map_info' => array(
			'std' 	=> '',
			'type' 	=> 'textarea',
			'label' => __( 'Map Info Content', 'TemplateCore' ),
			'desc' 	=> __( 'Add content to show in infowindow.', 'TemplateCore' ),
		)
	),
	'shortcode' 	=> '[tpath_map address="{{content}}" type="{{type}}" width="{{width}}" height="{{height}}" zoom="{{zoom}}" onclick="{{onclick}}" scrollwheel="{{scrollwheel}}" scale="{{scale}}" zoom_pancontrol="{{zoom_pancontrol}}" marker="{{marker_image}}" map_info="{{map_info}}"]',
	'popup_title' 	=> __( 'Google Map Shortcode', 'TemplateCore' ),
);

/* =============================================================
 *	Image Frame Config
 * ============================================================= */

$tpath_shortcodes['imageframe'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'shape'  => array(
			'type' 		=> 'select',
			'label' 	=> __('Image Shape', 'TemplateCore'),
			'desc' 		=> __('Choose image shape. For circle shape image need to be equal in width and height.', 'TemplateCore'),
			'options' 	=> array(
				'none' 			=> 'None',
				'rounded' 		=> 'Rounded Corners',
				'circle' 		=> 'Circle',
				'thumbnail' 	=> 'Border'				
			)
		),
		'shadow'  => array(
			'type' 		=> 'select',
			'label' 	=> __('Image Frame Shadow', 'TemplateCore'),
			'desc' 		=> __('Select shadow will show on Image Frame.', 'TemplateCore'),
			'options' 	=> array(
				'none' 			=> 'None',
				'dropshade'		=> 'Drop Shadow',
				'bottomcurved' 	=> 'Bottom Curved Shadow',
				'roundedshade' 	=> 'Rounded Drop Shadow',
			)
		),
		'bordercolor' => array(
			'type' 	=> 'colorpicker',
			'label' => __( 'Border Color', 'TemplateCore' ),
			'desc' 	=> __( 'Choose color for border.', 'TemplateCore' ),
		),
		'border_width' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Border Width', 'TemplateCore'),
			'desc' 	=> __('Enter border width for image. Ex: 2 or 3.', 'TemplateCore'),
		),
		'lightbox' => array(
			'type' 		=> 'select',
			'label' 	=> __('Lightbox Image', 'TemplateCore'),
			'desc' 		=> __('Show image in Lightbox', 'TemplateCore'),
			'options' 	=> array(
				'yes' 		=> 'Yes',
				'no' 		=> 'No'				
			)
		),
		'image' => array(
			'type' 	=> 'media',
			'std' 	=> '',
			'label' => __('Upload Image', 'TemplateCore'),
			'desc' 	=> __('Upload an image to display in the frame', 'TemplateCore')
		),
		'alt' => array(
			'std' 	=> 'Image',
			'type' 	=> 'text',
			'label' => __('Image Alt Text', 'TemplateCore'),
			'desc' 	=> __('If an image cannot be viewed the alt attribute text will be shown', 'TemplateCore')
		),		
		'animation_type' => array(			
			'type' 		=> 'select',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),
	'shortcode' 	=> '[tpath_imageframe shape="{{shape}}" shadow="{{shadow}}" bordercolor="{{bordercolor}}" borderwidth="{{border_width}}" lightbox="{{lightbox}}" src="{{image}}" alt="{{alt}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]',
	'popup_title' 	=> __( 'Image Frame Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Image Frame with Overlay Config
 * ============================================================= */

$tpath_shortcodes['imageframe_overlay'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'shape'  => array(
			'type' 		=> 'select',
			'label' 	=> __('Image Shape', 'TemplateCore'),
			'desc' 		=> __('Choose image shape. For circle shape image need to be equal in width and height.', 'TemplateCore'),
			'options' 	=> array(
				'none' 			=> 'None',
				'rounded' 		=> 'Rounded Corners',
				'circle' 		=> 'Circle',
				'thumbnail' 	=> 'Border'				
			)
		),
		'shadow'  => array(
			'type' 		=> 'select',
			'label' 	=> __('Image Frame Shadow', 'TemplateCore'),
			'desc' 		=> __('Select shadow will show on Image Frame.', 'TemplateCore'),
			'options' 	=> array(
				'none' 			=> 'None',
				'dropshade'		=> 'Drop Shadow',
				'bottomcurved' 	=> 'Bottom Curved Shadow',
				'roundedshade' 	=> 'Rounded Drop Shadow',
			)
		),
		'bordercolor' => array(
			'type' 	=> 'colorpicker',
			'label' => __( 'Border Color', 'TemplateCore' ),
			'desc' 	=> __( 'Choose color for border.', 'TemplateCore' ),
		),
		'border_width' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Border Width', 'TemplateCore'),
			'desc' 	=> __('Enter border width for image. Ex: 2 or 3.', 'TemplateCore'),
		),		
		'image' => array(
			'type' 	=> 'media',
			'std' 	=> '',
			'label' => __('Upload Image', 'TemplateCore'),
			'desc' 	=> __('Upload an image to display in the frame', 'TemplateCore')
		),
		'alt' => array(
			'std' 	=> 'Image',
			'type' 	=> 'text',
			'label' => __('Image Alt Text', 'TemplateCore'),
			'desc' 	=> __('If an image cannot be viewed the alt attribute text will be shown', 'TemplateCore')
		),
		'img_overlay' => array(
			'type' 		=> 'select',
			'label' 	=> __('Image Overlay', 'TemplateCore'),
			'desc' 		=> __('Enable Image Overlay Text', 'TemplateCore'),
			'options' 	=> array(
				'yes' 		=> 'Yes',
				'no' 		=> 'No'				
			)
		),		
		'overlay_position' => array(
			'type' 		=> 'select',
			'label' 	=> __('Overlay Position', 'TemplateCore'),
			'desc' 		=> __('Image Overlay Content Position', 'TemplateCore'),
			'options' 	=> array(
				'top' 		=> 'Top',
				'bottom' 	=> 'Bottom'				
			)
		),
		'content' => array(
			'std' 	=> 'Your Content!',
			'type' 	=> 'textarea',
			'label' => __('Image Overlay Content', 'TemplateCore'),
			'desc' 	=> __('Enter Image Overlay Content', 'TemplateCore')
		),
		'animation_type' => array(			
			'type' 		=> 'select',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),
	'shortcode' 	=> '[tpath_imageframe_overlay shape="{{shape}}" shadow="{{shadow}}" bordercolor="{{bordercolor}}" borderwidth="{{border_width}}" src="{{image}}" alt="{{alt}}" overlay="{{img_overlay}}" overlay_position="{{overlay_position}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]{{content}}[/tpath_imageframe_overlay]',
	'popup_title' 	=> __( 'Image Frame Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Bootstrap Simple Carousel Config
 * ============================================================= */

$tpath_shortcodes['bootcarousel'] = array(
	'no_preview' => true,
	'params' 	 => array(),
	'child_shortcode' => array(
		'params' => array(
			'linktype' => array(
				'type' 		=> 'select',
				'label' 	=> __('Link Type', 'TemplateCore'),
				'desc' 		=> __('Choose Image Link Type', 'TemplateCore'),
				'options' 	=> array(
					'none'		=> 'None',
					'lightbox' 	=> 'Lightbox',
					'link' 		=> 'Link'
				)
			),
			'url' => array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Image Link', 'TemplateCore'),
				'desc' 	=> __('Add the url to image. Only for Image Link Type', 'TemplateCore')
			),
			'target' => array(
				'type' 		=> 'select',
				'label' 	=> __('Link Target', 'TemplateCore'),
				'desc' 		=> __('_self = Open in same window <br />_blank = Open in new window', 'TemplateCore'),
				'options' 	=> array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'image' => array(
				'type' 	=> 'media',
				'label' => __('Image', 'TemplateCore'),
				'desc' 	=> __('Upload an image for carousel', 'TemplateCore')
			),
			'alt' => array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Image Alt Text', 'TemplateCore'),
				'desc' 	=> __('If an image cannot be viewed the alt attribute text will be shown', 'TemplateCore')
			),
			'caption' => array(
				'std' 	=> 'Your Caption',
				'type' 	=> 'textarea',
				'label' => __( 'Caption', 'TemplateCore' ),
				'desc' 	=> __( 'Add caption to show in slider', 'TemplateCore' ),
			)
		),
		'shortcode' 	=> '[tpath_image linktype="{{linktype}}" link="{{url}}" target="{{target}}" image="{{image}}" alt="{{alt}}" caption="{{caption}}"]',
		'clone_button'  => __('Add New Carousel Item', 'TemplateCore')
	),
	'shortcode' 	=> '[tpath_carousel]{{child_shortcode}}[/tpath_carousel]',
	'popup_title' 	=> __('Boostrap Carousel Shortcode', 'TemplateCore'),
);

/* =============================================================
 *	Progress Bar Config
 * ============================================================= */

$tpath_shortcodes['progressbar'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'title' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __( 'Progress Bar Title', 'TemplateCore' ),
			'desc' 	=> __( 'Enter Progress Bar Title', 'TemplateCore' ),
		),
		'value' => array(
			'std' 	=> '20',
			'type' 	=> 'text',
			'label' => __('Filled Area Percentage', 'TemplateCore'),
			'desc' 	=> __('Enter number from 1 to 100', 'TemplateCore')			
		),		
		'filledcolor' => array(
			'type' 	=> 'colorpicker',
			'label' => __('Filled Color', 'TemplateCore'),
			'desc'	=> __('Background Color for filled in area', 'TemplateCore')
		),
		'unfilledcolor' => array(
			'type' 	=> 'colorpicker',
			'label' => __('Unfilled Color', 'TemplateCore'),
			'desc'  => __('Background Color for unfilled area', 'TemplateCore')
		),
		'animation' => array(
			'type' 		=> 'select',
			'label' 	=> __('Enable Striped Animation', 'TemplateCore'),
			'desc' 		=> __('Choose to enable striped animation on Progress Bars.', 'TemplateCore'),
			'options' 	=> array(
				'yes'	=> 'Yes',
				'no' 	=> 'No'
			)
		),
		'content' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __( 'Progress Bar Text', 'TemplateCore' ),
			'desc' 	=> __( 'Text will show up on progess bar', 'TemplateCore' ),
		)
	),
	'shortcode' 	=> '[tpath_progress_bar title="{{title}}" percentage="{{value}}" filledcolor="{{filledcolor}}" unfilledcolor="{{unfilledcolor}}" animation="{{animation}}"]{{content}}[/tpath_progress_bar]',
	'popup_title' 	=> __('Progress Bar Shortcode', 'TemplateCore')
);

/* =============================================================
 *	Counters Config
 * ============================================================= */

$tpath_shortcodes['counters'] = array(
	'no_preview' => true,
	'params' 	 => array(),
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Title', 'TemplateCore'),
				'desc' 	=> __('Enter the title for counter item.', 'TemplateCore')
			),
			'column' => array(
				'type' 		=> 'select',
				'std'		=> '',
				'label' 	=> __('Column Size', 'TemplateCore'),
				'desc' 		=> __('Select the width of the column.', 'TemplateCore'),
				'options' 	=> array(					
					'3' 	=> 'Size 3 (25%)',
					'4' 	=> 'Size 4 (33.33%)',
					'5' 	=> 'Size 5 (41.67%)',
					'6' 	=> 'Size 6 (50%)',
					'7' 	=> 'Size 7 (58.33%)',
					'8' 	=> 'Size 8 (66.67%)',
					'9' 	=> 'Size 9 (75%)',
					'10' 	=> 'Size 10 (83.33%)',
					'11' 	=> 'Size 11 (91.67%)',
					'12' 	=> 'Size 12 (100%)'
				)
			),
			'value' => array(
				'std' 	=> '150',
				'type' 	=> 'text',
				'label' => __('Counter Value', 'TemplateCore'),
				'desc' 	=> __('Enter counter value.', 'TemplateCore')
			),			
			'icon' 		=> array(
				'type' 		=> 'iconpicker',
				'std'		=> '',
				'label' 	=> __('Select Icon', 'TemplateCore'),
				'desc' 		=> __('Click an icon to select, click again to deselect', 'TemplateCore'),
				'options' 	=> $icons
			),
			'iconcolor' => array(
				'type' 	=> 'colorpicker',
				'std'		=> '',
				'label' => __('Icon Color', 'TemplateCore'),
				'desc' 	=> __('Leave blank for default', 'TemplateCore')
			),
		),
		'shortcode' 	=> '[tpath_counter title="{{title}}" column_size="{{column}}" value="{{value}}" icon="{{icon}}" iconcolor="{{iconcolor}}"]',
		'clone_button'  => __('Add New Counter', 'TemplateCore')
	),
	'shortcode' 	=> '[tpath_counters]{{child_shortcode}}[/tpath_counters]',
	'popup_title' 	=> __('Counters Shortcode', 'TemplateCore'),
);

/* =============================================================
 *	Jumbotron Config
 * ============================================================= */

$tpath_shortcodes['jumbotron'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'title' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Title', 'TemplateCore'),
			'desc' 	=> __('Enter title to show in Jumbotron', 'TemplateCore')			
		),
		'content' => array(
			'type' 	=> 'textarea',
			'std'	=> '',
			'label' => __('Content', 'TemplateCore'),
			'desc'	=> __('Enter content to show in Jumbotron', 'TemplateCore')
		),
		'bg_image' => array(
			'type' 	=> 'media',
			'std'	=> '',
			'label' => __('Container Background Image', 'TemplateCore'),
			'desc' 	=> __('Upload an image to use background for container. Leave blank for default.', 'TemplateCore'),
		),
		'bg_repeat' => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Background Repeat', 'TemplateCore'),
			'desc' 		=> __('Choose background repeat for container.', 'TemplateCore'),
			'options' 	=> array(
				'repeat'	=> 'Repeat', 
				'repeat-x'	=> 'Repeat-x', 
				'repeat-y'	=> 'Repeat-y', 
				'no-repeat' => 'No Repeat' 
			)
		),
		'bg_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Container Background Color', 'TemplateCore'),
			'desc' 	=> __('Choose Container Background Color.', 'TemplateCore'),
		),
		'content_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Container Text Color', 'TemplateCore'),
			'desc' 	=> __('Choose Container Text Color.', 'TemplateCore'),
		),
		'border_radius' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Border Radius', 'TemplateCore'),
			'desc' 	=> __('Enter border radius. Ex: 2px or 50%.', 'TemplateCore')			
		),
		'show_button' => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Show Button', 'TemplateCore'),
			'desc' 		=> __('Choose to show button with custom link.', 'TemplateCore'),
			'options' 	=> array(
				'yes'	=> 'Yes',
				'no' 	=> 'No'
			)
		),
		'button_text' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Button Text', 'TemplateCore'),
			'desc' 	=> __('Enter button text.', 'TemplateCore')			
		),
		'button_link' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Button Link', 'TemplateCore'),
			'desc'  => __('Enter button link.', 'TemplateCore')
		),
		'target' => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Link Target', 'TemplateCore'),
			'desc' 		=> __('_self = Open in same window <br />_blank = Open in new window', 'TemplateCore'),
			'options' 	=> array(
				'_self'  => '_self',
				'_blank' => '_blank'
			)
		),
		'size' 	=> array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Button Size', 'TemplateCore'),
			'desc' 		=> __('Select the button\'s size', 'TemplateCore'),
			'options' 	=> array(
				'default' 	=> 'Default',
				'mini'		=> 'Extra Small',
				'small'		=> 'Small',
				'large' 	=> 'Large'
			)
		),
		'button_bg_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Background Color', 'TemplateCore'),
			'desc' 	=> __('Button Background Color.', 'TemplateCore'),
		),
		'button_bg_hover_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Background Hover Color', 'TemplateCore'),
			'desc' 	=> __('Button Background Hover Color.', 'TemplateCore'),
		),
		'textcolor' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Text Color', 'TemplateCore'),
			'desc' 	=> __('Button Text Color. Leave blank for default.', 'TemplateCore'),
		),
		'texthovercolor' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Text Hover Color', 'TemplateCore'),
			'desc' 	=> __('Button Text Hover Color. Leave blank for default.', 'TemplateCore'),
		),
		'icon' => array(
			'type' 		=> 'iconpicker',
			'std'		=> '',
			'label' 	=> __('Select Icon', 'TemplateCore'),
			'desc' 		=> __('Click an icon to select, click again to deselect', 'TemplateCore'),
			'options' 	=> $icons			
		),
		'icon_position' => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Icon Position', 'TemplateCore'),
			'desc' 		=> 'Select the position of the icon for button',
			'options' 	=> array(
				'left' 		=> 'Left',
				'right' 	=> 'Right',				
			)
		),
		'animation_type' => array(			
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),
	'shortcode' 	=> '[tpath_jumbotron title="{{title}}" show_button="{{show_button}}" bg_image="{{bg_image}}" bg_repeat="{{bg_repeat}}" bg_color="{{bg_color}}" content_color="{{content_color}}" borderradius="{{border_radius}}" button_text="{{button_text}}" button_link="{{button_link}}" target="{{target}}" size="{{size}}" button_bg_color="{{button_bg_color}}" button_bg_hover_color="{{button_bg_hover_color}}" color="{{textcolor}}" hovercolor="{{texthovercolor}}" icon="{{icon}}" icon_pos="{{icon_position}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]{{content}}[/tpath_jumbotron]',
	'popup_title' 	=> __('Jumbotron Shortcode', 'TemplateCore')
);

/* =============================================================
 *	Modals Config
 * ============================================================= */

$tpath_shortcodes['modal'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'title' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Modal Title', 'TemplateCore'),
			'desc' 	=> __('Enter title to show in Modal header', 'TemplateCore')
		),
		'content' => array(
			'type' 	=> 'textarea',
			'std'	=> '',
			'label' => __('Content', 'TemplateCore'),
			'desc'	=> __('Enter content to show in Modal', 'TemplateCore')
		),
		'modal_size' => array(
			'type' 	=> 'select',
			'std'	=> '',
			'label' => __('Modal Size', 'TemplateCore'),
			'desc' 	=> __('Choose modal size', 'TemplateCore'),
			'options' 	=> array(
				'default'	=> 'Default',
				'small'		=> 'Small',
				'large' 	=> 'Large'
			)
		),
		'button_size' => array(
			'type' 	=> 'select',
			'std'	=> '',
			'label' => __('Button Size', 'TemplateCore'),
			'desc' 	=> __('Choose button size', 'TemplateCore'),
			'options' 	=> array(
				'default'	=> 'Default',
				'mini'		=> 'Extra Small',
				'small'		=> 'Small',
				'large' 	=> 'Large'
			)
		),
		'button_text' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Button Text', 'TemplateCore'),
			'desc' 	=> __('Enter button text to open modal window by clicking it.', 'TemplateCore')
		),
		'button_bg_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',
			'label' => __('Button Background Color', 'TemplateCore'),
			'desc' 	=> __('Button Background Color.', 'TemplateCore'),
		),
		'button_bg_hover_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',
			'label' => __('Button Background Hover Color', 'TemplateCore'),
			'desc' 	=> __('Button Background Hover Color.', 'TemplateCore'),
		),
		'textcolor' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',
			'label' => __('Button Text Color', 'TemplateCore'),
			'desc' 	=> __('Button Text Color. Leave blank for default.', 'TemplateCore'),
		),
		'texthovercolor' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',
			'label' => __('Button Text Hover Color', 'TemplateCore'),
			'desc' 	=> __('Button Text Hover Color. Leave blank for default.', 'TemplateCore'),
		),
		'icon' => array(
			'type' 		=> 'iconpicker',
			'std'		=> '',
			'label' 	=> __('Select Icon', 'TemplateCore'),
			'desc' 		=> __('Click an icon to select, click again to deselect', 'TemplateCore'),
			'options' 	=> $icons
		),
		'icon_position' => array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Icon Position', 'TemplateCore'),
			'desc' 		=> 'Select the position of the icon for button',
			'options' 	=> array(
				'left' 		=> 'Left',
				'right' 	=> 'Right',
			)
		),
		'animation_type' => array(			
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),
	'shortcode' 	=> '[tpath_modals title="{{title}}" modal_size="{{modal_size}}" button_size="{{button_size}}" button_text="{{button_text}}" button_bg_color="{{button_bg_color}}" button_bg_hover_color="{{button_bg_hover_color}}" color="{{textcolor}}" hovercolor="{{texthovercolor}}" icon="{{icon}}" icon_pos="{{icon_position}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]{{content}}[/tpath_modals]',
	'popup_title' 	=> __('Modals Shortcode', 'TemplateCore')
);

/* =============================================================
 *	Content Boxes Config
 * ============================================================= */

$tpath_shortcodes['contentboxes'] = array(
	'no_preview' => true,
	'params' 	 => array(),
	'child_shortcode' => array(
		'params' => array(
			'layout' => array(
				'type' 		=> 'select',
				'label' 	=> __( 'Box Layout', 'TemplateCore' ),
				'desc' 		=> __('Select the layout for the content box', 'TemplateCore'),
				'options' 	=> array(
					'thumb-boxed' 		=> 'Only Thumbnail Image',
					'thumb-on-top' 		=> 'Thumbnail on Top of Title',
					'thumb-overlay'		=> 'Show Title and Content on Thumbnail Overlay',
					'thumb-on-bottom'	=> 'Thumbnail on After Title',
				)
			),
			'title' => array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Title', 'TemplateCore'),
				'desc' 	=> __('Enter the title for content box', 'TemplateCore')
			),
			'thumb_image' => array(
				'type' 	=> 'media',
				'label' => __('Thumbnail Image', 'TemplateCore'),
				'desc' 	=> __('Upload an image to be used as thumbnail', 'TemplateCore')
			),
			'full_image' => array(
				'type' 	=> 'media',
				'label' => __('Full Image', 'TemplateCore'),
				'desc' 	=> __('Upload an full size image to view in lightbox if layout set to Only Thumbnail Image', 'TemplateCore')
			),
			'alt' => array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Image Alt Text', 'TemplateCore'),
				'desc' 	=> __('If an image cannot be viewed the alt attribute text will be shown', 'TemplateCore')
			),			
			'link_url' => array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Read More Link', 'TemplateCore'),
				'desc' 	=> __('Add the url to Read More button', 'TemplateCore')
			),
			'link_text' => array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Read More Text', 'TemplateCore'),
				'desc' 	=> __('Enter the text to display as link', 'TemplateCore')
			),
			'target' => array(
				'type' 		=> 'select',
				'label' 	=> __('Link Target', 'TemplateCore'),
				'desc' 		=> __('_self = Open in same window <br />_blank = Open in new window', 'TemplateCore'),
				'options' 	=> array(
					'_self' 	=> '_self',
					'_blank' 	=> '_blank'
				)
			),
			'column' => array(
				'type' 		=> 'select',
				'label' 	=> __('Column Size', 'TemplateCore'),
				'desc' 		=> __('Select the width of the column.', 'TemplateCore'),
				'options' 	=> array(					
					'3' 	=> 'Size 3 (25%)',
					'4' 	=> 'Size 4 (33.33%)',
					'5' 	=> 'Size 5 (41.67%)',
					'6' 	=> 'Size 6 (50%)',
					'7' 	=> 'Size 7 (58.33%)',
					'8' 	=> 'Size 8 (66.67%)',
					'9' 	=> 'Size 9 (75%)',
					'10' 	=> 'Size 10 (83.33%)',
					'11' 	=> 'Size 11 (91.67%)',
					'12' 	=> 'Size 12 (100%)'
				)
			),
			'content' => array(
				'std' 	=> 'Your Content !',
				'type' 	=> 'textarea',
				'label' => __( 'Content', 'TemplateCore' ),
				'desc' 	=> __( 'Add content for content box', 'TemplateCore' ),
			),
			'animation_type' => array(			
				'type' 		=> 'select',
				'label' 	=> __('Animation Type', 'TemplateCore'),
				'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
				'options'	=> $animations
			),
			'animation_delay' => array(
				'std' 		=> '500',
				'type' 		=> 'text',
				'label' 	=> __('Animation Delay', 'TemplateCore'),
				'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
			),
		),
		'shortcode' 	=> '[tpath_contentbox layout="{{layout}}" title="{{title}}" thumb_image="{{thumb_image}}" full_image="{{full_image}}" alt="{{alt}}" link="{{link_url}}" link_text="{{link_text}}" target="{{target}}" column="{{column}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]{{content}}[/tpath_contentbox]',
		'clone_button'  => __('Add New Content Box', 'TemplateCore')
	),	
	'shortcode' 	=> '[tpath_contentboxes]{{child_shortcode}}[/tpath_contentboxes]',
	'popup_title' 	=> __('Content Boxes Shortcode', 'TemplateCore')
);

/* =============================================================
 *	Tabs Config
 * ============================================================= */

$tpath_shortcodes['tabs'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'layout' 		=> array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Layout', 'TemplateCore'),
			'desc' 		=> __('Choose the layout of tabs', 'TemplateCore'),
			'options' 	=> array(
				'horizontal' 	=> 'Horizontal',
				'vertical-left'	=> 'Vertical Left',
				'vertical-right'=> 'Vertical Right'
			)
		),
		'activecolor' 	=> array(
			'type' 	=> 'colorpicker',
			'std' 	=> '',
			'label' => __('Active Background Color', 'TemplateCore'),
			'desc' 	=> __('Choose active tab background color. Leave blank for default', 'TemplateCore'),
		),
		'inactivecolor' => array(
			'type' 	=> 'colorpicker',
			'std' 	=> '',
			'label' => __('Inactive Background Color', 'TemplateCore'),
			'desc' 	=> __('Choose inactive tab background color. Leave blank for default', 'TemplateCore'),
		)
	),
	'child_shortcode' => array(
		'params' 	  => array(
			'title'   => array(
				'std' 	=> 'Title',
				'type' 	=> 'text',
				'label' => __('Tab Title', 'TemplateCore'),
				'desc' 	=> __('Title of the tab', 'TemplateCore'),
			),
			'icon' => array(
				'type' 		=> 'iconpicker',
				'std'		=> '',
				'label' 	=> __('Select Icon', 'TemplateCore'),
				'desc' 		=> __('Select icon to show before tab title. Click an icon to select, click again to deselect', 'TemplateCore'),
				'options' 	=> $icons
			),
			'titlecolor' => array(
				'type' 	=> 'colorpicker',
				'std' 	=> '',
				'label' => __('Icon & Title Color', 'TemplateCore'),
				'desc' 	=> __('Choose icon and tab title color. Leave blank for default', 'TemplateCore'),
			),
			'content' => array(
				'std' 	=> 'Your Tab Content',
				'type' 	=> 'textarea',
				'label' => __('Tab Content', 'TemplateCore'),
				'desc' 	=> __('Add the tabs content', 'TemplateCore')
			)
		),
		'shortcode' 	=> '[tpath_tab title="{{title}}" icon="{{icon}}" color="{{titlecolor}}"]{{content}}[/tpath_tab]',
		'clone_button'  => __('Add New Tab', 'TemplateCore')
	),
	'shortcode' 	=> '[tpath_tabs layout="{{layout}}" activecolor="{{activecolor}}" inactivecolor="{{inactivecolor}}"]{{child_shortcode}}[/tpath_tabs]',
	'popup_title' 	=> __('Tab Shortcode', 'TemplateCore'),
);

/* =============================================================
 *	Accordion Config
 * ============================================================= */

$tpath_shortcodes['accordion'] = array(
	'no_preview' => true,
	'params' 	 => array(),
	'child_shortcode' => array(
		'params' 	  => array(
			'title'   => array(
				'std' 	=> 'Title',
				'type' 	=> 'text',
				'label' => __('Title', 'TemplateCore'),
				'desc' 	=> __('Insert the accordion title', 'TemplateCore')
			),
			'open' 	  => array(
				'type' 		=> 'select',
				'label' 	=> __('Open by Default', 'TemplateCore'),
				'desc' 		=> __('Choose to have the accordion open by default', 'TemplateCore'),
				'options' 	=> array(
					'no' 	=> 'No',
					'yes'	=> 'Yes'					
				)
			),
			'content' => array(
				'std' 	=> 'Your Content !',
				'type' 	=> 'textarea',
				'label' => __('Accordion Content', 'TemplateCore'),
				'desc' 	=> __('Insert the accordion content', 'TemplateCore')
			)
		),
		'shortcode' 	=> '[tpath_accordion title="{{title}}" open="{{open}}"]{{content}}[/tpath_accordion]',
		'clone_button'  => __('Add New Accordion Item', 'TemplateCore')
	),
	'shortcode' 	=> '[tpath_accordions]{{child_shortcode}}[/tpath_accordions]',
	'popup_title' 	=> __('Accordion Shortcode', 'TemplateCore'),
);

/* =============================================================
 *	Tooltip Config
 * ============================================================= */

$tpath_shortcodes['tooltip'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'title'  => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Tooltip Text', 'TemplateCore'),
			'desc' 	=> __('Insert the text that displays in the tooltip', 'TemplateCore')
		),
		'position' 	 => array(
			'type' 		=> 'select',
			'label' 	=> __('Tooltip Position', 'TemplateCore'),
			'desc' 		=> __('Choose the position to tooltip appear', 'TemplateCore'),
			'options' 	=> array(
				'left' 		=> 'Left',
				'top'		=> 'Top',
				'bottom'	=> 'Bottom',
				'right'		=> 'Right'
			)
		),
		'content' => array(
			'std' 	=> '',
			'type' 	=> 'textarea',
			'label' => __('Content', 'TemplateCore'),
			'desc' 	=> __('Insert the text that will activate the tooltip hover', 'TemplateCore')
		),
	),
	'shortcode' 	=> '[tpath_tooltip title="{{title}}" position="{{position}}"]{{content}}[/tpath_tooltip]',
	'popup_title' 	=> __( 'Tooltip Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Blockquotes Config
 * ============================================================= */

$tpath_shortcodes['blockquotes'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'footer_text' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Blockquote Cite Text', 'TemplateCore'),
			'desc' 	=> __('Insert the footer text. Author or source name', 'TemplateCore')
		),
		'position' 	 => array(
			'type' 		=> 'select',
			'label' 	=> __('Blockquote Align', 'TemplateCore'),
			'desc' 		=> __('Choose blockquote alignment', 'TemplateCore'),
			'options' 	=> array(
				'left' 		=> 'Left',
				'right'		=> 'Right'
			)
		),
		'content'	=> array(
			'std' 	=> 'Your Blockquote content !',
			'type' 	=> 'textarea',
			'label' => __('Content', 'TemplateCore'),
			'desc' 	=> __('Insert the blockquote content', 'TemplateCore')
		),
		'animation_type' => array(			
			'type' 		=> 'select',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),
	'shortcode' 	=> '[tpath_blockquote footer_text="{{footer_text}}" position="{{position}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]{{content}}[/tpath_blockquote]',
	'popup_title' 	=> __( 'Blockquotes Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Lead Paragraph Config
 * ============================================================= */

$tpath_shortcodes['leadpara'] = array(
	'no_preview' => true,
	'params' 	 => array(		
		'align' 	 => array(
			'type' 		=> 'select',
			'label' 	=> __('Paragraph Alignment', 'TemplateCore'),
			'desc' 		=> __('Choose paragraph alignment', 'TemplateCore'),
			'options' 	=> array(
				'left' 		=> 'Left',
				'right'		=> 'Right',
				'center'	=> 'Center',
				'justify'	=> 'Justify'
			)
		),
		'content'	=> array(
			'std' 	=> 'Your content !',
			'type' 	=> 'textarea',
			'label' => __('Content', 'TemplateCore'),
			'desc' 	=> __('Insert the paragraph content', 'TemplateCore')
		),
	),
	'shortcode' 	=> '[tpath_leadpara align="{{align}}"]{{content}}[/tpath_leadpara]',
	'popup_title' 	=> __( 'Lead Paragraph Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Popover Config
 * ============================================================= */

$tpath_shortcodes['popover'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'title' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Popover Title', 'TemplateCore'),
			'desc' 	=> __('Insert the title.', 'TemplateCore')
		),
		'content'	=> array(
			'std' 	=> 'Your content !',
			'type' 	=> 'textarea',
			'label' => __('Popover Content', 'TemplateCore'),
			'desc' 	=> __('Insert the popover content', 'TemplateCore')
		),		
		'position' 	 => array(
			'type' 		=> 'select',
			'label' 	=> __('Popover Position', 'TemplateCore'),
			'desc' 		=> __('Choose the position to popover appear', 'TemplateCore'),
			'options' 	=> array(
				'left' 		=> 'Left',
				'top'		=> 'Top',
				'bottom'	=> 'Bottom',
				'right'		=> 'Right'
			)
		),
		'link_type' 	 => array(
			'type' 		=> 'select',
			'label' 	=> __('Popover Link Type', 'TemplateCore'),
			'desc' 		=> __('Choose type of text to active popover.', 'TemplateCore'),
			'options' 	=> array(
				'button' 	=> 'Button',
				'link'		=> 'Link'
			)
		),
		'popover_show' 	 => array(
			'type' 		=> 'select',
			'label' 	=> __('Popover Show', 'TemplateCore'),
			'desc' 		=> __('Choose when popover needs to activate. By "Click" on popover show wont work with Link type.', 'TemplateCore'),
			'options' 	=> array(
				'hover' 	=> 'Hover',
				'click'		=> 'Click'				
			)
		),
		'link_text' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Link or Button Text', 'TemplateCore'),
			'desc' 	=> __('Insert the link or button text.', 'TemplateCore')
		),
		'link_url' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Link or Button URL', 'TemplateCore'),
			'desc' 	=> __('Insert the link for text.', 'TemplateCore')
		),
		'target' => array(
			'type' 		=> 'select',
			'label' 	=> __('Link or Button Target', 'TemplateCore'),
			'desc' 		=> __('_self = Open in same window <br />_blank = Open in new window', 'TemplateCore'),
			'options' 	=> array(
				'_self' 	=> '_self',
				'_blank' 	=> '_blank'
			)
		),		
		'button_size' => array(
			'type' 		=> 'select',
			'label' 	=> __('Button Size', 'TemplateCore'),
			'desc' 		=> __('Select the button\'s size', 'TemplateCore'),
			'options' 	=> array(
				'default' 	=> 'Default',
				'mini'		=> 'Extra Small',
				'small'		=> 'Small',
				'large' 	=> 'Large'
			)
		),
		'button_bg_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Background Color', 'TemplateCore'),
			'desc' 	=> __('Button Background Color.', 'TemplateCore'),
		),
		'button_bg_hover_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Background Hover Color', 'TemplateCore'),
			'desc' 	=> __('Button Background Hover Color.', 'TemplateCore'),
		),
		'textcolor' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Text Color', 'TemplateCore'),
			'desc' 	=> __('Button Text Color. Leave blank for default.', 'TemplateCore'),
		),
		'texthovercolor' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Button Text Hover Color', 'TemplateCore'),
			'desc' 	=> __('Button Text Hover Color. Leave blank for default.', 'TemplateCore'),
		),
		'icon' => array(
			'type' 		=> 'iconpicker',
			'label' 	=> __('Select Icon', 'TemplateCore'),
			'desc' 		=> __('Click an icon to select, click again to deselect', 'TemplateCore'),
			'options' 	=> $icons			
		),
		'icon_position' => array(
			'type' 		=> 'select',
			'label' 	=> __('Icon Position', 'TemplateCore'),
			'desc' 		=> 'Select the position of the icon',
			'options' 	=> array(
				'left' 		=> 'Left',
				'right' 	=> 'Right',				
			)
		),		
	),
	'shortcode' 	=> '[tpath_popover title="{{title}}" popover_pos="{{position}}" link_type="{{link_type}}" show_on="{{popover_show}}" link_text="{{link_text}}" link_url="{{link_url}}" target="{{target}}" size="{{button_size}}" button_bg_color="{{button_bg_color}}" button_bg_hover_color="{{button_bg_hover_color}}" color="{{textcolor}}" hovercolor="{{texthovercolor}}" icon="{{icon}}" icon_pos="{{icon_position}}"]{{content}}[/tpath_popover]',
	'popup_title' 	=> __( 'Popover Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Table Config
 * ============================================================= */

$tpath_shortcodes['table'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'type' 	 => array(
			'type' 		=> 'select',
			'label' 	=> __('Style Type', 'TemplateCore'),
			'desc' 		=> __('Choose the table style', 'TemplateCore'),
			'options' 	=> array(
				'striped' 		=> 'Striped',
				'bordered'		=> 'Bordered',
				'condensed' 	=> 'Condensed'
			)
		),
		'rows' => array(
			'type' 		=> 'select',
			'label' 	=> __('Number of Rows', 'TemplateCore'),
			'desc' 		=> __('Select number of rows for table', 'TemplateCore'),
			'options' 	=> array(
				'1' 	=> '1 Row',
				'2'		=> '2 Rows',
				'3'		=> '3 Rows',
				'4'		=> '4 Rows',
				'5'		=> '5 Rows'
			)
		),
		'columns' => array(
			'type' 		=> 'select',
			'label' 	=> __('Number of Columns', 'TemplateCore'),
			'desc' 		=> __('Select number of columns for table', 'TemplateCore'),
			'options' 	=> array(
				'1' 	=> '1 Column',
				'2'		=> '2 Columns',
				'3'		=> '3 Columns',
				'4'		=> '4 Columns',
				'5'		=> '5 Columns'
			)
		),
	),
	'shortcode' 	=> '',
	'popup_title' 	=> __( 'Table Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	SoundCloud Config
 * ============================================================= */

$tpath_shortcodes['soundcloud'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'url' 	 => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('SoundCloud Url', 'TemplateCore'),
			'desc' 	=> __('Enter SoundCloud url, Ex: http://api.soundcloud.com/tracks/59051244', 'TemplateCore')
		),
		'comments' => array(
			'type' 		=> 'select',
			'label' 	=> __('Show Comments', 'TemplateCore'),
			'desc' 		=> __('Choose to display comments', 'TemplateCore'),
			'options' 	=> array(
				'yes' 	=> 'Yes',
				'no'	=> 'No'				
			)
		),
		'auto_play' => array(
			'type' 		=> 'select',
			'label' 	=> __('Autoplay', 'TemplateCore'),
			'desc' 		=> __('Select to autoplay the track', 'TemplateCore'),
			'options' 	=> array(
				'no' 	=> 'No',
				'yes'	=> 'Yes'				
			)
		),
		'buy_like_buttons' => array(
			'type' 		=> 'select',
			'label' 	=> __('Show Buy& Like Buttons', 'TemplateCore'),
			'desc' 		=> __('Select to show/hide buy & like buttons', 'TemplateCore'),
			'options' 	=> array(
				'yes'	=> 'Yes',
				'no' 	=> 'No'
			)
		),
		'show_artwork' => array(
			'type' 		=> 'select',
			'label' 	=> __('Show Artwork', 'TemplateCore'),
			'desc' 		=> __('Select to show/hide artwork', 'TemplateCore'),
			'options' 	=> array(
				'yes'	=> 'Yes',
				'no' 	=> 'No'
			)
		),
		'color' 	=> array(
			'type' 	=> 'colorpicker',
			'std' 	=> '#FF5500',
			'label' => __('Color', 'TemplateCore'),
			'desc' 	=> __('Select the color for play button and other controls', 'TemplateCore')
		),		
		'width' 	=> array(
			'std' 	=> '100%',
			'type' 	=> 'text',
			'label' => __('Width', 'TemplateCore'),
			'desc' 	=> __('Enter player width in pixels or percentage. Ex: 100% or 500px',  'TemplateCore')
		),
		'height' 	=> array(
			'std' 	=> '110',
			'type' 	=> 'text',
			'label' => __('Height', 'TemplateCore'),
			'desc' 	=> __('Enter player height in pixels. Ex: 110', 'TemplateCore')
		),
	),
	'shortcode' 	=> '[tpath_soundcloud url="{{url}}" comments="{{comments}}" autoplay="{{auto_play}}" buy_like="{{buy_like_buttons}}" show_artwork="{{show_artwork}}" color="{{color}}" width="{{width}}" height="{{height}}"]',
	'popup_title' 	=> __( 'SoundCloud Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Vimeo Config
 * ============================================================= */

$tpath_shortcodes['vimeo'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'player_id' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Video ID', 'TemplateCore'),
			'desc' 	=> __('For example the Video ID for https://vimeo.com/19940853 is 19940853', 'TemplateCore')
		),
		'width' 	=> array(
			'std' 	=> '700',
			'type' 	=> 'text',
			'label' => __('Player Width', 'TemplateCore'),
			'desc' 	=> __('Enter only number in pixels. Ex: 700', 'TemplateCore')
		),
		'height' 	=> array(
			'std' 	=> '350',
			'type' 	=> 'text',
			'label' => __('Player Height', 'TemplateCore'),
			'desc' 	=> __('Enter only number in pixels. Ex: 350', 'TemplateCore'),
		),
		'auto_play' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Autoplay', 'TemplateCore'),
			'desc' 		=> __('Select to autoplay the video', 'TemplateCore'),
			'options' 	=> array(
				'no' 	=> 'No',
				'yes'	=> 'Yes'				
			)
		),
		'color' 	=> array(
			'type' 	=> 'colorpicker',
			'std' 	=> '#00adef',
			'label' => __('Color', 'TemplateCore'),
			'desc' 	=> __('Select the color for video controls', 'TemplateCore')
		),
		'show_title' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Show Title', 'TemplateCore'),
			'desc' 		=> __('Select to show title in video', 'TemplateCore'),
			'options' 	=> array(				
				'yes'	=> 'Yes',
				'no' 	=> 'No'				
			)
		),
		'show_byline' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Show Byline', 'TemplateCore'),
			'desc' 		=> __('Select to show user byline in video', 'TemplateCore'),
			'options' 	=> array(				
				'yes'	=> 'Yes',
				'no' 	=> 'No'				
			)
		),
	),
	'shortcode' 	=> '[tpath_vimeo id="{{player_id}}" width="{{width}}" height="{{height}}" autoplay="{{auto_play}}" color="{{color}}" show_title="{{show_title}}" show_byline="{{show_byline}}"]',
	'popup_title' 	=> __( 'Vimeo Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Youtube Config
 * ============================================================= */

$tpath_shortcodes['youtube'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'player_id' => array(
			'std' 	=> '',
			'type' 	=> 'text',
			'label' => __('Video ID', 'TemplateCore'),
			'desc' 	=> __('For example the Video ID for <br />http://www.youtube.com/R4-YdC5N6Lo is R4-YdC5N6Lo', 'TemplateCore')
		),
		'width' 	=> array(
			'std' 	=> '700',
			'type' 	=> 'text',
			'label' => __('Player Width', 'TemplateCore'),
			'desc' 	=> __('Enter only number in pixels. Ex: 700', 'TemplateCore')
		),
		'height' 	=> array(
			'std' 	=> '350',
			'type' 	=> 'text',
			'label' => __('Player Height', 'TemplateCore'),
			'desc' 	=> __('Enter only number in pixels. Ex: 350', 'TemplateCore'),
		),
		'auto_play' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Autoplay', 'TemplateCore'),
			'desc' 		=> __('Select to autoplay the video', 'TemplateCore'),
			'options' 	=> array(
				'no' 	=> 'No',
				'yes'	=> 'Yes'				
			)
		),
		'related' 		=> array(
			'type' 		=> 'select',
			'label' 	=> __('Related Videos', 'TemplateCore'),
			'desc' 		=> __('Select to show related videos', 'TemplateCore'),
			'options' 	=> array(
				'no' 	=> 'No',
				'yes'	=> 'Yes'				
			)
		),
	),
	'shortcode' 	=> '[tpath_youtube id="{{player_id}}" width="{{width}}" height="{{height}}" autoplay="{{auto_play}}" rel_video="{{related}}"]',
	'popup_title' 	=> __( 'Youtube Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Testimonials Config
 * ============================================================= */

$tpath_shortcodes['testimonials'] = array(
	'no_preview' => true,
	'params' 	 => array(		
		'category' 	 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Select Testimonial Categories', 'TemplateCore'),
			'desc' 		=> '',
			'options' 	=> tpath_taxonomy_term_list('testimonial_categories', 'tpath_testimonial', 'Select Categories')
		),
		'show_navigation' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Navigation', 'TemplateCore'),
			'desc' 		=> __('Select to show/hide navigation in Testimonial slider', 'TemplateCore'),
			'options' 	=> array(
				'yes'	=> 'Yes',
				'no' 	=> 'No',
			)
		),
		'style' 	=> array(
			'type' 	=> 'select',
			'label' => __('Testimonial Display Style', 'TemplateCore'),
			'desc' 	=> __('Select Testimonial Display Style', 'TemplateCore'),
			'options' 		=> array(
				'slider'	=> 'Slider',
				'list'		=> 'List',
			)
		),
	),
	'shortcode' 	=> '[tpath_testimonials category="{{category}}" show_navigation="{{show_navigation}}" style="{{style}}"]',
	'popup_title' 	=> __( 'Testimonials Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Blog Config
 * ============================================================= */

$tpath_shortcodes['blog'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'blog_layout' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Blog Layout', 'TemplateCore'),
			'desc' 		=> __('Select the layout for the blog posts', 'TemplateCore'),
			'options' 	=> array(
				'large' 	=> 'List Posts',					
				'grid' 		=> 'Grid Posts',				
			)
		),
		'posts_count' 	=> array(
			'std' 		=> '',
			'type' 		=> 'text',
			'label' 	=> __('Posts per Page', 'TemplateCore'),
			'desc' 		=> __('Enter number of posts per page. -1 represents all posts to show.', 'TemplateCore')			
		),
		'category' 	 	=> array(
			'type' 		=> 'multiselect',
			'label' 	=> __('Select Categories', 'TemplateCore'),
			'options' 	=> tpath_taxonomy_term_list('category', 'post', 'All Categories')
		),
		'show_title' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Title', 'TemplateCore'),
			'desc' 		=> __('Select to show/hide the post title', 'TemplateCore'),
			'options' 	=> array(
				'yes'	=> 'Yes',
				'no' 	=> 'No',
			)
		),
		'show_thumb' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Thumbnail', 'TemplateCore'),
			'desc' 		=> __('Select to show/hide the post featured image', 'TemplateCore'),
			'options' 	=> array(
				'yes'	=> 'Yes',
				'no' 	=> 'No',
			)
		),
		'show_content' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Show Excerpt/Content', 'TemplateCore'),
			'desc' 		=> __('Select to show excerpt or full content or hide content', 'TemplateCore'),
			'options' 	=> array(
				'excerpt'	=> 'Excerpt',
				'content' 	=> 'Full Content',
				'none' 		=> 'No Content',
			)
		),
		'hide_meta_author' 	=> array(
			'type' 			=> 'select',
			'label' 		=> __('Disable Post Meta Author Name', 'TemplateCore'),
			'desc' 			=> __('Select to hide the author', 'TemplateCore'),
			'options' 		=> array(
				'no' 	=> 'No',
				'yes'	=> 'Yes',				
			)
		),
		'hide_meta_date' 	=> array(
			'type' 			=> 'select',
			'label' 		=> __('Disable Post Meta Date', 'TemplateCore'),
			'desc' 			=> __('Select to hide the date', 'TemplateCore'),
			'options' 		=> array(
				'no' 	=> 'No',
				'yes'	=> 'Yes',				
			)
		),
		'hide_meta_categories' 	=> array(
			'type' 				=> 'select',
			'label' 			=> __('Disable Post Meta Categories', 'TemplateCore'),
			'desc' 				=> __('Select to hide the categories', 'TemplateCore'),
			'options' 			=> array(
				'no' 		=> 'No',
				'yes'		=> 'Yes',				
			)
		),
		'hide_meta_comments' 	=> array(
			'type' 				=> 'select',
			'label' 			=> __('Disable Post Meta Comments Count', 'TemplateCore'),
			'desc' 				=> __('Select to hide the comments count', 'TemplateCore'),
			'options' 			=> array(
				'no' 		=> 'No',
				'yes'		=> 'Yes',				
			)
		),		
		'hide_meta_link' 	=> array(
			'type' 			=> 'select',
			'label' 		=> __('Disable Read More Link', 'TemplateCore'),
			'desc' 			=> __('Select to hide the read more link', 'TemplateCore'),
			'options' 		=> array(
				'no' 	=> 'No',
				'yes'	=> 'Yes',
			)
		),		
		'pagination' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Pagination', 'TemplateCore'),
			'desc' 		=> __('Select the type of pagination for posts', 'TemplateCore'),
			'options' 	=> array(
				'pagination' 	=> 'Pagination',
				'infinite' 		=> 'Infinite Scroll'
			)
		),
		'grid_columns' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Number of Columns for Grid Layout', 'TemplateCore'),
			'desc' 		=> __('Choose number of columns for Grid layout.', 'TemplateCore'),
			'options' 	=> array(
				'two' 		=> '2',
				'three' 	=> '3',
				'four' 		=> '4'
			)
		),
		'grid_color' => array(
			'std' 	=> '',
			'type' 	=> 'colorpicker',			
			'label' => __('Grid Background Color', 'TemplateCore'),
			'desc' 	=> __('Grid Background Color.', 'TemplateCore'),
		),		
	),
	'shortcode' 	=> '[tpath_blog layout="{{blog_layout}}" posts="{{posts_count}}" categories="{{category}}" title="{{show_title}}" thumbnail="{{show_thumb}}" content="{{show_content}}" hide_author="{{hide_meta_author}}" hide_date="{{hide_meta_date}}" hide_categories="{{hide_meta_categories}}" hide_comments="{{hide_meta_comments}}" hide_morelink="{{hide_meta_link}}" pagination="{{pagination}}" grid_columns="{{grid_columns}}" grid_color="{{grid_color}}"]',
	'popup_title' 	=> __( 'Blog Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Text Slider Config
 * ============================================================= */
 
$tpath_shortcodes['textslider'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'direction' => array(
			'std' 	=> 'up',
			'label' => __('Select Direction', 'TemplateCore'),
			'desc' 	=> __('Select slider direction', 'TemplateCore'),
			'type' 	=> 'select',
			'options' 	=> array(
				'up'	=> 'Up', 
				'down'	=> 'Down'
			)    			
		),
		'interval' => array(
			'std' 	=> '4000',
			'label' => __('Slider Interval', 'TemplateCore'),
			'desc' 	=> __('Enter Interval in milliseconds. Ex: 4000', 'TemplateCore'),
			'type' 	=> 'text'			
		),
		'color' => array(
			'std' 	=> '',
			'label' => __('Text Color', 'TemplateCore'),
			'desc' 	=> __('Select text color', 'TemplateCore'),
			'type' 	=> 'colorpicker'			
		),		
	),
	'child_shortcode' => array(
		'params' 	  => array(
			'content' => array(
				'std' 	=> 'Your Content!',
				'label' => __('Slider Content', 'TemplateCore'),
				'desc' 	=> __('Enter Slider Content', 'TemplateCore'),
				'type' 	=> 'textarea'			
			),		
		),
		'shortcode' 	=> '[tpath_text_item]{{content}}[/tpath_text_item]',
		'clone_button'  => __('Add New Slider Item', 'TemplateCore')				
	),
	'shortcode' 	=> '[tpath_text_slider direction="{{direction}}" interval="{{interval}}" color="{{color}}"]{{child_shortcode}}[/tpath_text_slider]',
	'popup_title' 	=> __( 'Insert Text Slider Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Services List Config
 * ============================================================= */
 
$tpath_shortcodes['serviceslist'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'icon_size'  => array(
			'std'	=> '',
			'type' 	=> 'text',
			'label' => __('Icon Size', 'TemplateCore'),
			'desc'  => __('Enter Icon Size.', 'TemplateCore'),
		),
		'icon_color' => array(
			'std' 	=> '',
			'type'  => 'colorpicker',			
			'label' => __('Icon Color', 'TemplateCore'),
			'desc' 	=> __('Choose Icon Color.', 'TemplateCore'),
		),
		'title_color' => array(
			'std'	=> '',
			'type' 	=> 'colorpicker',			
			'label'	=> __('Title Color', 'TemplateCore'),
			'desc' 	=> __('Choose Title Color.', 'TemplateCore'),
		),
		'desc_color'  => array(
			'std' 	=> '',
			'type'	=> 'colorpicker',			
			'label'	=> __('Description Color', 'TemplateCore'),
			'desc'	=> __('Choose Description Color.', 'TemplateCore'),
		),
		'extra_class'  => array(
			'std'	=> '',
			'type' 	=> 'text',			
			'label' => __('Extra Class', 'TemplateCore'),
			'desc'  => __('Enter extra class for container.', 'TemplateCore'),
		),
	),
	'child_shortcode' => array(
		'params' 	  => array(
			'column' => array(
				'type' 		=> 'select',
				'std'		=> '',
				'label' 	=> __('Column Size', 'TemplateCore'),
				'desc' 		=> __('Select the width of the column.', 'TemplateCore'),
				'options' 	=> array(					
					'3' 	=> 'Size 3 (25%)',
					'4' 	=> 'Size 4 (33.33%)',
					'5' 	=> 'Size 5 (41.67%)',
					'6' 	=> 'Size 6 (50%)',
					'7' 	=> 'Size 7 (58.33%)',
					'8' 	=> 'Size 8 (66.67%)',
					'9' 	=> 'Size 9 (75%)',
					'10' 	=> 'Size 10 (83.33%)',
					'11' 	=> 'Size 11 (91.67%)',
					'12' 	=> 'Size 12 (100%)'
				)
			),					
			'title' 	=> array(
				'std'	=> '',
				'type'	=> 'text',
				'label'	=> __('Title', 'TemplateCore'),
				'desc'	=> __('Enter the title for services.', 'TemplateCore')
			),				
			'faicon'	=> array(
				'type' 		=> 'iconpicker',
				'std'		=> '',
				'label' 	=> __('Select Icon', 'TemplateCore'),
				'desc' 		=> __('Click an icon to select, click again to deselect', 'TemplateCore'),
				'options' 	=> $icons			
			),
			'content' => array(
				'std' 	=> 'Your Content !',
				'type' 	=> 'textarea',
				'label' => __( 'Content', 'TemplateCore' ),
				'desc' 	=> __( 'Enter the description for services.', 'TemplateCore' ),
			),
			'btn_text'	=> array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Button Text', 'TemplateCore'),
				'desc' 	=> __('Enter the button text.', 'TemplateCore')
			),
			'btn_url'	=> array(
				'std' 	=> '',
				'type' 	=> 'text',
				'label' => __('Button URL', 'TemplateCore'),
				'desc' 	=> __('Add the button\'s url. Ex: http://example.com', 'TemplateCore')
			),
			'style'	=> array(
				'type' 		=> 'select',
				'std'		=> '',
				'label' 	=> __('Button Style', 'TemplateCore'),
				'desc' 		=> __('Select the button\'s color', 'TemplateCore'),
				'options' 	=> array(
					'default'		=> 'Default',
					'inverse' 		=> 'Black',
					'primary' 		=> 'Blue',
					'custom' 		=> 'Custom',
					'border' 		=> 'Border',
					'transparent' 	=> 'Transparent',
					'info' 			=> 'Light Blue',
					'success' 		=> 'Green',
					'warning' 		=> 'Orange',
					'danger' 		=> 'Red',
				)
			),
			'size' => array(
				'type' 		=> 'select',
				'std'		=> '',
				'label' 	=> __('Button Size', 'TemplateCore'),
				'desc' 		=> __('Select the button\'s size', 'TemplateCore'),
				'options' 	=> array(
					'default' 	=> 'Default',				
					'mini'		=> 'Extra Small',
					'small'		=> 'Small',
					'large' 	=> 'Large'
				)
			),
			'target' => array(
				'type' 		=> 'select',
				'std'		=> '',
				'label' 	=> __('Button Target', 'TemplateCore'),
				'desc' 		=> __('_self = open in same window. <br /> _blank = open in new window', 'TemplateCore'),
				'options' 	=> array(
					'_self' 	=> '_self',
					'_blank' 	=> '_blank'
				)
			),
			'animation_type' => array(			
				'type' 		=> 'select',
				'std'		=> '',
				'label' 	=> __('Animation Type', 'TemplateCore'),
				'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
				'options'	=> $animations
			),
			'animation_delay' => array(
				'std' 		=> '500',
				'type' 		=> 'text',
				'label' 	=> __('Animation Delay', 'TemplateCore'),
				'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
			),
		),
		'shortcode' 	=> '[tpath_services_item column="{{column}}" title="{{title}}" faicon="{{faicon}}" btn_text="{{btn_text}}" button_url="{{btn_url}}" button_style="{{style}}" button_size="{{size}}" target="{{target}}" animation_type="{{animation_type}}" animation_delay="{{animation_delay}}"]{{content}}[/tpath_services_item]',
		'clone_button'  => __('Add New Services Item', 'TemplateCore')				
	),
	'shortcode' 	=> '[tpath_services icon_size="{{icon_size}}" icon_color="{{icon_color}}" title_color="{{title_color}}" desc_color="{{desc_color}}" extra_class="{{extra_class}}"]{{child_shortcode}}[/tpath_services]',
	'popup_title' 	=> __( 'Insert Services Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	HTML Block Config
 * ============================================================= */
 
$tpath_shortcodes['html_block'] = array(
	'no_preview' => true,
	'params' 	 => array(		
		'tag' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('HTML Tag', 'TemplateCore'),
			'desc' 		=> __('Choose HTML tag to insert.', 'TemplateCore'),
			'options' 	=> array(
				'div'    	=> 'div',
				'section'   => 'section',
				'p'   		=> 'p',
				'span'   	=> 'span',
			)
		),
		'class' => array(
			'std'		=> '',
			'type'		=> 'text',
			'label'  	=> __('Class', 'TemplateCore'),
			'desc'   	=> __('Enter class name for HTML tag.', 'TemplateCore')
		),
		'content' => array(
			'std' 	=> 'Your Content!',
			'label' => __('Content', 'TemplateCore'),
			'desc' 	=> __('Enter Content', 'TemplateCore'),
			'type' 	=> 'textarea'			
		),
	),
	'shortcode' 	=> '[tpath_html_block tag="{{tag}}" class="{{class}}"]{{content}}[/tpath_html_block]',
	'popup_title' 	=> __( 'HTML Block Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Background Video Config
 * ============================================================= */
 
$tpath_shortcodes['bg_video'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'video_id' => array(
			'std'		=> '',
			'type'		=> 'text',
			'label'  	=> __('Video ID', 'TemplateCore'),
			'desc'   	=> __('For example the Video ID for <br />http://www.youtube.com/vdRqcPyB1gw is vdRqcPyB1gw', 'TemplateCore')
		),
		'autoPlay' 	=> array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Auto play', 'TemplateCore'),
			'desc' 		=> __('Select to auto play the Video.', 'TemplateCore'),
			'options' 	=> array(
				'true'    => 'Yes',
				'false'   => 'No',
			)			
		),
		'screen_height' => array(
			'std'		=> '',
			'type'		=> 'text',
			'label'  	=> __('Video Screen Height', 'TemplateCore'),
			'desc'   	=> __('Enter the video screen height. Only numbers. Ex: 510', 'TemplateCore')
		),
		'image' => array(
			'type' 	=> 'media',
			'std'	=> '',
			'label' => __('Video Fallback Image', 'TemplateCore'),
			'desc' 	=> __('Upload the Video Fallback Image.', 'TemplateCore')
		),
		'showControls' 	=> array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Show Controls', 'TemplateCore'),
			'desc' 		=> __('Select to Show Controls on player.', 'TemplateCore'),
			'options' 	=> array(
				'false'   => 'No',
				'true'    => 'Yes',
			)
		),
		'mute' 		=> array(
			'type' 		=> 'select',
			'std'		=> '',
			'label' 	=> __('Video Mute', 'TemplateCore'),
			'desc' 		=> __('Select to Video Mute.', 'TemplateCore'),
			'options' 	=> array(
				'false'   => 'No',
				'true'    => 'Yes',
			)
		),
	),
	'shortcode' 	=> '[tpath_bg_video video_id="{{video_id}}" autoplay="{{autoPlay}}" screen_height="{{screen_height}}" fallback="{{image}}" controls="{{showControls}}" mute="{{mute}}"][/tpath_bg_video]',
	'popup_title' 	=> __( 'Background Video Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Contact Form Config
 * ============================================================= */
 
$tpath_shortcodes['contact_form'] = array(
	'no_preview' => true,
	'params' 	 => array(
		'form' => array(
			'type' 		=> 'select',
			'label' 	=> __('Show Contact Form', 'TemplateCore'),
			'desc' 		=> __('Check to Show Contact Form', 'TemplateCore'),
			'options' 	=> array(
					'on'	 => 'Yes',
					'off'	 => 'No',
			)
		),
		'form_align' => array(
			'type' 		=> 'select',
			'label' 	=> __('Form Center', 'TemplateCore'),
			'desc' 		=> __('Choose to Show Form Centered Align', 'TemplateCore'),
			'options' 	=> array(
					'on'	 => 'Yes',
					'off'	 => 'No',
			)
		),
		'info' => array(
			'type' 		=> 'select',
			'label' 	=> __('Show Contact Information', 'TemplateCore'),
			'desc' 		=> __('Check to Show Contact Information', 'TemplateCore'),
			'options' 	=> array(
					'on'	 => 'Yes',
					'off'	 => 'No',
			)
		),
		'btn_text' => array(
			'std'		=> '',
			'type'		=> 'text',
			'label'  	=> __('Submit Button Text', 'TemplateCore'),
			'desc'   	=> __('Enter Submit Button Text.', 'TemplateCore')
		),
	),
	'shortcode' 	=> '[tpath_contact_form form="{{form}}" form_align="{{form_align}}" info="{{info}}" btn_text="{{btn_text}}"]',
	'popup_title' 	=> __( 'Contact Form Shortcode', 'TemplateCore' )
);

/* =============================================================
 *	Team Member Config
 * ============================================================= */

$tpath_shortcodes['teammember'] = array(
	'no_preview' => true,
	'params' 	 => array(		
		'category' 	 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Select Team Member Categories', 'TemplateCore'),
			'options' 	=> tpath_taxonomy_term_list('team_member_categories', 'tpath_team_member', 'Select Categories'),
			'desc' 		=> __('Choose Team Member Categories to display posts from it categories.', 'TemplateCore')
		),
		'number_of_items' 	=> array(
			'std' 		=> '3',
			'type' 		=> 'text',
			'label' 	=> __('Number Of Items In Desktop View', 'TemplateCore'),
			'desc' 		=> __('Enter Number of items to show in desktop view', 'TemplateCore')
		),
		'number_of_items_dksmall' => array(
			'std' 		=> '3',
			'type' 		=> 'text',
			'label' 	=> __('Number Of Items In Desktop Small View ( Between 980px and 769px )', 'TemplateCore'),
			'desc' 		=> __('Enter Number of items to show in desktop small view', 'TemplateCore')
		),
		'number_of_items_tablet' => array(
			'std' 		=> '2',
			'type' 		=> 'text',
			'label' 	=> __('Number Of Items In Tablet View ( Between 768px and 479px )', 'TemplateCore'),
			'desc' 		=> __('Enter Number of items to show in tablet view', 'TemplateCore')
		),
		'number_of_items_mobile' => array(
			'std' 		=> '1',
			'type' 		=> 'text',
			'label' 	=> __('Number Of Items In Mobile ( 480px )', 'TemplateCore'),
			'desc' 		=> __('Enter Number of items to show in mobile', 'TemplateCore')
		),
		'navigation' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Enable Navigation', 'TemplateCore'),
			'desc' 		=> __('Select to enable navigation for slider', 'TemplateCore'),
			'options' 	=> array(
				'false' => 'No',
				'true'	=> 'Yes',				
			)
		),
		'pagination' 	=> array(
			'type' 		=> 'select',
			'label' 	=> __('Enable Pagination', 'TemplateCore'),
			'desc' 		=> __('Select to enable pagination for slider', 'TemplateCore'),
			'options' 	=> array(
				'false' => 'No',
				'true'	=> 'Yes',				
			)
		),		
		'animation_type' => array(			
			'type' 		=> 'select',
			'label' 	=> __('Animation Type', 'TemplateCore'),
			'desc'		=> __('Select the animation type for shortcode', 'TemplateCore'),
			'options'	=> $animations
		),
		'animation_delay' => array(
			'std' 		=> '500',
			'type' 		=> 'text',
			'label' 	=> __('Animation Delay', 'TemplateCore'),
			'desc' 		=> __('Enter animation delay in milliseconds. Ex: 500', 'TemplateCore'),
		),
	),

	'shortcode' 	=> '[tpath_team_member category="{{category}}" items="{{number_of_items}}" itemsdesktopsmall="{{number_of_items_dksmall}}" itemstablet="{{number_of_items_tablet}}" itemsmobile="{{number_of_items_mobile}}" navigation="{{navigation}}" pagination="{{pagination}}" animation_type="{{animation_type}}"  animation_delay="{{animation_delay}}"]',
	'popup_title' 	=> __( 'Team Member Shortcode', 'TemplateCore' )
);
?>