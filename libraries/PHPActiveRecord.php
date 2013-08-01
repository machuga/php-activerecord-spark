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

        // Include the CodeIgniter database config file
        // Is the config file in the environment folder?
        if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))
        {
            if ( ! file_exists($file_path = APPPATH.'config/database.php'))
            {
                show_error('PHPActiveRecord: The configuration file database.php does not exist.');
            }
        }

        require($file_path);

        // Include the ActiveRecord bootstrapper
        require_once $spark_path.'vendor/php-activerecord/ActiveRecord.php';

        // PHPActiveRecord allows multiple connections.
        $connections = array();

        if ($db && $active_group)
        {
            foreach ($db as $conn_name => $conn)
            {
                // in the case of the postgre driver, a conversion is needed
                $dbdriver = $conn['dbdriver'] == 'postgre' ? 'pgsql' : $conn['dbdriver']; 
                // Build the DSN string for each connection
                $connections[$conn_name] =       $dbdriver.
                                    '://'       .$conn['username'].
                                    ':'         .$conn['password'].
                                    '@'         .$conn['hostname'].
                                    '/'         .$conn['database'].
                                    '?charset=' .$conn['char_set'];
            }

            // Initialize PHPActiveRecord
            ActiveRecord\Config::initialize(function ($cfg) use ($connections, $active_group) {
                $cfg->set_model_directory(APPPATH.'models/');
                $cfg->set_connections($connections);

                // This connection is the default for all models
                $cfg->set_default_connection($active_group);

                // To enable logging and profiling, install the Log library 
                // from pear, create phpar.log inside of your application/logs 
                // directory, then uncomment the following block:

                /*
                $log_file = $_SERVER['DOCUMENT_ROOT'].'/application/logs/phpar.log';

                if (file_exists($log_file) and is_writable($log_file)) {
                    include 'Log.php';
                    $logger = Log::singleton('file', $log_file ,'ident',array('mode' => 0664, 'timeFormat' =>  '%Y-%m-%d %H:%M:%S')); 
                    $cfg->set_logging(true);
                    $cfg->set_logger($logger);
                } else {
                    log_message('warning', 'Cannot initialize logger. Log file does not exist or is not writeable');
                }
                */
            });

        }
    }
}

/* End of file PHPActiveRecord.php */
/* Location: ./sparks/php-activerecord/<version>/libraries/PHPActiveRecord.php */
