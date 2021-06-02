<?php

/**
 * My Custom Popup Scripts
 */
/**
 *  Add custom JavaScript for Popup Maker to the footer of your site.
 */
function my_custom_popup_scripts() { ?>
	<script type="text/javascript">
						
		(function ($, document, undefined) {
			
			// Force scroll top. Needs custom CSS to work.
			$( '#pum-16' ).on('pumAfterOpen', function () {
				// DEBUG
				console.log('[PUM] scrollTop before = ' + $( '#popmake-16' ).scrollTop());
				if ( $( '#popmake-16' ).scrollTop() !== 0) { // Only scroll to top if needed.
					$( '#popmake-16' ).scrollTop(0);
					// DEBUG
					console.log('[PUM] scrollTop after = ' + $( '#popmake-16' ).scrollTop());
				}
			});
	
			// Utility Class for back-to-back popup sequences.		
			function BackToBackPopups( p1 = '', p2 = '' ) {
				this.popup1 = p1;
				this.popup2 = p2;
				this.setPopup1 = function( p1 ) {
					this.popup1 = p1;
				}
				this.setPopup2 = function( p2 ) {
					this.popup1 = p2;
				}
			}
			var backToBackPopups; // Global back-to-back object.
			
			// IIFE for setting up the brochure download listener.
			(function() {
				$( '#btn-launch-brochure-download-1' ).click(function () {
			
					// DEBUG
					console.log('[PUM] Clicked on brochure download button.');
				
					// Grab the first and second popup IDs from the data attributes.
					var p1 = $( '#btn-launch-brochure-download-1' ).data( 'popup1');
					var p2 = $( '#btn-launch-brochure-download-1' ).data( 'popup2');
					
					if ( !p1 || !p2 ) return;
				
					// Store the popup IDs for later.
					backToBackPopups = new BackToBackPopups( p1, p2 ); // Instantiate the global back-to-back object.

					// DEBUG
					console.log(`[PUM] Popup 1 is ${p1} and popup 2 is ${p2}`);

					// Wrap your custom code with the following logic to check
					// for the 30-day cookie.
					if (PUM.getCookie('pum_tc_agreed_to_terms_30')) {
						
						// DEBUG
						console.log('[PUM] Already agreed to terms (30 days).');
						console.log(`[PUM] Launching second popup #${p2}.`);
						
						// Here, add your custom code to show your second popup.
						PUM.open( parseInt( p2 ) );
					} else {
            			// Here, add your custom code to show the terms (first) popup.
						
						// DEBUG
						console.log(`[PUM] Launching first popup #${p1}.`);
						
						PUM.open( parseInt( p1 ) );
					}
			
				});
			})();

			// IIFE for setting up the terms agreement checkbox click.
			(function() {
				// Here's where we set the 30-day cookie.
				//$( '.pum-content.popmake-content input[type="checkbox"]' ).on('pumAgreedToTerms', function () {
				$( '.pum-tc-box__checkbox.popmake-tcp-input' ).on('pumAgreedToTerms', function () {

					var popupId = backToBackPopups.popup1;
					
					if ( !popupId ) return;

					// Just make sure the first popup is closed.
					PUM.close( parseInt( popupId ) );

					// DEBUG
					console.log(`[PUM] popupId = ${popupId}`);				
					console.log('[PUM] Agreed to terms. Setting 30-day cookie.');
				
					$.pm_cookie(
                    	'pum_tc_agreed_to_terms_30',
                    	{[popupId]: "agreed"},
                    	'30 days',
                    	'/'
                	);
				
					// Here, add your custom code to show your second popup.
				
					// DEBUG
					console.log(`[PUM] Launching second popup #${backToBackPopups.popup2}.`);

					// Show the second popup (back-to-back).
					PUM.open( parseInt( backToBackPopups.popup2 ) );
					// Will only display if the following CSS is in place (back-to-back fix).
					// https://gist.github.com/marklchaves/ffb949d75d916b64ed44f71d91ce9459
				});
			})();
			
        }(jQuery, document))
	</script><?php
}
add_action( 'wp_footer', 'my_custom_popup_scripts', 500 );
/** 
 * Add the code above to your child theme's functions.php file or 
 * use a code snippets plugin.
 */
