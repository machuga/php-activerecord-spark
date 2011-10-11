PHPActiveRecord Spark
====================

[PHPActiveRecord](http://phpactiverecord.com) is an open source ORM library,
largely based on [Ruby on Rails](http://rubyonrails.com)' ActiveRecord.

This spark is used to easily integrate PHPActiveRecord into CodeIgniter 2.0+.

**NOTE:** PHPActiveRecord requires PHP5.3+, logging requires the PEAR Log library.

Installation
------------

### Sparks Manager

Navigate to the root of your CodeIgniter project and run

    php tools/spark install php-activerecord

### Manually 

* Navigate to your CodeIgniter project's 'sparks' folder
* Extract the php-activerecord spark here, ensure it is named 'php-activerecord'

Configuration
------------

PHPActiveRecord will use the config/database.php file to determine your
database settings.  It is capable of handling several connections, but will
default to your `$active_group` connection.  You may change the connection any
model uses within the model itself.

PHPActiveRecord does not require you to define your database tables before use,
simply extend your model from the `ActiveRecord\Model` class and your model
will be ready for use (aside from any extra configuration you may want to add
later).

### Using with modules

PHPActiveRecord can be used in a modular application. After the spark is loaded,
you can call, for example in a `users` module:

    $this->phpactiverecord->add_model_path('modules/users/models');
    
When calling a model method for the first time, PHPActiveRecord's autoload 
function will look for a model in each model path, starting with the 
most-recently added path.

Documentation
------------

Examples, documentation, and help forums are available at
http://phpactiverecord.com.

Verify PHPActiveRecord Works
---------------------------

Create a table in your database named `tests` and give it some test
information, perhaps an id and a varchar column.  Create at least one or two
records.

Create a new file in your models directory named 'Test.php'

Give model the following content:

    <?php

    class Test extends ActiveRecord\Model {
            
    }



Proceed to 'welcome.php' within your controllers directory

Within the index function, enter the following prior to the view being called

    $this->load->spark('php-activerecord/1.0');
    echo '<pre>'; var_dump(Test::all()); exit;

If you've followed the steps above, you should now see a print out of your
object, with the class of your Model.  Success!  PHPActiveRecord is now ready
for use!

Caveats
------

PHPActiveRecord's model autoloader is currently case-sensitive and needs the
file name to match the class name exactly.  If enough people want to use
lowercase file names, I will add this as a configuration option.  The only
reason this wasn't done initially was to keep the php-activerecord library
as-is without modifying any vendor files.


Contact and Credit
-----------------

[PHPActiveRecord](http://phpactiverecord.com) was created and is maintained by
Kien La and Jacques Fuentes.  I am not associated with the developers of this
project, but love the work they've done and want to make it easily accessible
to the CodeIgniter community.

This spark was created and is maintained by 
[Matthew Machuga](http://matthewmachuga.com), is hosted on [GitHub](http://github.com),
and is made possible by the [GetSparks](http://getsparks.org) team.  Please support their project!
