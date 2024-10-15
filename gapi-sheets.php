<?php
require '../vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$range = $data['range'];
$value = $data['value'];

function getClient() {
    $client = new Google\Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google\Service\Sheets::SPREADSHEETS);
    $client->setAuthConfig('./credentials.json'); 
    $client->setAccessType('offline');
    return $client;
}

$client = getClient();
$service = new Google\Service\Sheets($client);

$spreadsheetId = '1v4whZCgceyDGwlCO96ZLxRYI7tbwdSEJAo2Ry1b1xUE'; 
$values = [
    [$value]
];
$body = new Google\Service\Sheets\ValueRange([
    'values' => $values
]);

$params = [
    'valueInputOption' => 'RAW'
];

try {
    // Update the cell
    $result = $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);

    echo json_encode([
        'message' => 'Cell updated successfully'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

?>
