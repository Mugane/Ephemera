<?php
$data_file = '../../onetimeviewdata.txt';
$ephemeral_data = [];
$output = '';

function save_ephemeral_data($data_file, $data) {
    $content = '';
    foreach ($data as $k => $v) {
        $content .= "$k\t$v\n";
    }
    return file_put_contents($data_file, $content);
}

$content = file_get_contents($data_file);
if ($content !== false) {
    $lines = explode("\n", trim($content));
    foreach ($lines as $line) {
        if (!empty($line)) {
            list($key, $value) = explode("\t", $line);
            $ephemeral_data[$key] = $value;
        }
    }
}

if (isset($_GET['key']) && isset($_GET['value'])) {
    $ephemeral_data[$_GET['key']] = $_GET['value'];
    save_ephemeral_data($data_file, $ephemeral_data);
    $output = 'Data added successfully for key: ' . htmlspecialchars($_GET['key']);
}

if (isset($_GET) && count($_GET) == 1) {
    $keys = array_keys($_GET);
    $key = $keys[0];
    if (array_key_exists($key, $ephemeral_data)) {
        $display_password = $ephemeral_data[$key];
        unset($ephemeral_data[$key]);
        save_ephemeral_data($data_file, $ephemeral_data);
        $output = 'Your single-view data is below. It will not be viewable again:</br><div class="password">' . htmlspecialchars($display_password) . '</div>';
    } else {
        $output = 'The data requested has already been displayed and cannot be displayed again.';
    }
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
    <div class="container">
        <?php echo $output; ?>
    </div>
</body>
</html>
