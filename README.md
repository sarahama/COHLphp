# COHLphp
php files
These files will connect to WHW's db using the config_db.php credentials. 
The images folder holds several stock photos, the other files are scripts for retrieving data. 
The connect.php file uses the credentials in the config file to connect to the database.
Files that begin with a class declaration exist for various models, such as users and events.
These files should contain methods that execute queries related to the model, such as updating info or retrieving info.
See get_events.php for an example.
Other php files are called directly from the swift files. They contain the workflow for certain use cases and call the
methods mentioned above. These files typically begin by instantiating one of the files containing the required queries.
For an example, manage_events.php uses the get_events.php file. Examine these files to understand how config_db.php, 
connect.php, get_events.php, and manage_events.php all work together. This is the general pattern.

