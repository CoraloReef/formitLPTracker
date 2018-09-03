<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/core/vendor/autoload.php';
use LPTracker\LPTracker;

$api = new LPTracker([
    'login'    => '*****@mail.com',
    'password' => '*****',
    'service'  => 'SDK' // service name
]);

$project = 11111; // Project Id

if (isset($_POST['name']))
{
    $name = $_POST["name"];

    $phone = $_POST["phone"];
    $phone = str_replace(array(' ','-','(',')','+'), '', strip_tags($phone));

    $customField1 = $_POST["customField1"]; // field from form
    $customField2 = $_POST["customField2"]; // field from form
    $referer = $_POST["referer"]; // information about referer from form

    $details = [
        [
            'type' => 'phone',
            'data' => $phone
        ]
    ];
    $contactData = [
        'name'       => $name
    ];

    //Создание контакта
    $contact = $api->createContact($project, $details, $contactData);

    $leadData = [
        'name'   => 'Test form name', // Lead name
        'source' => 'SDK',
        'owner'  => 0
    ];

    $leadData['custom'] = [
        [
            'id' => 111111, // custom field id
            'value' => $customField1
        ],
        [
            'id' => 222222, // custom field id
            'value' => $customField2
        ]
    ];

    $leadData['view'] = [
        'source' => $referer
    ];

    $options = [
        'callback' => false
    ];

    // Create lead
    $lead = $api->createLead($contact, $leadData, $options);

    return true;
}
else{
    return false;
}
