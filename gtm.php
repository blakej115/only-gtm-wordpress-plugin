<?php

if ( !defined('ABSPATH') ) {
	exit; // Exit if accessed directly.
}

/**
 * Our class to inject the GTM codes
 */
class OnlyGTM {
	/**
     * GTM Options
     */
    private $gtm_options;

	/**
     * GTM ID
     */
    private $gtm_id;

	/**
	 * Get GTM ID & then add actions for the GTM codes
	 */
	public function __construct()
	{
		// Get the options
		$this->gtm_options = get_option('only_gtm_options');

		// Disable GTM if the ID is empty
		if ( empty( $this->gtm_options['gtm_id'] ) ) {
			return;
		}

		// Set the GTM ID
		$this->gtm_id = $this->gtm_options['gtm_id'];

		// Add actions
		add_action( 'wp_head', array( $this, 'add_gtm' ), 0 );
		add_action( 'wp_body_open', array( $this, 'add_noscript' ), 0 );
	}

	/**
	 * Add GTM to the <head>
	 */
	function add_gtm()
	{ ?>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','<?= $this->gtm_id; ?>');</script>
		<!-- End Google Tag Manager -->
	<?php }

	/**
	 * Add noscript GTM to the opening <body>
	 */
	function add_noscript()
	{ ?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= $this->gtm_id; ?>"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
	<?php }
}
