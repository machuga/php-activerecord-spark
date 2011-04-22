<?php if ( ! defined('BASEPATH')) die ('No direct script access allowed');
/*
 *
 * Class name: PHPActiveRecord
 * Initializes PHPActiveRecord and registers the autoloader
 *
 */

class PHPActiveRecord {

    public function __construct()
    {
        // Set a path to the spark root that we can reference
        $spark_path = dirname(__DIR__).'/';

        // Include the CodeIgniter Database File
        require_once APPPATH.'config/database'.EXT;

        // Include the ActiveRecord bootstrapper
        require_once $spark_path.'vendor/php-activerecord/ActiveRecord.php';

        // PHPActiveRecord allows multiple connections.
        $connections = array();

        if ($db && $active_group)
        {
            foreach ($db as $conn_name => $conn) 
            {
                // Build the DSN string for each connection
                $connections[$conn_name] =   $conn['dbdriver'].
                                    '://'   .$conn['username'].
                                    ':'     .$conn['password'].
                                    '@'     .$conn['hostname'].
                                    '/'     .$conn['database'];
            }

            // Initialize PHPActiveRecord
            ActiveRecord\Config::initialize(function ($cfg) use ($connections, $active_group) {
                $cfg->set_model_directory(APPPATH.'models/');
                $cfg->set_connections($connections);

                // This connection is the default for all models
                $cfg->set_default_connection($active_group);
            });

        }
    }
}

/* End of file PHPActiveRecord.php */
/* Location: ./sparks/php-activerecord/<version>/libraries/PHPActiveRecord.php */
