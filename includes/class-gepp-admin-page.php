<?php
if (!class_exists('GSY_Gepp_Admin_Page')) {

    class GSY_Gepp_Admin_Page {

        /**
         * Holds the values to be used in the fields callbacks
         */
        private $_options;

        public function __construct() {
            add_action('admin_enqueue_scripts', array($this, 'gsy_export_posts_to_pdf_add_scripts'));
            add_action('admin_menu', array($this, 'add_plugin_page'));
            add_action('admin_init', array($this, 'page_init'));
        }

        /**
         * Adding scripts for admin page
         */
        public function gsy_export_posts_to_pdf_add_scripts() {
            $script_src = plugins_url('../js/script.js', __FILE__);
            wp_enqueue_script('gsy-export-posts-to-pdf-script', $script_src, array('jquery'));
        }

        /**
         * Add options page
         */
        public function add_plugin_page() {
            // This page will be under "Settings"
            add_options_page(__('GSY Export Posts to PDF', 'gsy-export-posts-to-pdf'), __('Export Posts to PDF', 'gsy-export-posts-to-pdf'), 'manage_options', 'gsy-export-posts-to-pdf', array($this, 'create_admin_page'));
        }

        /**
         * Options page callback
         */
        public function create_admin_page() {
            $this->_options = get_option('gsy_export_posts_to_pdf_options');
            $form_action = plugins_url() . '/gsy-export-posts-to-pdf/gsy-pdf-exporter.php';
            ?>
            <div id="gsy-export-posts-to-pdf" class="wrap">
                <h2><?php _e('GSY Export Posts to PDF', 'gsy-export-posts-to-pdf'); ?></h2>           
                <form method="post" action="<?php echo $form_action; ?>" role="form" target="_blank">
                    <?php
                    // This prints out all hidden setting fields
                    settings_fields('gsy_export_posts_to_pdf_group');
                    do_settings_sections('gsy-export-posts-to-pdf');
                    submit_button(__('Export to PDF', 'gsy-export-posts-to-pdf'));
                    ?>
                </form>
            </div><!-- #gsy-export-posts-to-pdf -->
            <?php
        }

        /**
         * Register and add settings
         */
        public function page_init() {
            register_setting(
                    'gsy_export_posts_to_pdf_group', // Option group
                    'gsy_export_posts_to_pdf_options', // Option name
                    array($this, 'sanitize') // Sanitize
            );

            add_settings_section(
                    'gsy_export_posts_to_pdf_section', // ID
                    __('Settings', 'gsy-export-posts-to-pdf'), // Title
                    array($this, 'print_section_info'), // Callback
                    'gsy-export-posts-to-pdf' // Page
            );

            add_settings_field(
                    'category_checkbox', // ID
                    __('Categories:', 'gsy-export-posts-to-pdf'), // Title 
                    array($this, 'category_checkbox_callback'), // Callback
                    'gsy-export-posts-to-pdf', // Page
                    'gsy_export_posts_to_pdf_section' // Section
            );
        }

        /**
         * Sanitize each setting field as needed
         *
         * @param array $input Contains all settings fields as array keys
         */
        public function sanitize($input) {
            return $input;
        }

        /**
         * Print the Section text
         */
        public function print_section_info() {
            
        }

        /**
         * Get the settings option array and print one of its values
         */
        public function category_checkbox_callback() {
            if (isset($this->_options['category_checkbox'])) {
                $checked = checked($this->_options['category_checkbox'], 'on', false);
            } else {
                $checked = '';
            }

            echo '<label>';
            echo '<input type="checkbox" class="category-checkbox" name="gsy_export_posts_to_pdf_options[category_checkbox]" id="category_checkbox" ' . $checked . ' />';
            echo '  ' . __('check to show categories', 'gsy-export-posts-to-pdf');
            echo '</label>';
        }

    }

}