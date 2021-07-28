<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = '978798965f95898127077cf7a556955b';
    private $api_key_secret = 'ba7bb5c06e847a0e649ecae4e1b35dda';

    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => 'fares.alib@protonmail.com',
                        'Name' => 'La Boutique Française',
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name,
                        ],
                    ],
                    'TemplateID' => 3064351,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ],
                ],
            ],
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}