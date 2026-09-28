# Ephemera
Ephemera is a self-destructing unencrypted data transfer protocol with an implementation in php. It is a demonstration that **encryption** is not *always necessary* for secure data transfer, at least at the data layer.

## Protocol

- A tab-delimited key-value text file is stored somewhere outside of the web root (if it does not exist, it is created when a key-value is added for the first time).
- When a user passes a special set of two parameters to the script, in this case `$_GET["key"]` and `$_GET["value"]` it saves the key value pair in the text file (in this case designed to be above the web root).
- When a user loads the script with a single `$_GET[]` variable (the key), e.g. `/?username`, the script reads the file and looks for a match.
    - If found, it will delete the entry from the file, and display it to the user.
    - If not found it will display an error such as "Cannot retrieve this value because it does not exist or has already been requested and can only be requested once."
<br />
<p align="center"><img width="908" height="504" style="margin:0px auto;" alt="Screenshot from 2025-08-20 11-44-24" src="https://github.com/user-attachments/assets/0dfbe797-f7b2-4a37-9f02-ff45ccd07905" /></p>

## Why it Works

If the data can only be read once, any interception or leak is detectable. As the data sender, you just need to confirm the recipient has read the data. So the key is not to implement the system that uses the data before you confirm that the receiving party has read it. If the receiving party confirms the data is received, then nobody else has seen it. 

## Usage Examples

****Ensure that you always host the script with SSL. It will not check this. If you do not, you will be vulnerable to man-in-the-middle attacks.****

- Transfer a password to a remote recipient securely. Confirm with the recipient separately.
