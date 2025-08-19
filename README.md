# Ephemeral
Ephemeral is a self-destructing unencrypted data transfer protocol with an implementation in php.

## Protocol

A tab-delimited key-value text file is stored somewhere outside of the web root (if it does not exist, it is created when a key-value is added for the first time). 
When a user passes a special set of two parameters to the script, in this case `$_GET["otu"]` and `$_GET["otp"]` it saves the key value pair in the text file above the web root.
When a user loads the script with a single $_GET[] variable with a key, e.g. `/?username`, the script reads the file and looks for a match. If found, it will delete the entry from the file, and display it to the user. If not found it will display an error such as "Cannot retrieve this value because it does not exist or has already been requested and can only be requested once."

