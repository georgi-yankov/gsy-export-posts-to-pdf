<?php
if (!class_exists('GSY_Export_Posts_To_Pdf')) {

    class GSY_Export_Posts_To_Pdf {

        public function __construct() {
            add_action('admin_enqueue_scripts', array($this, 'gsy_export_posts_to_pdf_add_styles'));
            add_action('admin_menu', array($this, 'add_plugin_page'));
            add_action('admin_init', array($this, 'page_init'));
            add_action('init', array($this, 'export_to_pdf'));
        }

        /**
         * Adding styles for admin page
         */
        public function gsy_export_posts_to_pdf_add_styles($hook) {
            // Load styles only for the plugin's option page            
            if ($hook === 'settings_page_gsy-export-posts-to-pdf') {
                $style_src = plugins_url('../css/style.css', __FILE__);
                wp_enqueue_style('gsy-export-posts-to-pdf-style', $style_src);
            }
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
                    'gsy_export_posts_to_pdf_options'
            );

            add_settings_section(
                    'gsy_export_posts_to_pdf_section', // ID
                    __('Settings', 'gsy-export-posts-to-pdf'), // Title
                    array($this, 'print_section_info'), // Callback
                    'gsy-export-posts-to-pdf' // Page
            );

            add_settings_field(
                    'counter_checkbox', // ID
                    __('Counter:', 'gsy-export-posts-to-pdf'), // Title 
                    array($this, 'counter_checkbox_callback'), // Callback
                    'gsy-export-posts-to-pdf', // Page
                    'gsy_export_posts_to_pdf_section' // Section
            );

            add_settings_field(
                    'author_checkbox', // ID
                    __('Author:', 'gsy-export-posts-to-pdf'), // Title 
                    array($this, 'author_checkbox_callback'), // Callback
                    'gsy-export-posts-to-pdf', // Page
                    'gsy_export_posts_to_pdf_section' // Section
            );

            add_settings_field(
                    'category_checkbox', // ID
                    __('Categories:', 'gsy-export-posts-to-pdf'), // Title 
                    array($this, 'category_checkbox_callback'), // Callback
                    'gsy-export-posts-to-pdf', // Page
                    'gsy_export_posts_to_pdf_section' // Section
            );

            add_settings_field(
                    'comments_checkbox', // ID
                    __('Comments:', 'gsy-export-posts-to-pdf'), // Title 
                    array($this, 'comments_checkbox_callback'), // Callback
                    'gsy-export-posts-to-pdf', // Page
                    'gsy_export_posts_to_pdf_section' // Section
            );

            add_settings_field(
                    'date_checkbox', // ID
                    __('Date:', 'gsy-export-posts-to-pdf'), // Title 
                    array($this, 'date_checkbox_callback'), // Callback
                    'gsy-export-posts-to-pdf', // Page
                    'gsy_export_posts_to_pdf_section' // Section
            );
        }

        /**
         * Print the Section text
         */
        public function print_section_info() {
            
        }

        /**
         * Get the settings option array and print one of its values
         */
        public function counter_checkbox_callback() {
            echo '<label>';
            echo '<input type="checkbox" class="counter-checkbox" name="gsy_export_posts_to_pdf_options[counter_checkbox]" id="counter_checkbox" />';
            echo '  ' . __('check to count posts', 'gsy-export-posts-to-pdf');
            echo '</label>';
        }

        /**
         * Get the settings option array and print one of its values
         */
        public function author_checkbox_callback() {
            echo '<label>';
            echo '<input type="checkbox" class="author-checkbox" name="gsy_export_posts_to_pdf_options[author_checkbox]" id="author_checkbox" />';
            echo '  ' . __('check to show author', 'gsy-export-posts-to-pdf');
            echo '</label>';
        }

        /**
         * Get the settings option array and print one of its values
         */
        public function category_checkbox_callback() {
            echo '<label>';
            echo '<input type="checkbox" class="category-checkbox" name="gsy_export_posts_to_pdf_options[category_checkbox]" id="category_checkbox" />';
            echo '  ' . __('check to show categories', 'gsy-export-posts-to-pdf');
            echo '</label>';
        }

        /**
         * Get the settings option array and print one of its values
         */
        public function comments_checkbox_callback() {
            echo '<label>';
            echo '<input type="checkbox" class="comments-checkbox" name="gsy_export_posts_to_pdf_options[comments_checkbox]" id="comments_checkbox" />';
            echo '  ' . __('check to show the number of comments', 'gsy-export-posts-to-pdf');
            echo '</label>';
        }

        /**
         * Get the settings option array and print one of its values
         */
        public function date_checkbox_callback() {
            echo '<label>';
            echo '<input type="checkbox" class="date-checkbox" name="gsy_export_posts_to_pdf_options[date_checkbox]" id="date_checkbox" />';
            echo '  ' . __('check to show date', 'gsy-export-posts-to-pdf');
            echo '</label>';
        }

        public function export_to_pdf() {
            if (isset($_POST['option_page']) && ($_POST['option_page'] === 'gsy_export_posts_to_pdf_group')) {
                require plugin_dir_path(__FILE__) . 'pdf-exporter.php';
            }
        }

    }

}