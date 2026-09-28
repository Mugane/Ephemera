<?php
define('SAFE_BASE_DIR', '/tmp'); // Safe non-public directory to use for variable storage
define('DATA_STORE', SAFE_BASE_DIR.'/ephemerals.txt');
define('NON_NOVELS', SAFE_BASE_DIR.'/used_keys.txt');
$data   = [];
$output = 'Usage: <b><i>?key=value</i></b> to save, or <b><i>?key</i></b> to retrieve.';

function save_ephemeral_data($data) { // Save single-read data to file:
    $content = '';
    foreach ($data as $k => $v) $content .= "$k\t$v\n";
    return file_put_contents(DATA_STORE, $content);
}

function is_novel($key) { // Check that key is novel:
    return !in_array($key, @file(NON_NOVELS) ?: []);
}

function blacklist($key) { // Prevent key re-use
    $lines = @file(NON_NOVELS) ?: [];
    $lines[] = $key;
    file_put_contents(NON_NOVELS, implode("\n", $lines));
}

$content = @file_get_contents(DATA_STORE); // We always read it because it's used for storing as well as displaying:
if ($content !== false) {
    $lines = explode("\n", trim($content));
    foreach ($lines as $line) {
        if (!empty($line)) {
            list($key, $value) = explode("\t", $line);
            $data[$key] = $value;
        }
    }
}

if (count($_GET) === 1 && array_values($_GET)[0] !== '') { // ?key=value used to store data:
    $key = array_key_first($_GET);
    if(is_novel($key)) {
        $data[$key] = array_values($_GET)[0];
        save_ephemeral_data($data);
        $output = 'Data added successfully for key: <b><i>'.htmlspecialchars($key).'</i></b>';
    }
    else $output = 'Key <b><i>'.htmlspecialchars($key).'</i></b> has already been used, and you cannot reuse keys. Select another key.';
}

if (count($_GET) === 1 && array_values($_GET)[0] === '') { // ?key is a request for a data name without a set value (read):
    $keys = array_keys($_GET);
    $key = $keys[0];
    if (array_key_exists($key, $data)) {
        $entry = $data[$key];
        unset($data[$key]);
        save_ephemeral_data($data);
        blacklist($key); // Prevent re-use of the key, which could be a sneaky man-in-the-middle type sniffer
        $output = 'Your single-view data is below. It will not be viewable again:</br><div class="password">'.htmlspecialchars($entry).'</div>';
    }
    else if(is_novel($key)) $output = 'There is no data to display for your request. Please try a different key.';
    else $output = 'The data requested has already been displayed and cannot be displayed again.';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>One-Time Data Viewer</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            text-align: center;
            font-size: 14px;
            color: rgba(0,0,0,0.7);
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .password {
            font-size: 24px;
            color: rgba(0,0,0,1);
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container"><?php echo $output; ?></div>
</body>
</html>
