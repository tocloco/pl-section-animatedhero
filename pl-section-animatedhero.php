<?php
/*

  Plugin Name: PageLines Section Animated Hero

  Description: A Section To have a simple hero section with animation so I don't have to use Slider Revolution on pages

  Author:      TOCLOCO LTD

  Version:     1.0.2

  PageLines:   PL_Section_AnimatedHero

  Tags:         animated

  Category:     framework, sections

  Filter:       layout


*/

function pl_section_animatedhero_enqueue_scripts() {
	wp_enqueue_script('jquery-ui');
}
add_action('wp_enqueue_scripts','pl_section_animatedhero_enqueue_scripts');

function pl_section_animatedhero_adding_scripts() {
	wp_register_script('pl-section-animatedhero-script', plugins_url('script.js', __FILE__));
	wp_enqueue_script('pl-section-animatedhero-script');
}
add_action( 'wp_enqueue_scripts', 'pl_section_animatedhero_adding_scripts' ); 







/** Check that PL is installed */
if( ! class_exists('PL_Section') ){
  return;
}

class PL_Section_AnimatedHero extends PL_Section {
	function section_persistent(){
	}

	//Use the pl_script and pl_style functions (which enqueues the files)
	function section_styles(){
  		//include any js
  		//pl_script( $this->id, $this->base_url . '/join.js' );
  		pl_style(   'pl-section-animatedhero-css',  plugins_url( '/css/pl-section-animatedhero.css', __FILE__ ) );
	}

	function section_opts(){
		$options = array(
			array(
				'label'    => __( 'Header text', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'headertext',
	            'default'  => ''
			),
			array(
				'label'    => __( 'Google font name', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'font',
	            'default'  => ''
			),
			array(
				'label'    => __( 'Size override', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'fontsize',
	            'default'  => ''
			),
			array(
				'label'    => __( 'Font weight', 'pagelines' ),
	        	'type'    => 'select',
			    'opts'    => array(
			        '100'  => array( 'name' => "100"),
			        '200'  => array( 'name' => "200"),
			        '300'  => array( 'name' => "300"),
			        '400'  => array( 'name' => "400"),
			        '500'  => array( 'name' => "500"),
			        '600'  => array( 'name' => "600"),
			        '700'  => array( 'name' => "700"),
			    ),
	            'key'   => 'weight',
	            'default'  => '400'
			),
			array(
				'label'    => __( '------------------------------<br>Sub text', 'pagelines' ),
	        	'type'  => 'textarea',
	            'key'   => 'subtext',
	            'default'  => ''
			),
			array(
				'label'    => __( 'Google font name', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'subfont',
	            'default'  => ''
			),
			array(
				'label'    => __( 'Size override', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'subfontsize',
	            'default'  => ''
			),
			array(
				'label'    => __( 'Font weight', 'pagelines' ),
	        	'type'    => 'select',
			    'opts'    => array(
			        '100'  => array( 'name' => "100"),
			        '200'  => array( 'name' => "200"),
			        '300'  => array( 'name' => "300"),
			        '400'  => array( 'name' => "400"),
			        '500'  => array( 'name' => "500"),
			        '600'  => array( 'name' => "600"),
			        '700'  => array( 'name' => "700"),
			    ),
	            'key'   => 'subweight',
	            'default'  => '400'
			),
			array(
				'label'    => __( '------------------------------<br>Text width (%)', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'textwidth',
	            'default'  => ''
			),
			/*
			array(
				'label'    => __( 'Button text', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'buttontext',
	            'default'  => ''
			),
			array(
				'label'    => __( 'Button url', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'buttonurl',
	            'default'  => ''
			),
			*/
			pl_std_opt('image'),			
			array(
				'label'    => __( 'Reverse image and text', 'pagelines' ),
	        	'type'  => 'check',
	            'key'   => 'reversed',
	            'default'  => ''
			),
			
			array(
				'label'    => __( 'X movement start position<br>(include unit eg. -50px)', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'moveX',
	            'default'  => '30px'
			),
			array(
				'label'    => __( 'Y movement start position<br>(include unit eg. -50px)', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'moveY',
	            'default'  => '30px'
			),
			array(
				'label'    => __( 'Rotation<br>(degrees eg. 45)', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'rotate',
	            'default'  => '0'
			),
			array(
				'label'    => __( 'Opacity fade in<br>(0 to 1. 1 = no fade in)', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'opacity',
	            'default'  => '0'
			),
			array(
				'label'    => __( 'Blur<br>(include unit eg. 5px)', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'blur',
	            'default'  => '0px'
			),
			array(
				'label'    => __( 'Duration<br>(include unit eg. 1s)', 'pagelines' ),
	        	'type'  => 'text',
	            'key'   => 'duration',
	            'default'  => '1s'
			),
			pl_std_opt('scheme'),
		);
		return $options;
	}

	

	function section_template(){ 
		$sectionId  	= $this->id . $this -> meta['clone'];
		$reversed 		= $this->meta['set']['reversed']; 
		
		$headertext 	= $this->meta['set']['headertext']; 
		$subtext 		= $this->meta['set']['subtext']; 
		$textwidth 		= $this->meta['set']['textwidth']; 
		
		$font 			= $this->meta['set']['font']; 
		$weight 		= $this->meta['set']['weight']; 
		$fontsize 		= $this->meta['set']['fontsize']; 
		
		$subfont 		= $this->meta['set']['subfont']; 
		$subweight 		= $this->meta['set']['subweight']; 
		$subfontsize	= $this->meta['set']['subfontsize']; 
		
		$buttontext 	= $this->meta['set']['buttontext']; 
		$buttonurl 		= $this->meta['set']['buttonurl']; 
		
		$duration 		= $this->meta['set']['duration'];
		$opacity 		= $this->meta['set']['opacity'];
		$rotate 		= $this->meta['set']['rotate'];
		$moveX	 		= $this->meta['set']['moveX'];
		$moveY 			= $this->meta['set']['moveY'];
		$blur 			= $this->meta['set']['blur'];
		
		if(substr($moveX, 0, 1)=='-'){
			$moveXText = str_ireplace($moveX, '', '-');
		} else {
			$moveXText = '-' . $moveX;
		}
		if(substr($rotate, 0, 1)=='-'){
			$rotateText = str_ireplace($rotate, '', '-');
		} else {
			$rotateText = '-' . $rotate;
		}
		
		
		$imagecode = '<div class="img-wrap" style="text-align: center;"><img class="pl_animated_hero"  src="" data-bind="plimg: image" data-animationcss="animated' .  $sectionId . '"></div>';
		
		$textcode = '<div data-animationcss="animated' .  $sectionId . 'text" style="width:' . $textwidth . '%; margin-left: auto; margin-right: auto;';
		if($reversed == 1){
			$textcode .= 'text-align: left;';
		} else {
			$textcode .= 'text-align: right;';
		}
		$textcode .= '"  class="pl_animated_herotext">';
		$textcode .= "<h1 style=\"font-family: $font; font-weight: $weight; font-size: $fontsize; \" data-bind=\"plshortcode: headertext\">$headertext</h1>";
		$textcode .= "<h2 style=\"margin-top:1%; font-family: $subfont; font-weight: $subweight; font-size: $subfontsize;  line-height: 150%; \" data-bind=\"plshortcode: subtext\">$subtext</h2></div>";
		
		?>
		<style>
			#<?php echo  $this->id . '_' . $this -> meta['clone']; ?>{
				
			}
			
			#<?php echo  $this->id . '_' . $this -> meta['clone']; ?> .pl-sn-pad, #<?php echo  $this->id . '_' . $this -> meta['clone']; ?> .pl-content-area{
				padding: 0;
			}
			
			.animated<?php echo $sectionId; ?> {
				-webkit-animation-name: animation<?php echo $sectionId; ?>;
				animation-name: animation<?php echo $sectionId; ?>;
				-webkit-animation-duration: <?php echo $duration; ?>;
				animation-duration: <?php echo $duration; ?>;
				-webkit-animation-fill-mode: both;
				animation-fill-mode: both;
				-webkit-animation-delay: 0.25s;
				animation-delay: 0.25s;
			}
			.animated<?php echo $sectionId; ?>text {
				-webkit-animation-name: animation<?php echo $sectionId; ?>text;
				animation-name: animation<?php echo $sectionId; ?>text;
				-webkit-animation-duration: <?php echo $duration; ?>;
				animation-duration: <?php echo $duration; ?>;
				-webkit-animation-fill-mode: both;
				animation-fill-mode: both;
				-webkit-animation-delay: 0.25s;
				animation-delay: 0.25s;
			}
			
			@keyframes animation<?php echo $sectionId; ?> {
			  0% {
			    opacity: <?php echo $opacity; ?>;
			    transform:  rotate(<?php echo $rotate; ?>deg) translateX(<?php echo $moveX; ?>) translateY(<?php echo $moveY; ?>);
			    filter: blur(<?php echo $blur; ?>);
			  }
			 
			  100% {
			    opacity: 1;			    
			    transform:  rotate(0deg) translateX(0px) translateY(0px);
			    filter: blur(0px);
			  }
			}
			
			@keyframes animation<?php echo $sectionId; ?>text {
			  0% {
			    opacity: <?php echo $opacity; ?>;
			    transform:  rotate(<?php echo $rotateText; ?>deg) translateX(<?php echo $moveXText; ?>) translateY(<?php echo $moveY; ?>);
			    filter: blur(<?php echo $blur; ?>);
			  }
			 
			  100% {
			    opacity: 1;			    
			    transform:  rotate(0deg) translateX(0px) translateY(0px);
			    filter: blur(0px);
			  }
			}
			
		</style>
		<div class="pl-content-area">
	        <div class="center-media" style=" align-items: center;">
		        <div class="pl_animated_hero_5050">
			        <?php 
				        if($reversed == 1){
					        echo $imagecode; 					        
				        } else {
					    	echo $textcode; 
				        }
				    ?>
	        	</div>
	        	<div class="pl_animated_hero_5050">
		        	<?php 
			        	if($reversed == 1){
					        echo $textcode;			        
				        } else {
					    	echo $imagecode; 
				        }
			        ?>
	        	</div>
			</div>
		</div>
	   <?php
	}
}
