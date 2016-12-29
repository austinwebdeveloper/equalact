<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 			=> "placebo", //REQUIRED!
				"banner_image"		=> "Banner Image",		
				"show_portfolio"	=> "Portfolio",
				"show_testimonials"	=> "Testimonials",
				"show_pricing_tb"	=> "Pricing Table",
			), 
			"enabled" => array (
				"placebo" 			=> "placebo", //REQUIRED!
				"slider"			=> "Slider",
				"show_products"		=> "Products",
				"show_services"		=> "Services",
				"show_newsletter"	=> "Newsletter",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = TEMPLATETHEME_COLOR_SCHEMES;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		            	natsort($bg_images); //Sorts the array into a natural order
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 
		
		// Google Fonts Latest List		
		$google_fonts_array = array(
            	"none" 				=> "Select Font",
            	"ABeeZee" 			=> "ABeeZee",
            	"Abel" 				=> "Abel",
				"Abril Fatface" 	=> "Abril Fatface",
				"Aclonica" 			=> "Aclonica",
				"Acme" 				=> "Acme",
            	"Actor" 			=> "Actor",
				"Adamina" 			=> "Adamina",
				"Advent Pro" 		=> "Advent Pro",
				"Aguafina Script" 	=> "Aguafina Script",
				"Akronim" 			=> "Akronim",
				"Aladin" 			=> "Aladin",
				"Aldrich" 			=> "Aldrich",
				"Alef" 				=> "Alef",
				"Alegreya" 			=> "Alegreya",
				"Alegreya SC" 		=> "Alegreya SC",
				"Alegreya Sans" 	=> "Alegreya Sans",
				"Alegreya Sans SC" 	=> "Alegreya Sans SC",
            	"Alex Brush" 		=> "Alex Brush",
            	"Alfa Slab One" 	=> "Alfa Slab One",
				"Alice" 			=> "Alice",
				"Alike" 			=> "Alike",
				"Alike Angular" 	=> "Alike Angular",
				"Allan" 			=> "Allan",
				"Allerta" 			=> "Allerta",
				"Allerta Stencil"	=> "Allerta Stencil",
				"Allura" 			=> "Allura",
				"Almendra" 			=> "Almendra",
            	"Almendra Display" 	=> "Almendra Display",
            	"Almendra SC" 		=> "Almendra SC",
            	"Amarante" 			=> "Amarante",
				"Amaranth" 			=> "Amaranth",
				"Amatic SC" 		=> "Amatic SC",
            	"Amethysta" 		=> "Amethysta",
            	"Anaheim" 			=> "Anaheim",
            	"Andada" 			=> "Andada",
            	"Andika" 			=> "Andika",            	
            	"Annie Use Your Telescope" => "Annie Use Your Telescope",
            	"Anonymous Pro" 	=> "Anonymous Pro",
            	"Antic" 			=> "Antic",
            	"Antic Didone" 		=> "Antic Didone",
            	"Antic Slab" 		=> "Antic Slab",
            	"Anton" 			=> "Anton",
            	"Arapey" 			=> "Arapey",
            	"Arbutus" 			=> "Arbutus",
            	"Arbutus Slab" 		=> "Arbutus Slab",
            	"Architects Daughter" => "Architects Daughter",
            	"Archivo Black" 	=> "Archivo Black",
            	"Archivo Narrow" 	=> "Archivo Narrow",
            	"Arimo" 			=> "Arimo",
            	"Arizonia" 			=> "Arizonia",
            	"Armata" 			=> "Armata",
            	"Artifika" 			=> "Artifika",
				"Arvo" 				=> "Arvo",
				"Asap" 				=> "Asap",
				"Asset" 			=> "Asset",
				"Astloch" 			=> "Astloch",
				"Asul" 				=> "Asul",
				"Atomic Age" 		=> "Atomic Age",
				"Aubrey" 			=> "Aubrey",
				"Audiowide" 		=> "Audiowide",
            	"Autour One" 		=> "Autour One",
				"Average" 			=> "Average",
				"Average Sans" 		=> "Average Sans",
				"Averia Gruesa Libre" => "Averia Gruesa Libre",
				"Averia Libre" 		=> "Averia Libre",
				"Averia Sans Libre" => "Averia Sans Libre",
				"Averia Serif Libre" => "Averia Serif Libre",
            	"Bad Script" 		=> "Bad Script",
            	"Balthazar" 		=> "Balthazar",
            	"Bangers" 			=> "Bangers",
            	"Basic" 			=> "Basic",            	
            	"Baumans" 			=> "Baumans",            	
            	"Belgrano" 			=> "Belgrano",
            	"Belleza" 			=> "Belleza",
				"BenchNine" 		=> "BenchNine",
				"Bentham" 			=> "Bentham",
            	"Berkshire Swash" 	=> "Berkshire Swash",
				"Bevan" 			=> "Bevan",
				"Bigelow Rules" 	=> "Bigelow Rules",
				"Bigshot One" 		=> "Bigshot One",
				"Bilbo" 			=> "Bilbo",
				"Bilbo Swash Caps" 	=> "Bilbo Swash Caps",
				"Bitter" 			=> "Bitter",
				"Black Ops One" 	=> "Black Ops One",				
            	"Bonbon" 			=> "Bonbon",
				"Boogaloo" 			=> "Boogaloo",
				"Bowlby One" 		=> "Bowlby One",
            	"Bowlby One SC" 	=> "Bowlby One SC",
            	"Brawler" 			=> "Brawler",
            	"Bree Serif" 		=> "Bree Serif",
            	"Bubblegum Sans" 	=> "Bubblegum Sans",
            	"Bubbler One" 		=> "Bubbler One",
				"Buda" 				=> "Buda",
				"Buenard" 			=> "Buenard",
            	"Butcherman" 		=> "Butcherman",
            	"Butterfly Kids" 	=> "Butterfly Kids",
            	"Cabin" 			=> "Cabin",
            	"Cabin Condensed" 	=> "Cabin Condensed",
				"Cabin Sketch" 		=> "Cabin Sketch",
				"Caesar Dressing" 	=> "Caesar Dressing",
				"Cagliostro" 		=> "Cagliostro",
				"Calligraffitti" 	=> "Calligraffitti",
				"Cambo" 			=> "Cambo",
				"Candal" 			=> "Candal",
				"Cantarell" 		=> "Cantarell",
				"Cantata One" 		=> "Cantata One",
				"Cantora One" 		=> "Cantora One",
				"Capriola" 			=> "Capriola",
				"Cardo" 			=> "Cardo",
				"Carme" 			=> "Carme",
				"Carrois Gothic" 	=> "Carrois Gothic",
				"Carrois Gothic SC" => "Carrois Gothic SC",
				"Carter One" 		=> "Carter One",
				"Caudex" 			=> "Caudex",
            	"Cedarville Cursive" => "Cedarville Cursive",
				"Ceviche One" 		=> "Ceviche One",
				"Changa One" 		=> "Changa One",
            	"Chango" 			=> "Chango",
            	"Chau Philomene One" => "Chau Philomene One",
				"Chela One" 		=> "Chela One",
				"Chelsea Market" 	=> "Chelsea Market",            	
            	"Cherry Cream Soda" => "Cherry Cream Soda",
            	"Cherry Swash" 		=> "Cherry Swash",
            	"Chewy" 			=> "Chewy",
				"Chicle" 			=> "Chicle",
				"Chivo" 			=> "Chivo",
				"Cinzel" 			=> "Cinzel",
				"Cinzel Decorative" => "Cinzel Decorative",
				"Clicker Script" 	=> "Clicker Script",
				"Coda" 				=> "Coda",
				"Coda Caption" 		=> "Coda Caption",
				"Codystar" 			=> "Codystar",
				"Combo" 			=> "Combo",
				"Comfortaa" 		=> "Comfortaa",
				"Coming Soon" 		=> "Coming Soon",
				"Concert One" 		=> "Concert One",
				"Condiment" 		=> "Condiment",            	
            	"Contrail One" 		=> "Contrail One",
            	"Convergence" 		=> "Convergence",
				"Cookie" 			=> "Cookie",
				"Copse" 			=> "Copse",
				"Corben" 			=> "Corben",
				"Courgette" 		=> "Courgette",
            	"Cousine" 			=> "Cousine",
            	"Coustard" 			=> "Coustard",
            	"Covered By Your Grace" => "Covered By Your Grace",
            	"Crafty Girls" 		=> "Crafty Girls",
            	"Creepster" 		=> "Creepster",
            	"Crete Round" 		=> "Crete Round",
				"Crimson Text" 		=> "Crimson Text",
				"Croissant One" 	=> "Croissant One",
				"Crushed" 			=> "Crushed",
				"Cuprum" 			=> "Cuprum",
				"Cutive" 			=> "Cutive",
				"Cutive Mono" 		=> "Cutive Mono",
            	"Damion" 			=> "Damion",
            	"Dancing Script" 	=> "Dancing Script",            	
            	"Dawning of a New Day" => "Dawning of a New Day",
            	"Days One" 			=> "Days One",
            	"Delius" 			=> "Delius",
				"Delius Swash Caps" => "Delius Swash Caps",
				"Delius Unicase" 	=> "Delius Unicase",
				"Della Respira" 	=> "Della Respira",
				"Denk One" 			=> "Denk One",
				"Devonshire" 		=> "Devonshire",
				"Didact Gothic" 	=> "Didact Gothic",
				"Diplomata" 		=> "Diplomata",
				"Diplomata SC" 		=> "Diplomata SC",
				"Domine" 			=> "Domine",
				"Donegal One" 		=> "Donegal One",
				"Doppio One" 		=> "Doppio One",
				"Dorsa" 			=> "Dorsa",
				"Dosis" 			=> "Dosis",
				"Dr Sugiyama" 		=> "Dr Sugiyama",
				"Droid Sans" 		=> "Droid Sans",
				"Droid Sans Mono" 	=> "Droid Sans Mono",
				"Droid Serif" 		=> "Droid Serif",
				"Duru Sans" 		=> "Duru Sans",
            	"Dynalight" 		=> "Dynalight",
            	"EB Garamond" 		=> "EB Garamond",
            	"Eagle Lake" 		=> "Eagle Lake",
            	"Eater" 			=> "Eater",
            	"Economica" 		=> "Economica",
				"Ek Mukta" 			=> "Ek Mukta",
            	"Electrolize" 		=> "Electrolize",
            	"Elsie" 			=> "Elsie",
            	"Elsie Swash Caps" 	=> "Elsie Swash Caps",
            	"Emblema One" 		=> "Emblema One",
            	"Emilys Candy" 		=> "Emilys Candy",
            	"Engagement" 		=> "Engagement",
            	"Englebert" 		=> "Englebert",
            	"Enriqueta" 		=> "Enriqueta",
            	"Erica One" 		=> "Erica One",
            	"Esteban" 			=> "Esteban",
            	"Euphoria Script" 	=> "Euphoria Script",
            	"Ewert" 			=> "Ewert",
            	"Exo" 				=> "Exo",
            	"Exo 2" 			=> "Exo 2",
            	"Expletus Sans" 	=> "Expletus Sans",
            	"Fanwood Text" 		=> "Fanwood Text",
            	"Fascinate" 		=> "Fascinate",
            	"Fascinate Inline" 	=> "Fascinate Inline",
            	"Faster One" 		=> "Faster One",            	
            	"Fauna One" 		=> "Fauna One",
				"Federant" 			=> "Federant",
				"Federo" 			=> "Federo",
				"Felipa" 			=> "Felipa",
				"Fenix" 			=> "Fenix",
            	"Finger Paint" 		=> "Finger Paint",
				"Fira Mono" 		=> "Fira Mono",
				"Fira Sans" 		=> "Fira Sans",
            	"Fjalla One" 		=> "Fjalla One",
            	"Fjord One" 		=> "Fjord One",
            	"Flamenco" 			=> "Flamenco",
            	"Flavors" 			=> "Flavors",
            	"Fondamento" 		=> "Fondamento",
            	"Fontdiner Swanky" 	=> "Fontdiner Swanky",
            	"Forum" 			=> "Forum",
            	"Francois One" 		=> "Francois One",
            	"Freckle Face" 		=> "Freckle Face",
            	"Fredericka the Great" => "Fredericka the Great",
            	"Fredoka One" 		=> "Fredoka One",            	
            	"Fresca" 			=> "Fresca",
            	"Frijole" 			=> "Frijole",
            	"Fruktur" 			=> "Fruktur",
            	"Fugaz One" 		=> "Fugaz One",            	
            	"Gabriela" 			=> "Gabriela",
            	"Gafata" 			=> "Gafata",
            	"Galdeano" 			=> "Galdeano",
            	"Galindo" 			=> "Galindo",
            	"Gentium Basic" 	=> "Gentium Basic",
            	"Gentium Book Basic" => "Gentium Book Basic",
            	"Geo" 				=> "Geo",
            	"Geostar" 			=> "Geostar",
            	"Geostar Fill" 		=> "Geostar Fill",
            	"Germania One" 		=> "Germania One",
            	"Gilda Display" 	=> "Gilda Display",
            	"Give You Glory" 	=> "Give You Glory",
            	"Glass Antiqua" 	=> "Glass Antiqua",
            	"Glegoo" 			=> "Glegoo",
            	"Gloria Hallelujah" => "Gloria Hallelujah",
            	"Goblin One" 		=> "Goblin One",
            	"Gochi Hand" 		=> "Gochi Hand",
            	"Gorditas" 			=> "Gorditas",
            	"Goudy Bookletter 1911" => "Goudy Bookletter 1911",
            	"Graduate" 			=> "Graduate",
            	"Grand Hotel" 		=> "Grand Hotel",
				"Gravitas One" 		=> "Gravitas One",
				"Great Vibes" 		=> "Great Vibes",
            	"Griffy" 			=> "Griffy",
            	"Gruppo" 			=> "Gruppo",
            	"Gudea" 			=> "Gudea",
            	"Habibi" 			=> "Habibi",
            	"Hammersmith One" 	=> "Hammersmith One",
            	"Hanalei" 			=> "Hanalei",
				"Hanalei Fill" 		=> "Hanalei Fill",
				"Handlee" 			=> "Handlee",            	
            	"Happy Monkey" 		=> "Happy Monkey",
            	"Headland One" 		=> "Headland One",
            	"Henny Penny" 		=> "Henny Penny",
            	"Herr Von Muellerhoff" => "Herr Von Muellerhoff",
				"Hind" 				=> "Hind",
            	"Holtwood One SC" 	=> "Holtwood One SC",
            	"Homemade Apple" 	=> "Homemade Apple",
            	"Homenaje" 			=> "Homenaje",
            	"IM Fell DW Pica" 			=> "IM Fell DW Pica",
				"IM Fell DW Pica SC" 		=> "IM Fell DW Pica SC",
				"IM Fell Double Pica" 		=> "IM Fell Double Pica",
            	"IM Fell Double Pica SC" 	=> "IM Fell Double Pica SC",
            	"IM Fell English" 			=> "IM Fell English",
            	"IM Fell English SC" 		=> "IM Fell English SC",
				"IM Fell French Canon" 		=> "IM Fell French Canon",
				"IM Fell French Canon SC" 	=> "IM Fell French Canon SC",
				"IM Fell Great Primer" 		=> "IM Fell Great Primer",
				"IM Fell Great Primer SC" 	=> "IM Fell Great Primer SC",
				"Iceberg" 			=> "Iceberg",
				"Iceland" 			=> "Iceland",
				"Imprima" 			=> "Imprima",
				"Inconsolata" 		=> "Inconsolata",
				"Inder" 			=> "Inder",
				"Indie Flower" 		=> "Indie Flower",
				"Inika" 			=> "Inika",
				"Irish Grover" 		=> "Irish Grover",
				"Istok Web" 		=> "Istok Web",
				"Italiana" 			=> "Italiana",
            	"Italianno" 		=> "Italianno",
            	"Jacques Francois" 	=> "Jacques Francois",
            	"Jacques Francois Shadow" => "Jacques Francois Shadow",
            	"Jim Nightshade" 	=> "Jim Nightshade",
            	"Jockey One" 		=> "Jockey One",
            	"Jolly Lodger" 		=> "Jolly Lodger",
				"Josefin Sans" 		=> "Josefin Sans",
				"Josefin Slab" 		=> "Josefin Slab",
				"Joti One" 			=> "Joti One",
				"Judson" 			=> "Judson",
				"Julee" 			=> "Julee",
				"Julius Sans One" 	=> "Julius Sans One",
				"Junge" 			=> "Junge",
				"Jura" 				=> "Jura",
				"Just Another Hand" => "Just Another Hand",
				"Just Me Again Down Here" => "Just Me Again Down Here",
				"Kalam" 			=> "Kalam",
            	"Kameron" 			=> "Kameron",            	
            	"Karla" 			=> "Karla",
				"Karma" 			=> "Karma",
            	"Kaushan Script" 	=> "Kaushan Script",
				"Kavoon" 			=> "Kavoon",				
            	"Keania One" 		=> "Keania One",
				"Kelly Slab" 		=> "Kelly Slab",
				"Kenia" 			=> "Kenia",
				"Khand" 			=> "Khand",            	
            	"Kite One" 			=> "Kite One",
				"Knewave" 			=> "Knewave",
				"Kotta One" 		=> "Kotta One",            	
				"Kranky" 			=> "Kranky",
				"Kreon" 			=> "Kreon",
				"Kristi" 			=> "Kristi",
				"Krona One" 		=> "Krona One",
            	"La Belle Aurore" 	=> "La Belle Aurore",
				"Lancelot" 			=> "Lancelot",
				"Lato" 				=> "Lato",
				"League Script" 	=> "League Script",
				"Leckerli One" 		=> "Leckerli One",
				"Ledger" 			=> "Ledger",
				"Lekton" 			=> "Lekton",
				"Lemon" 			=> "Lemon",
				"Libre Baskerville" => "Libre Baskerville",
            	"Life Savers" 		=> "Life Savers",
            	"Lilita One" 		=> "Lilita One",
            	"Lily Script One" 	=> "Lily Script One",
            	"Limelight" 		=> "Limelight",
            	"Linden Hill" 		=> "Linden Hill",
            	"Lobster" 			=> "Lobster",
            	"Lobster Two" 		=> "Lobster Two",
            	"Londrina Outline" 	=> "Londrina Outline",
            	"Londrina Shadow" 	=> "Londrina Shadow",
            	"Londrina Sketch" 	=> "Londrina Sketch",
            	"Londrina Solid" 	=> "Londrina Solid",
            	"Lora" 				=> "Lora",
            	"Love Ya Like A Sister" => "Love Ya Like A Sister",
            	"Loved by the King" => "Loved by the King",
            	"Lovers Quarrel" 	=> "Lovers Quarrel",
            	"Luckiest Guy" 		=> "Luckiest Guy",
            	"Lusitana" 			=> "Lusitana",
            	"Lustria" 			=> "Lustria",
            	"Macondo" 			=> "Macondo",
            	"Macondo Swash Caps" => "Macondo Swash Caps",
            	"Magra" 			=> "Magra",
            	"Maiden Orange" 	=> "Maiden Orange",
            	"Mako" 				=> "Mako",
            	"Marcellus" 		=> "Marcellus",
            	"Marcellus SC" 		=> "Marcellus SC",
            	"Marck Script" 		=> "Marck Script",
            	"Margarine" 		=> "Margarine",
            	"Marko One" 		=> "Marko One",
            	"Marmelad" 			=> "Marmelad",
				"Marvel" 			=> "Marvel",
				"Mate" 				=> "Mate",
				"Mate SC" 			=> "Mate SC",
				"Maven Pro" 		=> "Maven Pro",
				"McLaren" 			=> "McLaren",
				"Meddon" 			=> "Meddon",
				"MedievalSharp" 	=> "MedievalSharp",
				"Medula One" 		=> "Medula One",
            	"Megrim" 			=> "Megrim",
            	"Meie Script" 		=> "Meie Script",
            	"Merienda" 			=> "Merienda",
            	"Merienda One" 		=> "Merienda One",
            	"Merriweather" 		=> "Merriweather",
				"Merriweather Sans" => "Merriweather Sans",				
            	"Metal Mania" 		=> "Metal Mania",
            	"Metamorphous" 		=> "Metamorphous",
            	"Metrophobic" 		=> "Metrophobic",
            	"Michroma" 			=> "Michroma",
            	"Milonga" 			=> "Milonga",
            	"Miltonian" 		=> "Miltonian",
				"Miltonian Tattoo" 	=> "Miltonian Tattoo",
				"Miniver" 			=> "Miniver",
				"Miss Fajardose" 	=> "Miss Fajardose",
				"Modern Antiqua" 	=> "Modern Antiqua",
				"Molengo" 			=> "Molengo",
				"Molle" 			=> "Molle",
				"Monda" 			=> "Monda",
				"Monofett" 			=> "Monofett",
				"Monoton" 			=> "Monoton",
				"Monsieur La Doulaise" => "Monsieur La Doulaise",
				"Montaga" 			=> "Montaga",
				"Montez" 			=> "Montez",
				"Montserrat" 		=> "Montserrat",
				"Montserrat Alternates" => "Montserrat Alternates",
            	"Montserrat Subrayada" => "Montserrat Subrayada",            	
            	"Mountains of Christmas" => "Mountains of Christmas",
				"Mouse Memoirs" 	=> "Mouse Memoirs",
				"Mr Bedfort" 		=> "Mr Bedfort",
				"Mr Dafoe" 			=> "Mr Dafoe",
				"Mr De Haviland" 	=> "Mr De Haviland",
				"Mrs Saint Delafield" => "Mrs Saint Delafield",
				"Mrs Sheppards" 	=> "Mrs Sheppards",
				"Muli" 				=> "Muli",
				"Mystery Quest" 	=> "Mystery Quest",
            	"Neucha" 			=> "Neucha",
				"Neuton" 			=> "Neuton",
				"New Rocker" 		=> "New Rocker",
				"News Cycle" 		=> "News Cycle",
				"Niconne" 			=> "Niconne",
				"Nixie One" 		=> "Nixie One",
				"Nobile" 			=> "Nobile",            	
				"Norican" 			=> "Norican",
				"Nosifer" 			=> "Nosifer",
				"Nothing You Could Do" => "Nothing You Could Do",
				"Noticia Text" 		=> "Noticia Text",
				"Noto Sans" 		=> "Noto Sans",
				"Noto Serif" 		=> "Noto Serif",
				"Nova Cut" 			=> "Nova Cut",
				"Nova Flat" 		=> "Nova Flat",
				"Nova Mono" 		=> "Nova Mono",
				"Nova Oval" 		=> "Nova Oval",
				"Nova Round" 		=> "Nova Round",
				"Nova Script" 		=> "Nova Script",
				"Nova Slim" 		=> "Nova Slim",
				"Nova Square" 		=> "Nova Square",
            	"Numans" 			=> "Numans",
            	"Nunito" 			=> "Nunito",            	
            	"Offside" 			=> "Offside",
				"Old Standard TT" 	=> "Old Standard TT",
				"Oldenburg" 		=> "Oldenburg",
				"Oleo Script" 		=> "Oleo Script",
				"Oleo Script Swash Caps" => "Oleo Script Swash Caps",
				"Open Sans" 		=> "Open Sans",
				"Open Sans Condensed" => "Open Sans Condensed",
				"Oranienbaum" 		=> "Oranienbaum",
				"Orbitron" 			=> "Orbitron",
				"Oregano" 			=> "Oregano",
				"Orienta" 			=> "Orienta",
				"Original Surfer" 	=> "Original Surfer",
				"Oswald" 			=> "Oswald",
            	"Over the Rainbow" 	=> "Over the Rainbow",
            	"Overlock" 			=> "Overlock",
				"Overlock SC" 		=> "Overlock SC",
				"Ovo" 				=> "Ovo",
				"Oxygen" 			=> "Oxygen",
				"Oxygen Mono" 		=> "Oxygen Mono",
            	"PT Mono" 			=> "PT Mono",
				"PT Sans" 			=> "PT Sans",
				"PT Sans Caption" 	=> "PT Sans Caption",
				"PT Sans Narrow" 	=> "PT Sans Narrow",
				"PT Serif" 			=> "PT Serif",
				"PT Serif Caption" 	=> "PT Serif Caption",
				"Pacifico" 			=> "Pacifico",
				"Paprika" 			=> "Paprika",
				"Parisienne" 		=> "Parisienne",
				"Passero One" 		=> "Passero One",
				"Passion One" 		=> "Passion One",
				"Pathway Gothic One" => "Pathway Gothic One",
				"Patrick Hand" 		=> "Patrick Hand",
				"Patrick Hand SC" 	=> "Patrick Hand SC",
            	"Patua One" 		=> "Patua One",
            	"Paytone One" 		=> "Paytone One",
				"Peralta" 			=> "Peralta",
				"Permanent Marker" 	=> "Permanent Marker",
				"Petit Formal Script" => "Petit Formal Script",
				"Petrona" 			=> "Petrona",
				"Philosopher" 		=> "Philosopher",
				"Piedra" 			=> "Piedra",
				"Pinyon Script" 	=> "Pinyon Script",
				"Pirata One" 		=> "Pirata One",
            	"Plaster" 			=> "Plaster",
            	"Play" 				=> "Play",
            	"Playball" 			=> "Playball",
            	"Playfair Display" 	=> "Playfair Display",
            	"Playfair Display SC" => "Playfair Display SC",
            	"Podkova" 			=> "Podkova",
            	"Poiret One" 		=> "Poiret One",
            	"Poller One" 		=> "Poller One",
				"Poly" 				=> "Poly",
				"Pompiere" 			=> "Pompiere",
            	"Pontano Sans" 		=> "Pontano Sans",
            	"Port Lligat Sans" 	=> "Port Lligat Sans",
            	"Port Lligat Slab" 	=> "Port Lligat Slab",
            	"Prata" 			=> "Prata",            	
            	"Press Start 2P" 	=> "Press Start 2P",
            	"Princess Sofia" 	=> "Princess Sofia",
            	"Prociono" 			=> "Prociono",
            	"Prosto One" 		=> "Prosto One",
            	"Puritan" 			=> "Puritan",
            	"Purple Purse" 		=> "Purple Purse",
            	"Quando" 			=> "Quando",
				"Quantico" 			=> "Quantico",
				"Quattrocento" 		=> "Quattrocento",
				"Quattrocento Sans" => "Quattrocento Sans",
				"Questrial" 		=> "Questrial",
            	"Quicksand" 		=> "Quicksand",
            	"Quintessential" 	=> "Quintessential",
            	"Qwigley" 			=> "Qwigley",
            	"Racing Sans One" 	=> "Racing Sans One",
            	"Radley" 			=> "Radley",
				"Rajdhani" 			=> "Rajdhani",
            	"Raleway" 			=> "Raleway",
            	"Raleway Dots" 		=> "Raleway Dots",
            	"Rambla" 			=> "Rambla",
            	"Rammetto One" 		=> "Rammetto One",
            	"Ranchers" 			=> "Ranchers",
            	"Rancho" 			=> "Rancho",
            	"Rationale" 		=> "Rationale",
            	"Redressed" 		=> "Redressed",
            	"Reenie Beanie" 	=> "Reenie Beanie",
            	"Revalia" 			=> "Revalia",
				"Ribeye" 			=> "Ribeye",
				"Ribeye Marrow" 	=> "Ribeye Marrow",
            	"Righteous" 		=> "Righteous",
            	"Risque" 			=> "Risque",
				"Roboto" 			=> "Roboto",
				"Roboto Condensed" 	=> "Roboto Condensed",
				"Roboto Slab" 		=> "Roboto Slab",
				"Rochester" 		=> "Rochester",
				"Rock Salt" 		=> "Rock Salt",
				"Rokkitt" 			=> "Rokkitt",
				"Romanesco" 		=> "Romanesco",
				"Ropa Sans" 		=> "Ropa Sans",
            	"Rosario" 			=> "Rosario",
            	"Rosarivo" 			=> "Rosarivo",
            	"Rouge Script" 		=> "Rouge Script",
				"Rozha One" 		=> "Rozha One",
				"Rubik Mono One" 	=> "Rubik Mono One",
				"Rubik One" 		=> "Rubik One",
            	"Ruda" 				=> "Ruda",
            	"Rufina" 			=> "Rufina",
            	"Ruge Boogie" 		=> "Ruge Boogie",
            	"Ruluko" 			=> "Ruluko",
            	"Rum Raisin" 		=> "Rum Raisin",
            	"Ruslan Display" 	=> "Ruslan Display",
            	"Russo One" 		=> "Russo One",
            	"Ruthie" 			=> "Ruthie",
            	"Rye" 				=> "Rye",
            	"Sacramento" 		=> "Sacramento",
				"Sail" 				=> "Sail",
				"Salsa" 			=> "Salsa",
				"Sanchez" 			=> "Sanchez",
				"Sancreek" 			=> "Sancreek",
				"Sansita One" 		=> "Sansita One",
				"Sarina" 			=> "Sarina",
				"Satisfy" 			=> "Satisfy",
				"Scada" 			=> "Scada",
				"Schoolbell" 		=> "Schoolbell",
				"Seaweed Script" 	=> "Seaweed Script",
				"Sevillana" 		=> "Sevillana",
				"Seymour One" 		=> "Seymour One",
				"Shadows Into Light" => "Shadows Into Light",
				"Shadows Into Light Two" => "Shadows Into Light Two",
				"Shanti" 			=> "Shanti",
				"Share" 			=> "Share",
				"Share Tech" 		=> "Share Tech",
				"Share Tech Mono" 	=> "Share Tech Mono",
				"Shojumaru" 		=> "Shojumaru",
            	"Short Stack" 		=> "Short Stack",            	
            	"Sigmar One" 		=> "Sigmar One",
            	"Signika" 			=> "Signika",
            	"Signika Negative" 	=> "Signika Negative",
            	"Simonetta" 		=> "Simonetta",
            	"Sintony" 			=> "Sintony",
            	"Sirin Stencil" 	=> "Sirin Stencil",
            	"Six Caps" 			=> "Six Caps",
            	"Skranji" 			=> "Skranji",
				"Slabo 13px" 		=> "Slabo 13px",
				"Slabo 27px" 		=> "Slabo 27px",
            	"Slackey" 			=> "Slackey",
            	"Smokum" 			=> "Smokum",
            	"Smythe" 			=> "Smythe",
				"Sniglet" 			=> "Sniglet",
				"Snippet" 			=> "Snippet",
				"Snowburst One" 	=> "Snowburst One",
				"Sofadi One" 		=> "Sofadi One",
				"Sofia" 			=> "Sofia",
				"Sonsie One" 		=> "Sonsie One",
				"Sorts Mill Goudy" 	=> "Sorts Mill Goudy",
				"Source Code Pro" 	=> "Source Code Pro",
				"Source Sans Pro" 	=> "Source Sans Pro",
				"Source Serif Pro" 	=> "Source Serif Pro",
            	"Special Elite" 	=> "Special Elite",
            	"Spicy Rice" 		=> "Spicy Rice",
				"Spinnaker" 		=> "Spinnaker",
				"Spirax" 			=> "Spirax",
				"Squada One" 		=> "Squada One",
				"Stalemate" 		=> "Stalemate",
				"Stalinist One" 	=> "Stalinist One",
				"Stardos Stencil" 	=> "Stardos Stencil",
				"Stint Ultra Condensed" => "Stint Ultra Condensed",
				"Stint Ultra Expanded" => "Stint Ultra Expanded",
				"Stoke" 			=> "Stoke",
				"Strait" 			=> "Strait",
            	"Sue Ellen Francisco" => "Sue Ellen Francisco",
            	"Sunshiney" 		=> "Sunshiney",
            	"Supermercado One" 	=> "Supermercado One",            	
            	"Swanky and Moo Moo" => "Swanky and Moo Moo",
            	"Syncopate" 		=> "Syncopate",
            	"Tangerine" 		=> "Tangerine",            	
            	"Tauri" 			=> "Tauri",
				"Teko" 				=> "Teko",
            	"Telex" 			=> "Telex",
				"Tenor Sans" 		=> "Tenor Sans",
				"Text Me One" 		=> "Text Me One",
				"The Girl Next Door" => "The Girl Next Door",
				"Tienne" 			=> "Tienne",
				"Tinos" 			=> "Tinos",
				"Titan One" 		=> "Titan One",
				"Titillium Web" 	=> "Titillium Web",
				"Trade Winds" 		=> "Trade Winds",
				"Trocchi" 			=> "Trocchi",
				"Trochut" 			=> "Trochut",
				"Trykker" 			=> "Trykker",
				"Tulpen One" 		=> "Tulpen One",
				"Ubuntu" 			=> "Ubuntu",
				"Ubuntu Condensed" 	=> "Ubuntu Condensed",
				"Ubuntu Mono" 		=> "Ubuntu Mono",
				"Ultra" 			=> "Ultra",
				"Uncial Antiqua" 	=> "Uncial Antiqua",
				"Underdog" 			=> "Underdog",
				"Unica One" 		=> "Unica One",
				"UnifrakturCook" 	=> "UnifrakturCook",
				"UnifrakturMaguntia" => "UnifrakturMaguntia",
				"Unkempt" 			=> "Unkempt",
				"Unlock" 			=> "Unlock",
            	"Unna" 				=> "Unna",
            	"VT323" 			=> "VT323",
            	"Vampiro One" 		=> "Vampiro One",
				"Varela" 			=> "Varela",
				"Varela Round" 		=> "Varela Round",
            	"Vast Shadow" 		=> "Vast Shadow",
				"Vesper Libre" 		=> "Vesper Libre",
				"Vibur" 			=> "Vibur",
				"Vidaloka" 			=> "Vidaloka",
				"Viga" 				=> "Viga",
				"Voces" 			=> "Voces",
				"Volkhov" 			=> "Volkhov",
				"Vollkorn" 			=> "Vollkorn",
            	"Voltaire" 			=> "Voltaire",
            	"Waiting for the Sunrise" => "Waiting for the Sunrise",
            	"Wallpoet" 			=> "Wallpoet",
				"Walter Turncoat" 	=> "Walter Turncoat",
				"Warnes" 			=> "Warnes",
				"Wellfleet" 		=> "Wellfleet",
				"Wendy One" 		=> "Wendy One",
            	"Wire One" 			=> "Wire One",
            	"Yanone Kaffeesatz" => "Yanone Kaffeesatz",
            	"Yellowtail" 		=> "Yellowtail",
            	"Yeseva One" 		=> "Yeseva One",
            	"Yesteryear" 		=> "Yesteryear",
            	"Zeyada" 			=> "Zeyada",
        );


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$url =  ADMIN_DIR . 'assets/images/';

$of_options = array();

/* ======================================== Demo Import Tab ======================================== */

$of_options[] = array( 	"name" 		=> "Demo Import",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-import.png"
				);
				
$of_options[] = array( 	"name" 		=> "Import Demo Content",
						"desc" 		=> "Importing demo content will import pages, posts, and custom post type posts. It can also take a minute to complete.",
						"id" 		=> "tpath_demo_content",						
						"std" 		=> admin_url('themes.php?page=tpath_options') . "&import_demo=true&import_content=true",
						"class" 	=> 'demo_content',
						"text" 		=> 'Import Demo Content',						
						"type" 		=> "button"
				);
				
$of_options[] = array( 	"name" 		=> "Import Theme Options",
						"desc" 		=> "Importing demo theme options will import theme options only. It can also take a minute to complete.",
						"id" 		=> "tpath_demo_theme_options",						
						"std" 		=> admin_url('themes.php?page=tpath_options') . "&import_demo=true&import_options=true",
						"class" 	=> 'theme_options',
						"text" 		=> 'Import Theme Options',
						"type" 		=> "button"
				);
				
/* ======================================== General Options Tab ======================================== */

$of_options[] = array( 	"name" 		=> "General Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-home.png"
				);
				
$of_options[] = array( 	"name" 		=> "Disable Page Loader",
						"desc" 		=> "Disable Page Loader on Pages.",
						"id" 		=> "tpath_disable_page_loader",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
										
$of_options[] = array( 	"name" 		=> "Favicon",
						"desc" 		=> "Upload an icon or insert url for website's favicon.",
						"id" 		=> "tpath_favicon",						
						"std" 		=> "",
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Apple iPhone Icon",
						"desc" 		=> "Icon for Apple iPhone",
						"id" 		=> "tpath_apple_iphone_icon",						
						"std" 		=> "",						
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Apple iPhone Retina Icon",
						"desc" 		=> "Icon for Apple iPhone Retina ( 114px x 114px )",
						"id" 		=> "tpath_apple_iphone_retina_icon",						
						"std" 		=> "",						
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Apple iPad Icon",
						"desc" 		=> "Icon for Apple iPad ( 72px x 72px )",
						"id" 		=> "tpath_apple_ipad_icon",						
						"std" 		=> "",
						"type" 		=> "media"
				);

$of_options[] = array( 	"name" 		=> "Apple iPad Retina Icon",
						"desc" 		=> "Icon for Apple iPad Retina ( 144px x 144px )",
						"id" 		=> "tpath_apple_ipad_retina_icon",						
						"std" 		=> "",						
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Enable Responsive Design",
						"desc" 		=> "Enable Responsive design features.",
						"id" 		=> "tpath_enable_responsive",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array(  "name" 		=> "Google Map API Key",
						"desc" 		=> 'Enter your Google Map API key to use google map with your site. Please follow this <a href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key" target="_blank">link</a> to get API key.',
						"id" 		=> "google_map_api",
						"std"		=> "",
						"type" 		=> "text"
				);
								
$of_options[] = array(  "name" 		=> "Custom CSS Code",
						"desc" 		=> "Paste your CSS code. Do not include any tags or HTML in this field.",
						"id"		=> "tpath_custom_css",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
								
/* ======================================== Header Options Tab ======================================== */

$of_options[] = array( 	"name" 		=> "Header Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-header.png"
				);
				
$of_options[] = array(  "name" 		=> "Logo Options",
						"desc" 		=> "",
						"id" 		=> "tpath_header_info",
						"std" 		=> "<h3 style='margin: 0;'>Logo Options</h3>",						
						"type" 		=> "info"
				);
					
$of_options[] = array( 	"name" 		=> "Logo",
						"desc" 		=> "Upload an image or insert an image url to use for the website logo.",
						"id" 		=> "tpath_logo",
						"std" 		=> "",
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name"		=> "Logo Width",
						"desc"		=> "Enter logo width.",
						"id"		=> "tpath_logo_width",
						"std"		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array( 	"name"		=> "Logo Height",
						"desc"		=> "Enter logo height.",
						"id"		=> "tpath_logo_height",
						"std"		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array( 	"name"		=> "Logo Text",
						"desc"		=> "Enter website name or logo text. If you uploaded or inserted an image url for website logo this option will not work.",
						"id"		=> "tpath_logo_text",
						"std"		=> "Justice",
						"type"		=> "text"
				);
				
$of_options[] = array( 	"name" 		=> "Logo First Letter Font Style",
						"desc" 		=> "Select your font styles for Logo First Letter.",
						"id" 		=> "tpath_logo_first_font_styles",
						"std" 		=> array(
											'size'   => '48px',
											'face'   => 'Lobster',
											'style'	 => 'normal',
											'weight' => '500',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array( 	"name" 		=> "Logo Font Style",
						"desc" 		=> "Select your font styles for Logo Text.",
						"id" 		=> "tpath_logo_font_styles",
						"std" 		=> array(
											'size'   => '48px',
											'face'   => 'Pacifico',
											'style'	 => 'normal',
											'weight' => '500',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array(  "name" 		=> "Header Type Options",
						"desc" 		=> "",
						"id" 		=> "tpath_header_type_info",
						"std" 		=> "<h3 style='margin: 0;'>Header Type Options</h3>",						
						"type" 		=> "info"
				);
				
$of_options[] = array( 	"name" 		=> "Sticky Header",
						"desc" 		=> "Enable to have fixed header on scrolling.",
						"id" 		=> "tpath_sticky_header",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"name" 		=> "Show Mini Cart",
						"desc" 		=> "Enable to show Mini Cart in Header.",
						"id" 		=> "tpath_enable_cart_in_header",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Show Search Form",
						"desc" 		=> "Enable to show search form in Header.",
						"id" 		=> "tpath_enable_search_in_header",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Show Social Links",
						"desc" 		=> "Enable to show social links in Header.",
						"id" 		=> "tpath_enable_socials_in_header",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Show Header Top Bar",
						"desc" 		=> "Enable to show Header Top Bar.",
						"id" 		=> "tpath_enable_header_top_bar",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
				
$of_options[] = array( 	"name"		=> "Welcome Message",
						"desc"		=> "Enter welcome message.",
						"id"		=> "tpath_welcome_msg",
						"std"		=> __( 'Good Morning!! Welcome to Justice', 'Templatepath' ),
						"type"		=> "text"
				);
				
$of_options[] = array( 	"name"		=> "Contact Message",
						"desc"		=> "Enter contact message.",
						"id"		=> "tpath_contact_msg",
						"std"		=> "Call us (880) 1723801729",
						"type"		=> "text"
				);
				
$of_options[] = array( 	"name" 		=> "Header Transparency",
						"desc" 		=> "Please select header transparency.",
						"id" 		=> "tpath_header_transparency",
						"std" 		=> "no-transparent",
						"type" 		=> "select",
						"options" 	=> array(
							'no-transparent'	=> 'No Transparent',
							'transparent'		=> 'Transparent',
							'semi-transparent'	=> 'Semi Transparent',
						)
				);
				
$of_options[] = array( 	"name" 		=> "Header Type",
						"desc" 		=> "Select header type.",
						"id" 		=> "tpath_header_type",
						"std" 		=> "header-1",
						"type" 		=> "images",
						"options" 	=> array(
							'header-1' 		=> $url . 'headers/header-01.jpg',
							'header-2' 		=> $url . 'headers/header-02.jpg',
							'header-3' 		=> $url . 'headers/header-03.jpg',							
						)
				);
							
$of_options[] = array(  "name" 		=> "Background Options",
						"desc" 		=> "",
						"id" 		=> "tpath_header_info",
						"std" 		=> "<h3 style='margin: 0;'>Background Options</h3>",						
						"type" 		=> "info"
				);
					
$of_options[] = array( 	"name" 		=> "Background Image for Header",
						"desc" 		=> "Upload an image or insert an image url to use for the header backgroud area.",
						"id" 		=> "tpath_header_bg_image",
						"std" 		=> "",						
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Background Repeat",
						"desc" 		=> "Please select background repeat.",
						"id" 		=> "tpath_header_bg_repeat",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> array(
							'repeat'	=> 'Repeat', 
							'repeat-x'	=> 'Repeat-x', 
							'repeat-y'	=> 'Repeat-y', 
							'no-repeat' => 'No Repeat'
						)
				);
				
$of_options[] = array( 	"name" 		=> "100% Scale Background Image",
						"desc" 		=> "Enable to have header background image always at 100%.",
						"id" 		=> "tpath_header_bg_full",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"name" 		=> "Parallax Background Image",
						"desc" 		=> "Enable to have parallax header background image when scrolling.",
						"id" 		=> "tpath_header_parallax_bg",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Header Styling Options",
						"desc" 		=> "",
						"id" 		=> "tpath_header_info",
						"std" 		=> "<h3 style='margin: 0;'>Header Styling Options</h3>",						
						"type" 		=> "info"
				);

$of_options[] = array( 	"name"		=> "Header Padding Top",
						"desc"		=> "Enter an number value for header top padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_header_padding_top",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array( 	"name"		=> "Header Padding Bottom",
						"desc"		=> "Enter an number value for header bottom padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_header_padding_bottom",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array( 	"name"		=> "Header Padding Left",
						"desc"		=> "Enter an number value for header left padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_header_padding_left",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array( 	"name"		=> "Header Padding Right",
						"desc"		=> "Enter an number value for header right padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_header_padding_right",
						"std"		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array( 	"name" 		=> "Menu Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-menu.png"
				);

$of_options[] = array(  "name" 		=> "Menu Options",
						"desc" 		=> "",
						"id" 		=> "tpath_header_info",
						"std" 		=> "<h3 style='margin: 0;'>Menu Options</h3>",						
						"type" 		=> "info"
				);
				
$of_options[] = array( 	"name" 		=> "Choose Menu Type",
						"desc" 		=> "Please select menu type.",
						"id" 		=> "tpath_menu_type",
						"std" 		=> "Standard",						
						"type" 		=> "select",
						"options" 	=> array(
							'standard'	=> 'Standard',
							'megamenu' 	=> 'Mega Menu'							
						)
				);

$of_options[] = array( 	"name"		=> "Dropdown Menu Width ( Only Standard Mode )",
						"desc"		=> "Enter an number value for dropdown menu in standard mode. Eg: 150px or 40% or 20em.",
						"id"		=> "tpath_dropdown_menu_width",
						"std"		=> "220px",
						"type"		=> "text"
				);
			
/* ======================================== Layout Options Tab ======================================== */
				
$of_options[] = array( 	"name" 		=> "Layout Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-layout.png"
				);
				
$of_options[] = array( 	"name" 		=> "Theme Layout",
						"desc" 		=> "Choose Theme Layout",
						"id" 		=> "tpath_theme_layout",
						"std" 		=> "fullwidth",
						"type" 		=> "select",
						"options" 	=> array(							
							'fullwidth' 	=> 'Full Width',
							'boxed' 		=> 'Boxed'
						)						
				);
				
$of_options[] = array( 	"name" 		=> "Main Layout",
						"desc" 		=> "Select main content and sidebar layout.",
						"id" 		=> "tpath_layout",
						"std" 		=> "one-col",
						"type" 		=> "images",
						"options" 	=> array(
							'one-col' 			=> $url . 'one-col.png',
							'two-col-right' 	=> $url . 'two-col-right.png',
							'two-col-left' 		=> $url . 'two-col-left.png',							
						)
				);
				
$of_options[] = array( 	"name" 		=> "Main Site Width for Fullwidth Layout",
						"desc" 		=> "Please choose site layout width ( in px ).",
						"id" 		=> "tpath_fullwidth_site_width",
						"std" 		=> "1170",
						"min" 		=> "1100",
						"step"		=> "5",
						"max" 		=> "1600",
						"type" 		=> "sliderui"
				);
				
$of_options[] = array( 	"name" 		=> "Main Site Width for Boxed Layout",
						"desc" 		=> "Please choose site layout width ( in px ).",
						"id" 		=> "tpath_boxed_site_width",
						"std" 		=> "1170",
						"min" 		=> "1100",
						"step"		=> "5",
						"max" 		=> "1600",
						"type" 		=> "sliderui"
				);
				
/* ======================================== Footer Options Tab ======================================== */
				
$of_options[] = array( 	"name" 		=> "Footer Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-footer.png"
				);
				
$of_options[] = array(  "name" 		=> "Footer Widget Area Options",
						"desc" 		=> "",
						"id" 		=> "tpath_footer_info",
						"std" 		=> "<h3 style='margin: 0;'>Footer Widget Area Options</h3>",						
						"type" 		=> "info"
				);

$of_options[] = array(  "name" 		=> "Footer Widgets",
						"desc" 		=> "Show Footer Widgets area",
						"id" 		=> "tpath_footer_widgets_enable",
						"std" 		=> 0,
						"folds" 	=> 1,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"name" 		=> "Footer Widget Columns",
						"desc" 		=> "Select Footer widget column layouts.",
						"id" 		=> "tpath_footer_widget_layout",
						"std" 		=> "4",
						"fold" 		=> "tpath_footer_widgets_enable",
						"type" 		=> "images",
						"options" 	=> array(
								'1' 	=> $url . 'footer-col-1.png',
								'2' 	=> $url . 'footer-col-2.png',
								'3' 	=> $url . 'footer-col-3.png',
								'4' 	=> $url . 'footer-col-4.png'
						)
				);
				
$of_options[] = array( 	"name" 		=> "Background Image for Footer Widget Area",
						"desc" 		=> "Upload an image or insert an image url to use for the footer widget backgroud area.",
						"id" 		=> "tpath_footer_bg_image",
						"std" 		=> "",						
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Background Repeat",
						"desc" 		=> "Please select background repeat.",
						"id" 		=> "tpath_footer_bg_repeat",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> array(
							'repeat'	=> 'Repeat', 
							'repeat-x'	=> 'Repeat-x', 
							'repeat-y'	=> 'Repeat-y', 
							'no-repeat' => 'No Repeat' 
						)
				);
				
$of_options[] = array( 	"name" 		=> "100% Scale Background Image",
						"desc" 		=> "Enable to have footer widget background image always at 100%",
						"id" 		=> "tpath_footer_bg_full",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"name"		=> "Footer Widget Padding Top",
						"desc"		=> "Enter an number value for footer widget top padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_footer_widget_padding_top",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array( 	"name"		=> "Footer Widget Padding Bottom",
						"desc"		=> "Enter an number value for footer widget bottom padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_footer_widget_padding_bottom",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array( 	"name"		=> "Footer Widget Padding Left",
						"desc"		=> "Enter an number value for footer widget left padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_footer_widget_padding_left",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array( 	"name"		=> "Footer Widget Padding Right",
						"desc"		=> "Enter an number value for footer right padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_footer_widget_padding_right",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array(  "name" 		=> "Footer Copyright Bar Options",
						"desc" 		=> "",
						"id" 		=> "tpath_footer_info",
						"std" 		=> "<h3 style='margin: 0;'>Footer Copyright Bar Options</h3>",						
						"type" 		=> "info"
				);
				
$of_options[] = array( 	"name"		=> "Footer Padding Top",
						"desc"		=> "Enter an number value for footer copyright bar top padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_footer_padding_top",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array( 	"name"		=> "Footer Padding Bottom",
						"desc"		=> "Enter an number value for footer copyright bar bottom padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_footer_padding_bottom",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array( 	"name"		=> "Footer Padding Left",
						"desc"		=> "Enter an number value for footer copyright bar left padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_footer_padding_left",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array( 	"name"		=> "Footer Padding Right",
						"desc"		=> "Enter an number value for footer copyright bar right padding in px or em or percent. Eg: 10px or 1% or 1em.",
						"id"		=> "tpath_footer_padding_right",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array(  "name" 		=> "Copyright Area / Social Icons Options",
						"desc" 		=> "",
						"id" 		=> "tpath_footer_info",
						"std" 		=> "<h3 style='margin: 0;'>Copyright Area / Social Icons Options</h3>",
						"type" 		=> "info"
				);
				
$of_options[] = array( 	"name"		=> "Copyright Text",
						"desc"		=> "Enter an copyright text to show on footer. Use [year] shortcode to display current year.",
						"id"		=> "tpath_copyright_text",
						"std"		=> "",
						"type"		=> "textarea"
				);
				
$of_options[] = array(  "name" 		=> "Display Social Icons on footer",
						"desc" 		=> "Select the checkbox to show social media icons on the footer. Configure Social media icons on Social Icons Tab",
						"id" 		=> "tpath_enable_social_icons_footer",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);
				
/* ======================================== Background Options Tab ======================================== */
				
$of_options[] = array( 	"name" 		=> "Background Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-background.png"
				);
				
$of_options[] = array(  "name" 		=> "Body Background Options",
						"desc" 		=> "",
						"id" 		=> "tpath_background_info",
						"std" 		=> "<h3 style='margin: 0;'>Body Background Options</h3>",						
						"type" 		=> "info"
				);
				
$of_options[] = array( 	"name" 		=> "Body Background Image",
						"desc" 		=> "Upload an image or insert an image url to use for the background in boxed mode.",
						"id" 		=> "tpath_body_bg_image",
						"std" 		=> "",
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Background Repeat",
						"desc" 		=> "Please select background repeat.",
						"id" 		=> "tpath_body_bg_repeat",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> array(
							'repeat'	=> 'Repeat', 
							'repeat-x'	=> 'Repeat-x', 
							'repeat-y'	=> 'Repeat-y', 
							'no-repeat' => 'No Repeat' 
						)
				);
				
$of_options[] = array( 	"name" 		=> "Background Attachment",
						"desc" 		=> "Please select background attachment.",
						"id" 		=> "tpath_body_bg_attachment",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> array(
							'fixed'		=> 'Fixed', 
							'scroll'	=> 'Scroll'	
						)
				);
				
$of_options[] = array( 	"name" 		=> "100% Scale Background Image",
						"desc" 		=> "Enable to have body background image always at 100%",
						"id" 		=> "tpath_body_bg_full",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Content Background Options",
						"desc" 		=> "",
						"id" 		=> "tpath_background_info",
						"std" 		=> "<h3 style='margin: 0;'>Content Background Options</h3>",						
						"type" 		=> "info"
				);
				
$of_options[] = array( 	"name" 		=> "Full Width Background",
						"desc" 		=> "Disable to have background only for content area and configure separate backgrounds for primary sidebar.",
						"id" 		=> "tpath_enable_content_full_bg",
						"std" 		=> 1,						
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"name" 		=> "Content Background Image",
						"desc" 		=> "Upload an image or insert an image url to use for the content area.",
						"id" 		=> "tpath_primary_content_bg_image",
						"std" 		=> "",
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Background Repeat",
						"desc" 		=> "Please select background repeat.",
						"id" 		=> "tpath_primary_content_bg_repeat",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> array(
							'repeat'	=> 'Repeat', 
							'repeat-x'	=> 'Repeat-x', 
							'repeat-y'	=> 'Repeat-y', 
							'no-repeat' => 'No Repeat' 
						)
				);
				
$of_options[] = array( 	"name" 		=> "100% Scale Background Image",
						"desc" 		=> "Enable to have content background image always at 100%",
						"id" 		=> "tpath_primary_content_bg_full",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"name" 		=> "Content/Sidebar Container Minimum Height",
						"desc" 		=> "Enter an number value for minimum height for container area of content and sidebar in px or em. Eg: 300px or 20em.",
						"id" 		=> "tpath_primary_content_min_height",
						"std" 		=> "300px",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Sidebar Background Options",
						"desc" 		=> "",
						"id" 		=> "tpath_background_info",
						"std" 		=> "<h3 style='margin: 0;'>Sidebar Background Options</h3>",						
						"type" 		=> "info"
				);
				
$of_options[] = array( 	"name" 		=> "Primary Sidebar Background Image",
						"desc" 		=> "Upload an image or insert an image url to use for the primary sidebar area.",
						"id" 		=> "tpath_primary_sidebar_bg_image",
						"std" 		=> "",						
						"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Background Repeat",
						"desc" 		=> "Please select background repeat.",
						"id" 		=> "tpath_primary_sidebar_bg_repeat",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> array(
							'repeat'	=> 'Repeat',
							'repeat-x'	=> 'Repeat-x',
							'repeat-y'	=> 'Repeat-y',
							'no-repeat' => 'No Repeat'
						)
				);
				
$of_options[] = array( 	"name" 		=> "100% Scale Background Image",
						"desc" 		=> "Enable to have primary sidebar background image always at 100%",
						"id" 		=> "tpath_primary_sidebar_bg_full",
						"std" 		=> 0,						
						"type" 		=> "checkbox"
				);
				
/* ======================================== Styling Options Tab ======================================== */
				
$of_options[] = array( 	"name" 		=> "Styling Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-styling.png"
				);
				
$of_options[] = array( 	"name" 		=> "Color Scheme",
						"desc" 		=> "Please select your pre defined color scheme.",
						"id" 		=> "tpath_color_scheme",
						"std" 		=> "default.css",						
						"type" 		=> "images",
						"options" 	=> array(
							'default.css' 	=> $url . 'default.jpg',
							'blue.css' 		=> $url . 'color-2.jpg',
							'red.css' 		=> $url . 'color-3.jpg',
						)
				);
				
$of_options[] = array(  "name" 		=> "Custom Color Scheme",
						"desc" 		=> "",
						"id" 		=> "tpath_custom_colors_info",
						"std" 		=> "<h3 style='margin: 0;'>Custom Color Scheme</h3>",						
						"type"		=> "info"						
				);
				
$of_options[] = array( 	"name" 		=> "Color Scheme",
						"desc" 		=> "Pick a color for custom color scheme.",
						"id" 		=> "tpath_custom_scheme_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Color Scheme Light",
						"desc" 		=> "Pick a light color from choosed color scheme to use in some sections.",
						"id" 		=> "tpath_custom_scheme_color_light",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Color Scheme Dark",
						"desc" 		=> "Pick a dark color from choosed color scheme to use in some sections.",
						"id" 		=> "tpath_custom_scheme_color_dark",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Link Color",
						"desc" 		=> "Pick a link color for the anchor tag.",
						"id" 		=> "tpath_link_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Link Hover Color",
						"desc" 		=> "Pick a link hover color for the anchor tag.",
						"id" 		=> "tpath_link_hover_color",
						"std" 		=> "",
						"type" 		=> "color"
				);

$of_options[] = array(  "name" 		=> "Custom Color Scheme",
						"desc" 		=> "",
						"id" 		=> "tpath_custom_colors_info",
						"std" 		=> "<h3 style='margin: 0;'>Background Colors</h3>",						
						"type"		=> "info"
				);
				
$of_options[] = array( 	"name" 		=> "Body Background Color",
						"desc" 		=> "Pick a background color for the body in boxed mode (default: #fff).",
						"id" 		=> "tpath_body_bg_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Header Background Color",
						"desc" 		=> "Pick a background color for the header (default: #fff).",
						"id" 		=> "tpath_header_background_color",
						"std" 		=> "",
						"type" 		=> "color"
				);				
				
$of_options[] = array( 	"name" 		=> "Header Top Bar Background Color",
						"desc" 		=> "Pick a background color for the header top logo bar.",
						"id" 		=> "tpath_header_top_background_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Sticky Background Color",
						"desc" 		=> "Pick a background color for the sticky header ( Only applies after header is sticky).",
						"id" 		=> "tpath_sticky_background_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Footer Widget Area Background Color",
						"desc" 		=> "Pick a background color for the footer widget area (default: #fff).",
						"id" 		=> "tpath_footer_widget_area_background_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Footer Copyright Background Color",
						"desc" 		=> "Pick a background color for the footer copyright bar (default: #fff).",
						"id" 		=> "tpath_footer_background_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Content Background Color",
						"desc" 		=> "Pick a background color for the content area (default: #fff).",
						"id" 		=> "tpath_primary_content_bg_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Primary Sidebar Background Color",
						"desc" 		=> "Pick a background color for the primary sidebar area (default: #fff).",
						"id" 		=> "tpath_primary_sidebar_bg_color",
						"std" 		=> "",						
						"type" 		=> "color"
				);
				
$of_options[] = array(  "name" 		=> "Custom Color Scheme",
						"desc" 		=> "",
						"id" 		=> "tpath_custom_colors_info",
						"std" 		=> "<h3 style='margin: 0;'>Menu Colors</h3>",
						"type"		=> "info"						
				);

$of_options[] = array( 	"name" 		=> "Menu Font Hover Color",
						"desc" 		=> "Pick a color for the link hover text in menu.",
						"id" 		=> "tpath_menu_font_hover_color",
						"std" 		=> "",						
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Sub Menu Background Color",
						"desc" 		=> "Pick a background color for the sub menu (default: #fff).",
						"id" 		=> "tpath_sub_menu_bg_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Sub Menu Hover Background Color",
						"desc" 		=> "Pick a background color for the sub menu.",
						"id" 		=> "tpath_sub_menu_bg_hover_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
$of_options[] = array( 	"name" 		=> "Sub Menu Font Hover Color",
						"desc" 		=> "Pick a color for the link hover text in sub menu.",
						"id" 		=> "tpath_sub_menu_font_hover_color",
						"std" 		=> "",
						"type" 		=> "color"
				);
				
/* ======================================== Typography Options Tab ======================================== */
				
$of_options[] = array( 	"name" 		=> "Typography Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-typo.png"
				);
				
$of_options[] = array( 	"name" 		=> "Body Text Font Style",
						"desc" 		=> "Select the body text font styles.",
						"id" 		=> "tpath_body_font",
						"std" 		=> array(
											'size'   => '13px',
											'face'   => 'Raleway',
											'style'	 => 'normal',
											'weight' => '600',
											'color'  => '#768083'
										),
						"type" 		=> "typography"
				);

$of_options[] = array( 	"name" 		=> "H1 Font Style",
						"desc" 		=> "Select your font styles for Heading 1.",
						"id" 		=> "tpath_h1_font_styles",
						"std" 		=> array(
											'size'   => '45px',
											'face'   => 'Raleway',
											'style'	 => 'normal',
											'weight' => '800',
											'color'  => ''
										),
						"type" 		=> "typography"
				);

$of_options[] = array( 	"name" 		=> "H2 Font Style",
						"desc" 		=> "Select your font styles for Heading 2.",
						"id" 		=> "tpath_h2_font_styles",
						"std" 		=> array(
											'size'   => '40px',
											'face'   => 'Raleway',
											'style'	 => 'normal',
											'weight' => '600',
											'color'  => ''
										),
						"type" 		=> "typography"
				); 
				
$of_options[] = array( 	"name" 		=> "H3 Font Style",
						"desc" 		=> "Select your font styles for Heading 3.",
						"id" 		=> "tpath_h3_font_styles",
						"std" 		=> array(
											'size'   => '32px',
											'face'   => 'Raleway',
											'style'	 => 'normal',
											'weight' => '600',
											'color'  => ''
										),
						"type" 		=> "typography"
				);

$of_options[] = array( 	"name" 		=> "H4 Font Style",
						"desc" 		=> "Select your font styles for Heading 4.",
						"id" 		=> "tpath_h4_font_styles",
						"std" 		=> array(
											'size'   => '24px',
											'face'   => 'Raleway',
											'style'	 => 'normal',
											'weight' => '600',
											'color'  => ''
										),
						"type" 		=> "typography"
				);

$of_options[] = array( 	"name" 		=> "H5 Font Style",
						"desc" 		=> "Select your font styles for Heading 5.",
						"id" 		=> "tpath_h5_font_styles",
						"std" 		=> array(
											'size'   => '20px',
											'face'   => 'Raleway',
											'style'	 => 'normal',
											'weight' => '600',
											'color'  => ''
										),
						"type" 		=> "typography"
				);

$of_options[] = array( 	"name" 		=> "H6 Font Style",
						"desc" 		=> "Select your font styles for Heading 6.",
						"id" 		=> "tpath_h6_font_styles",
						"std" 		=> array(
											'size'   => '18px',
											'face'   => 'Raleway',
											'style'	 => 'normal',
											'weight' => '600',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array( 	"name" 		=> "Top Menu Font Style",
						"desc" 		=> "Select your font styles for Top Menu.",
						"id" 		=> "tpath_top_menu_font_styles",
						"std" 		=> array(
											'size'   => '12px',
											'face'   => 'Raleway',
											'style'  => 'normal',
											'weight' => '600',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array( 	"name" 		=> "Main Menu Font Style",
						"desc" 		=> "Select your font styles for Full Width Menu.",
						"id" 		=> "tpath_menu_font_styles",
						"std" 		=> array(
											'size'   => '13px',
											'face'   => 'Raleway',
											'style'  => 'normal',
											'weight' => '700',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array( 	"name" 		=> "Sub Menu Font Style",
						"desc" 		=> "Select your font styles for Full Width Sub Menu.",
						"id" 		=> "tpath_submenu_font_styles",
						"std" 		=> array(
											'size'   => '13px',
											'face'   => 'Raleway',
											'style'  => 'normal',
											'weight' => '700',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array( 	"name" 		=> "Section Font Style",
						"desc" 		=> "Select your font styles for Section Title.",
						"id" 		=> "tpath_section_font_styles",
						"std" 		=> array(
											'size'   => '24px',
											'face'   => 'Raleway',
											'style'	 => 'normal',
											'weight' => '400',
											'color'  => ''
										),
						"type" 		=> "typography"
				);				
			
$of_options[] = array( 	"name" 		=> "Page/Post Title Font Style",
						"desc" 		=> "Select your font styles for Page/Post Title.",
						"id" 		=> "tpath_single_post_title_font_styles",
						"std" 		=> array(
											'size'   => '20px',
											'face'   => 'Raleway',
											'style'	 => 'normal',
											'weight' => '600',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array( 	"name" 		=> "Widget Heading Font Style",
						"desc" 		=> "Select your font styles for Widget Heading.",
						"id" 		=> "tpath_widget_title_fonts",
						"std" 		=> array(
											'size'   => '18px',
											'face'   => 'Raleway',
											'style'  => 'normal',
											'weight' => '700',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array( 	"name" 		=> "Widget Text Font Style",
						"desc" 		=> "Select your font styles for Widget texts.",
						"id" 		=> "tpath_widget_text_fonts",
						"std" 		=> array(
											'size'   => '16px',
											'face'   => 'Raleway',
											'style'  => 'normal',
											'weight' => '400',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array( 	"name" 		=> "Footer Widget Heading Font Style",
						"desc" 		=> "Select your font styles for Footer Widget Heading.",
						"id" 		=> "tpath_footer_widget_title_fonts",
						"std" 		=> array(
											'size'   => '18px',
											'face'   => 'Raleway',
											'style'  => 'normal',
											'weight' => '700',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
$of_options[] = array( 	"name" 		=> "Footer Widget Text Font Style",
						"desc" 		=> "Select your font styles for Footer Widget texts.",
						"id" 		=> "tpath_footer_widget_text_fonts",
						"std" 		=> array(
											'size'   => '16px',
											'face'   => 'Raleway',
											'style'  => 'normal',
											'weight' => '400',
											'color'  => ''
										),
						"type" 		=> "typography"
				);
				
/* ======================================== Social Links Tab ======================================== */
				
$of_options[] = array( 	"name" 		=> "Social Icons",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-link.png"
				);
				
$of_options[] = array( 	"name" 		=> "Choose Icon Type",
						"desc" 		=> "Select social icons type",
						"id" 		=> "tpath_social_icon_type",
						"std" 		=> "circle",
						"type" 		=> "images",
						"options" 	=> array(
							'circle' 		=> $url . 'social-icon-circle.png',
							'flat' 			=> $url . 'social-icon-rectangle.png',
							'transparent' 	=> $url . 'social-icon-transparent.png'
						)
				);
				
$of_options[] = array(  "name" 		=> "Facebook",
						"desc" 		=> "Enter the link for Facebook icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_facebook_link",
						"std" 		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Twitter",
						"desc" 		=> "Enter the link for Twitter icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_twitter_link",
						"std" 		=> "",
						"type"		=> "text"
				);				

$of_options[] = array(  "name" 		=> "LinkedIn",
						"desc" 		=> "Enter the link for LinkedIn icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_linkedin_link",
						"std" 		=> "",
						"type" 		=> "text"						
				);
				
$of_options[] = array(  "name" 		=> "Pinterest",
						"desc" 		=> "Enter the link for Pinterest icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_pinterest_link",
						"std" 		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Google Plus+",
						"desc" 		=> "Enter the link for Google Plus+ icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_googleplus_link",
						"std" 		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Youtube",
						"desc" 		=> "Enter the link for Youtube icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_youtube_link",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "RSS",
						"desc" 		=> "Enter the link for RSS icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_rss_link",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Tumblr",
						"desc" 		=> "Enter the link for Tumblr icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_tumblr_link",
						"std" 		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Reddit",
						"desc" 		=> "Enter the link for Reddit icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_reddit_link",
						"std" 		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Dribbble",
						"desc" 		=> "Enter the link for Dribbble icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_dribbble_link",
						"std" 		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Digg",
						"desc" 		=> "Enter the link for Digg icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_digg_link",
						"std" 		=> "",
						"type"		=> "text"
				);

$of_options[] = array(  "name" 		=> "Flickr",
						"desc" 		=> "Enter the link for Flickr icon to appear. To remove it, just leave it blank.",
						"id"		=> "tpath_flickr_link",
						"std" 		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Instagram",
						"desc" 		=> "Enter the link for Instagram icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_instagram_link",
						"std" 		=> "",
						"type"		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Skype",
						"desc" 		=> "Enter the link for Skype icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_skype_link",
						"std" 		=> "",
						"type" 		=> "text"
				);

$of_options[] = array(  "name" 		=> "Blogger",
						"desc" 		=> "Enter the link for Blogger icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_blogger_link",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Yahoo",
						"desc" 		=> "Enter the link for Yahoo icon to appear. To remove it, just leave it blank.",
						"id" 		=> "tpath_yahoo_link",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
/* ======================================== Blog Options Tab ======================================== */
				
$of_options[] = array( 	"name" 		=> "Blog Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-blog.png"
				);
				
$of_options[] = array( 	"name" 		=> "Show Page Title Bar for Blog",
						"desc" 		=> "Enable Page Title Bar for Blog Page.",
						"id" 		=> "tpath_blog_page_title_bar",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
				
$of_options[] = array(  "name" 		=> "Blog Title",
						"desc" 		=> "Enter Blog Title.",
						"id" 		=> "tpath_blog_title",
						"std" 		=> "Blog",
						"type" 		=> "text"
				);
				
$of_options[] = array( 	"name" 		=> "Blog Layout",
						"desc" 		=> "Select blog layout.",
						"id" 		=> "tpath_blog_layout",
						"std" 		=> "",
						"type" 		=> "images",
						"options" 	=> array(
							'one-col' 			=> $url . 'one-col.png',
							'two-col-right' 	=> $url . 'two-col-right.png',
							'two-col-left' 		=> $url . 'two-col-left.png',							
						)
				);
				
$of_options[] = array( 	"name" 		=> "Blog Archive/Category Layout",
						"desc" 		=> "Select blog archive/category layout.",
						"id" 		=> "tpath_blog_archive_layout",
						"std" 		=> "",
						"type" 		=> "images",
						"options" 	=> array(
							'one-col' 			=> $url . 'one-col.png',
							'two-col-right' 	=> $url . 'two-col-right.png',
							'two-col-left' 		=> $url . 'two-col-left.png',							
						)
				);
				
$of_options[] = array( 	"name" 		=> "Single Posts Layout",
						"desc" 		=> "Select single posts layout applied to all single posts.",
						"id" 		=> "tpath_single_post_layout",
						"std" 		=> "",
						"type" 		=> "images",
						"options" 	=> array(
							'one-col' 			=> $url . 'one-col.png',
							'two-col-right' 	=> $url . 'two-col-right.png',
							'two-col-left' 		=> $url . 'two-col-left.png',							
						)
				);

$of_options[] = array(  "name" 		=> "Blog Posts Layout",
						"desc" 		=> "Choose Blog Posts Type.",
						"id" 		=> "tpath_blog_type",
						"std" 		=> "large",
						"type" 		=> "select",
						"options"	=> array(
							'large' 	=> 'Large Posts',
							'list' 		=> 'List Posts',
							'grid' 		=> 'Grid Posts'
						)
				);	
				
$of_options[] = array(  "name" 		=> "Blog Archive/Category Posts Layout",
						"desc" 		=> "Choose Blog Archive/Category Posts Type.",
						"id" 		=> "tpath_archive_blog_type",
						"std" 		=> "large",
						"type" 		=> "select",
						"options"	=> array(
							'large' 	=> 'Large Posts',
							'list' 		=> 'List Posts',
							'grid' 		=> 'Grid Posts'
						)
				);
								
$of_options[] = array(  "name" 		=> "Number of Columns for Grid Layout",
						"desc" 		=> "Choose number of columns for Grid layout.",
						"id" 		=> "tpath_blog_grid_columns",
						"std" 		=> "two",
						"type" 		=> "select",
						"options"	=> array(
							'two' 		=> '2',
							'three' 	=> '3',
							'four' 		=> '4'			
						)
				);
				
$of_options[] = array(  "name" 		=> "Show List Layout in Fullwidth",
						"desc" 		=> "Choose to show list layout in fullwidth or in columns.",
						"id" 		=> "tpath_blog_list_fullwidth",
						"std" 		=> "no",
						"type" 		=> "select",
						"options"	=> array(
							'no' 		=> 'No',
							'yes' 		=> 'Yes',									
						)
				);
				
$of_options[] = array(  "name" 		=> "Gallery Post Slider Autoplay",
						"desc" 		=> "Choose to show gallery images in autoplay.",
						"id" 		=> "tpath_blog_slideshow_autoplay",
						"std" 		=> "false",
						"type" 		=> "select",
						"options"	=> array(
							'false' 	=> 'False',
							'true' 		=> 'True',									
						)
				);
				
$of_options[] = array(  "name" 		=> "Gallery Post Slider Autoplay Speed",
						"desc" 		=> "Enter the autoplay speeds for sliders within posts. Ex: 5000",
						"id" 		=> "tpath_blog_slideshow_autoplay_speed",
						"std" 		=> "5000",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Gallery Post Slide Speed",
						"desc" 		=> "Enter the slide speed for sliders within posts.",
						"id" 		=> "tpath_blog_slideshow_speed",
						"std" 		=> "450",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Slideshow Animation In",
						"desc" 		=> "Choose type of animation in for sliders within posts.",
						"id" 		=> "tpath_blog_animation_in_type",
						"std" 		=> "flipInX",
						"type" 		=> "select",
						"options"	=> array(
							'fadeIn' 		=> 'Fade In',
							'fadeOut' 		=> 'Fade Out',
							'slideInDown' 	=> 'Slide In Down',
							'slideOutDown' 	=> 'Slide Out Down',
							'flipInX' 		=> 'Flip In X',
							'flipInY' 		=> 'Flip In Y'
						)
				);
				
$of_options[] = array(  "name" 		=> "Slideshow Animation Out",
						"desc" 		=> "Choose type of animation out for sliders within posts.",
						"id" 		=> "tpath_blog_animation_out_type",
						"std" 		=> "slideOutDown",
						"type" 		=> "select",
						"options"	=> array(
							'fadeIn' 		=> 'Fade In',
							'fadeOut' 		=> 'Fade Out',
							'slideInDown' 	=> 'Slide In Down',
							'slideOutDown' 	=> 'Slide Out Down',
							'flipInX' 		=> 'Flip In X',
							'flipInY' 		=> 'Flip In Y'
						)
				);
				
$of_options[] = array(  "name" 		=> "Disable Pagination",
						"desc" 		=> "Check to hide pagination on blog and show posts with Infinite Scroll",
						"id" 		=> "tpath_disable_blog_pagination",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Disable Previous/Next Navigation on Single Posts",
						"desc" 		=> "Check to disable previous/next navigation on single posts",
						"id" 		=> "tpath_blog_prev_next",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);				
				
$of_options[] = array(  "name" 		=> "Author Info",
						"desc" 		=> "Show the author info below posts.",
						"id" 		=> "tpath_blog_author_info",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array(  "name" 		=> "Social Sharing",
						"desc" 		=> "Show the social sharing icons.",
						"id" 		=> "tpath_blog_social_sharing",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Comments",
						"desc" 		=> "Show comments.",
						"id" 		=> "tpath_blog_comments",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Disable Post Meta Author",
						"desc" 		=> "Check to hide author name from post meta on blog posts.",
						"id" 		=> "tpath_blog_post_meta_author",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Disable Post Meta Date",
						"desc" 		=> "Check to hide date from post meta on blog posts.",
						"id" 		=> "tpath_blog_post_meta_date",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);

$of_options[] = array(  "name" 		=> "Disable Post Meta Categories",
						"desc" 		=> "Check to hide categories from post meta on blog posts.",
						"id" 		=> "tpath_blog_post_meta_categories",
						"std" 		=> 0,
						"type"		=> "checkbox"
				);

$of_options[] = array(  "name" 		=> "Disable Post Meta Comments",
						"desc" 		=> "Check to hide comments from post meta on blog posts.",
						"id" 		=> "tpath_blog_post_meta_comments",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Disable Read More Link",
						"desc" 		=> "Check to hide read more link from post meta on blog posts.",
						"id" 		=> "tpath_blog_read_more",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Read More Text",
						"desc" 		=> "Enter the custom read more text.",
						"id" 		=> "tpath_blog_read_more_text",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Excerpt Length for Large Layout",
						"desc" 		=> "Enter the number of words to shown in large layout excerpt on blog/archive pages.",
						"id" 		=> "tpath_blog_excerpt_length_large",
						"std" 		=> "100",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Excerpt Length for Grid Layout",
						"desc" 		=> "Enter the number of words to shown in  grid layout excerpt on blog/archive pages.",
						"id" 		=> "tpath_blog_excerpt_length_grid",
						"std" 		=> "10",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Post Meta Date Format",
						"desc" 		=> "Enter post meta date format. Refer formats from <a href='http://codex.wordpress.org/Formatting_Date_and_Time'>Formatting Date and Time</a>",
						"id" 		=> "tpath_blog_date_format",
						"std" 		=> "F d, Y",
						"type" 		=> "text"
				);				
			
/* ======================================== Social Sharing Options Tab ======================================== */
				
$of_options[] = array( 	"name" 		=> "Social Sharing Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-share.png"
				);
				
$of_options[] = array(  "name" 		=> "Facebook",
						"desc" 		=> "Check to show the facebook sharing icon in blog posts.",
						"id" 		=> "tpath_sharing_facebook",
						"std" 		=> 0,
						"type"		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Twitter",
						"desc" 		=> "Check to show the twitter sharing icon in blog posts.",
						"id" 		=> "tpath_sharing_twitter",
						"std" 		=> 0,
						"type"		=> "checkbox"
				);				

$of_options[] = array(  "name" 		=> "LinkedIn",
						"desc" 		=> "Check to show the linkedIn sharing icon in blog posts.",
						"id" 		=> "tpath_sharing_linkedin",
						"std" 		=> 0,
						"type" 		=> "checkbox"						
				);
				
$of_options[] = array(  "name" 		=> "Pinterest",
						"desc" 		=> "Check to show the pinterest sharing icon in blog posts.",
						"id" 		=> "tpath_sharing_pinterest",
						"std" 		=> 0,
						"type"		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Google Plus",
						"desc" 		=> "Check to show the google plus sharing icon in blog posts.",
						"id" 		=> "tpath_sharing_googleplus",
						"std" 		=> 0,
						"type"		=> "checkbox"
				);
								
$of_options[] = array(  "name" 		=> "Tumblr",
						"desc" 		=> "Check to show the tumblr sharing icon in blog posts.",
						"id" 		=> "tpath_sharing_tumblr",
						"std" 		=> 0,
						"type"		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Reddit",
						"desc" 		=> "Check to show the reddit sharing icon in blog posts.",
						"id" 		=> "tpath_sharing_reddit",
						"std" 		=> 0,
						"type"		=> "checkbox"
				);
								
$of_options[] = array(  "name" 		=> "Digg",
						"desc" 		=> "Check to show the digg sharing icon in blog posts.",
						"id" 		=> "tpath_sharing_digg",
						"std" 		=> 0,
						"type"		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Email",
						"desc" 		=> "Check to show the email sharing icon in blog posts.",
						"id" 		=> "tpath_sharing_email",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
/* ======================================== Contact Tab ======================================== */
				
$of_options[] = array( 	"name" 		=> "Contact",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-contact.png"
				);
				
$of_options[] = array(  "name" 		=> "General Contact Details",
						"desc" 		=> "",
						"id" 		=> "tpath_contact_heading",
						"std" 		=> "<h3 style='margin: 0;'>General Contact Details</h3>",						
						"type" 		=> "info"
				);
				
$of_options[] = array(  "name" 		=> "Site Name",
						"desc" 		=> "Enter Site name.",
						"id" 		=> "tpath_site_name",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Email Address",
						"desc" 		=> "Enter email address to get customer requests.",
						"id" 		=> "tpath_site_email",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Website",
						"desc" 		=> "Enter website URL.",
						"id" 		=> "tpath_site_url",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Address",
						"desc" 		=> "Enter address.",
						"id" 		=> "tpath_site_address",
						"std" 		=> "",
						"type" 		=> "textarea"
				);

$of_options[] = array(  "name" 		=> "Site Phone Number",
						"desc" 		=> "Enter site phone number to get customer contact with you.",
						"id" 		=> "tpath_site_phone",
						"std" 		=> "",
						"type" 		=> "text"
				);

$of_options[] = array(  "name" 		=> "Site Fax Number",
						"desc" 		=> "Enter site fax number.",
						"id" 		=> "tpath_site_fax_number",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Google Map Heading",
						"desc" 		=> "",
						"id" 		=> "tpath_contact_heading",
						"std" 		=> "<h3 style='margin: 0;'>Google Map Options</h3>",						
						"type" 		=> "info"
				);
				
$of_options[] = array(  "name" 		=> "Show Google map on Contact Page",
						"desc" 		=> "Check to show the google map on contact page.",
						"id" 		=> "tpath_show_google_map_contact",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Google Map Type",
						"desc" 		=> "Select the google map type to show on the contact page.",
						"id" 		=> "tpath_gmap_type",
						"std" 		=> "roadmap",
						"type" 		=> "select",
						"options" 	=> array(
							'ROADMAP' 	=> 'roadmap', 
							'SATELLITE' => 'satellite', 
							'HYBRID' 	=> 'hybrid', 
							'TERRAIN' 	=> 'terrain'
						)
				);
				
$of_options[] = array(  "name" 		=> "Google Map Width",
						"desc" 		=> "Enter google map width in pixels or percentage. Ex: 300px or 100%.",
						"id" 		=> "tpath_gmap_width",
						"std" 		=> "100%",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Google Map Height",
						"desc" 		=> "Enter google map height in pixels. Ex: 400px.",
						"id" 		=> "tpath_gmap_height",
						"std" 		=> "510px",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Google Map Address",
						"desc" 		=> "Enter address to show marker on map. <br />To show multiple marker locations on map, to separate the addresses using | symbol. Ex: Address 1|Address 2.",
						"id" 		=> "tpath_gmap_address",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
				
$of_options[] = array(  "name" 		=> "Map Infowindow Content",
						"desc" 		=> "Enter content to show on map infowindow.",
						"id" 		=> "tpath_gmap_content",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
				
$of_options[] = array(  "name" 		=> "Map Zoom Level",
						"desc" 		=> "Enter map zoom level. Entering higher number will be more zoomed in.",
						"id" 		=> "tpath_gmap_zoom_level",
						"std" 		=> "12",
						"type" 		=> "text"
				);
				
$of_options[] = array(  "name" 		=> "Map Marker Icon",
						"desc" 		=> "Upload custom marker icon to display on maps.",
						"id" 		=> "tpath_gmap_marker_icon",
						"std" 		=> "",
						"type" 		=> "media"
				);
				
$of_options[] = array(  "name" 		=> "Show Map Address On Click",
						"desc" 		=> "Check to show the map address when the marker on the map is clicked.",
						"id" 		=> "tpath_gmap_popup",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Disable Map Scrollwheel",
						"desc" 		=> "Check to disable scrollwheel on google maps.",
						"id" 		=> "tpath_gmap_scrollwheel",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array(  "name" 		=> "Disable Map Scale",
						"desc" 		=> "Check to disable scale on google maps.",
						"id" 		=> "tpath_gmap_scale",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);

$of_options[] = array(  "name" 		=> "Disable Map Zoom & Pan Control Icons",
						"desc" 		=> "Check to disable zoom control and pan control icons on google maps.",
						"id" 		=> "tpath_gmap_zoomcontrol",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);

$of_options[] = array(  "name" 		=> "Contact Form Heading",
						"desc" 		=> "",
						"id" 		=> "tpath_contact_heading",
						"std" 		=> "<h3 style='margin: 0;'>Contact Form Options</h3>",						
						"type" 		=> "info"
				);
				
$of_options[] = array(  "name" 		=> "Contact Form Message",
						"desc" 		=> "Enter contact form message to show below title.",
						"id" 		=> "tpath_contact_message",
						"std" 		=> "",
						"type" 		=> "textarea"
				);

$of_options[] = array(  "name" 		=> "Email Address",
						"desc" 		=> "Enter the email address to send notification mail when form is submitted.",
						"id" 		=> "tpath_contact_email",
						"std" 		=> "",
						"type" 		=> "text"
				);

$of_options[] = array(  "name" 		=> "Disable Name Field",
						"desc" 		=> "Check to disable name field in form.",
						"id" 		=> "tpath_form_name",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);

$of_options[] = array(  "name" 		=> "Disable Subject Field",
						"desc" 		=> "Check to disable subject field in form.",
						"id" 		=> "tpath_form_subject",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
			
$of_options[] = array(  "name" 		=> "Name Field Label",
						"desc" 		=> "Enter the label name for name field.",
						"id" 		=> "tpath_labels_name",
						"std" 		=> "",
						"type" 		=> "text"
				);

$of_options[] = array(  "name" 		=> "Email Field Label",
						"desc" 		=> "Enter the label name for email field.",
						"id" 		=> "tpath_labels_email",
						"std" 		=> "",
						"type" 		=> "text"
				);

$of_options[] = array(  "name" 		=> "Subject Field Label",
						"desc" 		=> "Enter the label name for subject field.",
						"id" 		=> "tpath_labels_subject",
						"std" 		=> "",
						"type" 		=> "text"
				);

$of_options[] = array(  "name" 		=> "Message Field Label",
						"desc" 		=> "Enter the label name for message field.",
						"id" 		=> "tpath_labels_message",
						"std" 		=> "",
						"type" 		=> "text"
				);
				
/* ======================================== Woocommerce Tab ======================================== */

$of_options[] = array( 	"name" 		=> "Woocommerce",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-cart.png"
				);
				
$of_options[] = array( 	"name" 		=> "Woocommerce Category Layout",
						"desc" 		=> "Select Wocommerce category layout.",
						"id" 		=> "tpath_woo_archive_layout",
						"std" 		=> "one-col",
						"type" 		=> "images",
						"options" 	=> array(
							'one-col' 			=> $url . 'one-col.png',
							'two-col-right' 	=> $url . 'two-col-right.png',
							'two-col-left' 		=> $url . 'two-col-left.png',							
						)
				);
				
$of_options[] = array( 	"name" 		=> "Woocommerce Single Product Layout",
						"desc" 		=> "Select Wocommerce Single Product layout.",
						"id" 		=> "tpath_woo_single_layout",
						"std" 		=> "two-col-right",
						"type" 		=> "images",
						"options" 	=> array(
							'one-col' 			=> $url . 'one-col.png',
							'two-col-right' 	=> $url . 'two-col-right.png',
							'two-col-left' 		=> $url . 'two-col-left.png',							
						)
				);
				
$of_options[] = array( 	"name" 		=> "Woocommerce Categories Page Header Image",
						"desc" 		=> "Upload an image for categories page header.",
						"id" 		=> "tpath_woo_archive_image",						
						"std" 		=> "",
						"type" 		=> "media"
				);
				
$of_options[] = array(  "name" 		=> "Number of Products Per Page",
						"desc" 		=> "Changes number of products displayed per page in Shop.",
						"id" 		=> "tpath_loop_products_per_page",
						"std" 		=> "",
						"type" 		=> "text"	
				);
				
$of_options[] = array(  "name" 		=> "Product Columns",
						"desc" 		=> "Changes number of columns displayed per page in Shop.",
						"id" 		=> "tpath_loop_shop_columns",
						"std" 		=> "4",
						"type" 		=> "select",
						"options"	=> array(
							'2' 	=> '2',
							'3' 	=> '3',
							'4' 	=> '4',
							'5' 	=> '5'
						)
				);
				
$of_options[] = array(  "name" 		=> "Number of Related Products",
						"desc" 		=> "Choose number of Related Products in Single Product Page.",
						"id" 		=> "tpath_related_products_count",
						"std" 		=> "3",
						"type" 		=> "select",
						"options"	=> array(
							'2' 	=> '2',
							'3' 	=> '3',
							'4' 	=> '4',
							'5' 	=> '5'
						)
				);
				
$of_options[] = array(  "name" 		=> "Disable Woocommerce Shop Page Ordering",
						"desc" 		=> "Check to disable the ordering boxes displayed on the shop page.",
						"id" 		=> "tpath_woo_shop_ordering",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
								
/* ======================================== Backup Options Tab ======================================== */

$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-backup.png"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);
				
	}//End function: of_options()
}//End check if function exists: of_options()

?>