# Ephemera
Ephemera is a self-destructing unencrypted data transfer protocol with an implementation in php. It is a demonstration that **encryption** is not *always necessary* for secure data transfer, at least at the data layer.

## Protocol

- A tab-delimited key-value text file is stored somewhere outside of the web root (if it does not exist, it is created when a key-value is added for the first time).
- When a user passes a single URL parameter to the script, in this case a key-value pair `$_GET["key"]="value"` (`/?key=value`) it saves the data in a non-public text file.
- When a user loads the script with a single `$_GET[]` variable (the key), e.g. `/?key`, the script reads the file and looks for a match.
    - If found, it will delete the entry from the store file, log it as used, and display it to the user.
    - If not found it will display an error corresponding to the failure.
<br />
<p align="center">
<img width="1281" height="700" alt="image" src="https://github.com/user-attachments/assets/9b45c5f2-0f87-4811-8a96-0b4866e8d945" />
</p>

## Why it Works

If the data can only be read once, any interception or leak is detectable. As the data sender, you just need to confirm the recipient has read the data to know that *only the recipient has read the data*. So the key is not to implement the system that uses the data before you confirm that the receiving party has read it. If the receiving party confirms the data is received, then nobody else has seen it. 

## Usage Examples

****Ensure that you always host the script with SSL. It will not check this. If you do not, you will be vulnerable to man-in-the-middle attacks.****

- Transfer a password to a remote recipient securely. Confirm with the recipient separately.
