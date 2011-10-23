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
                // Build the DSN string for each connection
                $connections[$conn_name] =   $conn['dbdriver'].
                                    '://'   .$conn['username'].
                                    ':'     .$conn['password'].
                                    '@'     .$conn['hostname'].
                                    '/'     .$conn['database'];
            }

            // Initialize PHPActiveRecord
            ActiveRecord\Config::initialize(function ($cfg) use ($connections, $active_group) {
		        $cfg->add_model_directory(APPPATH.'models/');
                $cfg->set_connections($connections);

                // This connection is the default for all models
                $cfg->set_default_connection($active_group);
            });

        }
    }
	
	/**
	 * Add a model path for the AR autoloader to search in
	 * 
	 * @param string $path
	 * @param bool $absolute If true, treat path as an absolute filesystem path
	 * @return bool
	 */
	public function add_model_path($path = '', $absolute = false)
	{
		if(is_array($path)) return $this->add_model_paths($path);
		
		try {
			ActiveRecord\Config::instance()->add_model_directory($absolute ? $path : APPPATH.$path);
		}
		catch (ActiveRecord\ConfigException $cx)
		{
			log_message('error','PHPActiveRecord Exception: '.$cx->getMessage());
			return false;
		}
	}
	
}

/* End of file PHPActiveRecord.php */
/* Location: ./sparks/php-activerecord/<version>/libraries/PHPActiveRecord.php */
