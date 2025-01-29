<?php

// Don't allow file to be viewed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class OnlyGTMSettings
{
    /**
     * The stored options
     */
    private $options;

    /**
     * Add actions
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_page' ) );
        add_action( 'admin_init', array( $this, 'init_page' ) );
    }

    /**
     * Add settings page
     */
    public function add_page()
    {
        add_options_page(
            'Settings', 
            'Only GTM', 
            'manage_options', 
            'only-gtm-settings', 
            array( $this, 'create_page' )
        );
    }

    /**
     * Create the page
     */
    public function create_page()
    {
        $this->options = get_option( 'only_gtm_options' ); ?>
        
        <div class="wrap">
            <h1>Only GTM</h1>
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'only_gtm_group' );
                    do_settings_sections( 'only-gtm-settings' );
                    submit_button();
                ?>
            </form>
        </div>
    <?php }

    /**
     * Add settings to the page
     */
    public function init_page()
    {        
        register_setting(
            'only_gtm_group',
            'only_gtm_options',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'only_gtm_section',
            'Settings',
            array( $this, 'section_content' ),
            'only-gtm-settings'
        );

        add_settings_field(
            'gtm_id', 
            'GTM ID', 
            array( $this, 'gtm_id_input' ), 
            'only-gtm-settings', 
            'only_gtm_section'
        );
    }

    /**
     * Sanitize value
     *
     * @param array $input All settings, we only have one in our case
     */
    public function sanitize( $input )
    {
        $updated_input = array();

        if ( isset( $input['gtm_id'] ) ) {
            $updated_input['gtm_id'] = sanitize_text_field( $input['gtm_id'] );
        }

        return $updated_input;
    }

    /** 
     * The text content for the section
     */
    public function section_content()
    {
        print 'Enter your GTM ID below. Remove the ID to disable.';
    }

    /** 
     * Show the GTM ID input
     */
    public function gtm_id_input()
    {
        printf(
            '<input type="text" id="gtm_id" name="only_gtm_options[gtm_id]" value="%s" placeholder="GTM-XXXXXXX" />',
            isset( $this->options['gtm_id'] ) ? esc_attr( $this->options['gtm_id'] ) : ''
        );
    }
}
