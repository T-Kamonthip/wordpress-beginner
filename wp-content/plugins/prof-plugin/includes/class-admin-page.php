<?php

class PAP_Admin_Page {

    public function __construct() {

        add_action('admin_menu', [$this, 'create_menu']);
        add_action('admin_init', [$this, 'register_settings']);

    }

    public function create_menu() {

        add_options_page(
            'API Plugin Settings',
            'API Plugin',
            'manage_options',
            'pap-settings',
            [$this, 'settings_page']
        );

    }

    public function register_settings() {

        register_setting('pap_settings_group', 'pap_api_key');

    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>API Plugin Settings</h1>

            <form method="post" action="options.php">

                <?php settings_fields('pap_settings_group'); ?>

                <table class="form-table">
                    <tr>
                        <th>API Key</th>
                        <td>
                            <input type="text" 
                            name="pap_api_key" 
                            value="<?php echo esc_attr(get_option('pap_api_key')); ?>" 
                            />
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>

            </form>
        </div>
        <?php
    }

}