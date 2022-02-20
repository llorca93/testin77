<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = '08ce35f89d4f8017ea7848e460a0917e';
    private $api_key_secret = 'c22c5e43898d109352ae77dbbf161238';

    public function send($to_email,$to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "pdevwebf3@gmail.com",
                        'Name' => 'Test ingénierie'
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3514918,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success();
    }
}