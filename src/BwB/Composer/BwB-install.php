<?php namespace BwB\Composer;
/**
 * BwB Composer Installer
 *
 * @package BwB/Composer;
 * @subpackage Installer
 * @category Installer
 * @author Brian Greenacre <bgreenacre42@gmail.com>
 * @version $id$
 */

use Composer\Script\Event;

/**
 * Provides a number of tasks that can be done
 * after a composer event is fired.
 *
 * @package BwB/Composer
 * @subpackage Tasks
 * @category Tasks
 */
class BwBInstall {

    /**
     * Array of default config values.
     *
     * @access public
     * @var array
     */
    public static $params = array(
        'wordpress_wp_contentdir' => 'wordpress/wp-content',
        'bwb_wp_coredir'       => 'wordpress/core',
        'vendor-dir'              => null,
        'bwb_wp_config'     => array(
            'site_url'           => 'http://localhost',
            'db_host'            => 'localhost',
            'db_name'            => 'wordpress',
            'db_user'            => 'root',
            'db_pass'            => '',
            'db_charset'         => 'utf8',
            'db_collate'         => '',
            'db_prefix'          => 'wp_',
            'generate_auth_key_string' => true,
            'wp_lang'            => '',
            'wp_debug'           => false,
            'disallow_file_edit' => false,
            'wp_content_url'      => null,
            'wp_content_dir'     => null,
        ),
    );

    /**
     * Generate a wp-config.php and place it into
     * the wordpress core folder.
     *
     * @access public
     * @param  Event  $event Event object
     * @return void
     */
    public static function bwb_config(Event $event)
    {
        // Get the params from the class and merge
        // any defined inside composer.json file.
        $params = self::$params;
        $extra  = $event->getComposer()->getPackage()->getExtra();

        if (is_array($extra))
        {
            $params['bwb_wp_coredir'] = (isset($extra['bwb_wp_coredir']))
                ? $extra['bwb_wp_coredir']
                : $params['bwb_wp_coredir'];

            $params['wordpress_wp_contentdir'] = (isset($extra['wordpress_wp_contentdir']))
                ? $extra['wordpress_wp_contentdir']
                : $params['wordpress_wp_contentdir'];

            if (isset($extra['bwb_wp_config']))
            {
                $params['bwb_wp_config'] = array_merge(
                    self::$params['bwb_wp_config'],
                    $extra['bwb_wp_config']
                );
            }
        }

        // Set the wp content url
        $bwb_content_url = (is_null($params['bwb_wp_config']['wp_content_url']))
            ? (rtrim($params['bwb_wp_config']['site_url'], '/') . '/wp-content')
            : $params['bwb_wp_config']['wp_content_url'];

        // Generate the auth salts or use default values.
        if (true === $params['bwb_wp_config']['generate_auth_key_string'])
        {
            $auth_key_string = file_get_contents('https://api.wordpress.org/secret-key/1.1/salt/');
        }
        else
        {
			$key_names = array(
				'AUTH_KEY', 
				'SECURE_AUTH_KEY', 
				'LOGGED_IN_KEY', 
				'NONCE_KEY',
				'AUTH_SALT',
				'SECURE_AUTH_SALT',
				'LOGGED_IN_SALT',
				'NONCE_SALT',
			);
			
			$auth_key_string = '';

			$pw_hash_options = [
				'cost' => 12,
			];
			foreach ($key_names as $auth_key) {
				$auth_key_string .= "define('" . $auth_key . "',  '" . password_hash(generate_random_string(60) . $auth_key, PASSWORD_BCRYPT, $pw_hash_options) . "');\n";
			}
        }

        // Set the wp content directory.
        if ( ! is_null($params['bwb_wp_config']['wp_content_dir']))
        {
            $bwb_config_content_dir = "'" . $params['bwb_wp_config']['i'] . "'";
        }
        else
        {
            $bwb_config_content_dir = '__DIR__ . \'/wp-content\'';
        }

        $bwb_config_params = array(
            ':wp_content_dir'          => $bwb_config_content_dir,
            ':site_url'                => $params['bwb_wp_config']['site_url'],
            ':db_host'                 => $params['bwb_wp_config']['db_host'],
            ':db_name'                 => $params['bwb_wp_config']['db_name'],
            ':db_user'                 => $params['bwb_wp_config']['db_user'],
            ':db_pass'                 => $params['bwb_wp_config']['db_pass'],
            ':db_charset'              => $params['bwb_wp_config']['db_charset'],
            ':db_collate'              => $params['bwb_wp_config']['db_collate'],
            ':db_prefix'               => $params['bwb_wp_config']['db_prefix'],
            ':wp_lang'                 => $params['bwb_wp_config']['wp_lang'],
            ':wp_debug'                => (false !== $params['bwb_wp_config']['wp_debug']) ? 'true' : 'false',
            ':disallow_file_edit'      => (false !== $params['bwb_wp_config']['disallow_file_edit']) ? 'true' : 'false',
            ':bwb_content_url'          => $bwb_content_url,
            ':auth_key_string'               => $auth_key_string,
            ':vendor_dir'              => $event->getComposer()->getConfig()->get('vendor-dir'),
        );

        // Get the wp-config template file content.
        $bwb_config = file_get_contents(__DIR__ . '/../../../templates/wp-config.php-dist');

        // Replace tokens with values.
        $bwb_config = str_replace(
            array_keys($bwb_config_params),
            $bwb_config_params,
            $bwb_config
        );

        // Write the wp-config.php file.
        file_put_contents($params['bwb_wp_coredir'] . '/wp-config.php', $bwb_config);
    }
    
    private static generate_random_string($length) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}

}
