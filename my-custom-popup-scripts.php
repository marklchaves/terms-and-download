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
			//$( '.launch-brochure-form' ).click(function () {
			$( '#btn-launch-brochure-download-1' ).click(function () {
			
				console.log('[PUM] Clicked on brochure download button.');
				
				var p1 = $( '#btn-launch-brochure-download-1' ).data( 'popup1');
				var p2 = $( '#btn-launch-brochure-download-1' ).data( 'popup2');
				console.log(`[PUM] Popup 1 is ${p1} and popup 2 is ${p2}`);

				// Wrap your custom code with the following logic to check
				// for the 30-day cookie.
				if (PUM.getCookie('pum_tc_agreed_to_terms_30')) {
					console.log('[PUM] Already agreed to terms (30 days).');
					console.log('[PUM] Launching second popup.');
					// Here, add your custom code to show your second popup.
					PUM.open(parseInt(p2));
				} else {
					// Here, add your custom code to show the terms (first) popup.
					console.log('[PUM] Launching first popup.');
					PUM.open(parseInt(p1));
				}
		
			});
		
			// It'd be nice to display a checked checkbx, but it's being blocked right
			// now It'd be better to change the plugin code or provide a filter.
			// TO DO: Check if there's a filter for this already.
			$( '#pum-190' ).on('pumAfterOpen', function () {
				if (PUM.getCookie('pum_tc_agreed_to_terms_30')) {
					console.log('[PUM] Adding checkmark to terms agree checkbox.'); 
					document.getElementById('pum-tc-input-1').setAttribute('checked', 'true');
				}
			});

			// Here's where we set the 30-day cookie.
			//$( '#pum-190 input[type="checkbox"]' ).on('pumAgreedToTerms', function () {
			$( '#pum-tc-input-1' ).on('pumAgreedToTerms', function () {

				var parentOfCheckbox = $( '#pum-tc-input-1' ).parents( '.pum-container' );
				console.log('[PUM] parentOfCheckbox =', parentOfCheckbox);

				var popupId = parentOfCheckbox.attr('id').split('-').pop();

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
				console.log('[PUM] Launching second popup.');

				// Show the second popup (back-to-back).
				PUM.open(132);
				// Will only display if the following CSS is in place (back-to-back fix).
				// https://gist.github.com/marklchaves/ffb949d75d916b64ed44f71d91ce9459
			});
		
		}(jQuery, document))
	</script><?php
}
add_action( 'wp_footer', 'my_custom_popup_scripts', 500 );
/** 
 * Add the code above to your child theme's functions.php file or 
 * use a code snippets plugin.
 */
