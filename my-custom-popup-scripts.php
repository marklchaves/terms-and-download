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
	
			// Launch brochure download form that requires agreed terms first.
			$( '.launch-brochure-form' ).click(function () {
			
				console.log('[PUM] Clicked on brochure download button.');

				// Wrap your custom code with the following logic to check
				// for the 30-day cookie.
				if (PUM.getCookie('pum_tc_agreed_to_terms_30')) {
					console.log('[PUM] Already agreed to terms (30 days).');
					console.log('[PUM] Launching second popup.');
					// Here, add your custom code to show your second popup.
					PUM.open(132);
				} else {
            		// Here, add your custom code to show the terms (first) popup.
					console.log('[PUM] Launching first popup.');
					PUM.open(190);
				}
			
			});
			
			// It'd be nice to do this, but it's being blocked right now.
			// It'd be better to change the plugin code or provide a filter.
			// TO DO: Check if there's a filter for this already.
			$( '#pum-190' ).on('pumAfterOpen', function () {
				if (PUM.getCookie('pum_tc_agreed_to_terms_30')) {
					console.log('[PUM] Adding checkmark to terms agree checkbox.'); 
					document.getElementById('pum-tc-input-1').setAttribute('checked', 'true');
				}
			});

			// Here's where we set the 30-day cookie.
			$( '#pum-190 input[type="checkbox"]' ).on('pumAgreedToTerms', function () {
				console.log('[PUM] Agreed to terms. Setting 30-day cookie.');
				$.pm_cookie(
                    'pum_tc_agreed_to_terms_30',
                    {"190": "agreed"},
                    '30 days',
                    '/'
                );
				// DEBUG
				//console.log('[PUM] activeElement 1: ', document.activeElement);
				//console.log('[PUM] Trying to close first popup.');
				
				// ISSUE: There's an issue showing a back-to-back popup when
				// they use the same default theme or display settings. The second
				// popup won't show. Below is one code workaround.
				
				// Not sure if I need this.
				//PUM.close(190);
				
				// Here, add your custom code to show your second popup.
				console.log('[PUM] Launching second popup.');
				
				// WORKAROUND: Need to force the second to display for some reason.
				//$('#pum-132').css("display", "block");
				//$('#pum-132 .pum-content.popmake-content').focus();
				//console.log('[PUM] activeElement 2: ', document.activeElement);

				// Show the second popup (back-to-back).
				PUM.open(132);
				// Will only display if the following CSS is in place (back-to-back fix).
				// https://gist.github.com/marklchaves/ffb949d75d916b64ed44f71d91ce9459
				
				console.log('[PUM] activeElement 3: ', document.activeElement);
			});
			
        }(jQuery, document))
	</script><?php
}
add_action( 'wp_footer', 'my_custom_popup_scripts', 500 );
/** 
 * Add the code above to your child theme's functions.php file or 
 * use a code snippets plugin.
 */
