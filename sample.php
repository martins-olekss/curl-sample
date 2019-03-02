<?php
// For more info in specific API, see https://api.nasa.gov/api.html#apod

// Never commit your API keys !
$params = array(
    'api_key' => 'REPLACETHISWITHYOURKEY',
    'start_date' => '2000-01-01',
    'end_date' => '2000-01-04'
);

// Build ULR with parameters
$url = 'https://api.nasa.gov/planetary/apod?' . http_build_query($params);

// Initialize curl resource
$ch = curl_init();
// Set request URL ( with params )
curl_setopt($ch, CURLOPT_URL, $url);
// Return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);

// Store HTTP response code
// In current example not required, but can be used to determine if request was successful
//$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Store possible Curl errors
// If request was successful this variable will be empty string
$error = curl_error($ch);

// Close curl resource
curl_close($ch);

/*
 * PLEASE NOTE
 * Further code is developed taking
 * in mind specific api and response in returns
 */

// JSON expected, decode to get PHP objects
/*
 * Pass TRUE as second parameter in json_decode
 * to get Assoc Array instead of objects
 */
$result = json_decode($output);
?>

<html>
<head>
    <title>Title</title>
</head>
<body>
<?php foreach ($result as $item): ?>
    <h3><?= $item->date ?></h3>
    <?php
    // media_type can be non-image,
    // don't show img element if type is not image
    if ($item->media_type === 'image'):?>
        <p>
            <img src="<?= $item->url ?>"/>
        </p>
    <?php endif; ?>
    <p>
        <?= $item->explanation ?>
    </p>
<?php endforeach; ?>
</body>
</html>
