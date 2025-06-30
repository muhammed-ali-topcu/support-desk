<?php

namespace App\Services;

use Exception;
use Google_Client;
use Google_Service_Gmail;

class GmailService
{
    private $client;
    private $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(config('services.gmail.client_id'));
        $this->client->setClientSecret(config('services.gmail.client_secret'));
        $this->client->setRedirectUri(config('services.gmail.redirect_uri'));
        $this->client->setScopes([
            Google_Service_Gmail::GMAIL_READONLY,
            Google_Service_Gmail::GMAIL_LABELS,
        ]);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        $this->service = new Google_Service_Gmail($this->client);
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function setAccessToken($token)
    {
        $this->client->setAccessToken($token);
    }

    public function exchangeCodeForToken($code)
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);

        if (array_key_exists('error', $token)) {
            throw new Exception('Error fetching access token: ' . $token['error']);
        }

        return $token;
    }

    public function refreshToken($refreshToken)
    {
        $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
        return $this->client->getAccessToken();
    }

    public function getInboxEmails($maxResults = 10, $pageToken = null)
    {
        try {
            $optParams = [
                'maxResults' => $maxResults,
                'labelIds'   => ['INBOX'],
                'pageToken'  => $pageToken,
            ];

            $messages = $this->service->users_messages->listUsersMessages('me', $optParams);
            $emails   = [];

            if ($messages->getMessages()) {
                foreach ($messages->getMessages() as $message) {
                    $messageDetail = $this->service->users_messages->get('me', $message->getId());
                    $emails[]      = $this->parseMessage($messageDetail);
                }
            }

            return [
                'emails'        => $emails,
                'nextPageToken' => $messages->getNextPageToken(),
            ];

        } catch (Exception $e) {
            throw new Exception('Error retrieving emails: ' . $e->getMessage());
        }
    }

    public function searchEmails($query, $maxResults = 10)
    {
        try {
            $optParams = [
                'maxResults' => $maxResults,
                'q'          => $query,
            ];

            $messages = $this->service->users_messages->listUsersMessages('me', $optParams);
            $emails   = [];

            if ($messages->getMessages()) {
                foreach ($messages->getMessages() as $message) {
                    $messageDetail = $this->service->users_messages->get('me', $message->getId());
                    $emails[]      = $this->parseMessage($messageDetail);
                }
            }

            return $emails;

        } catch (Exception $e) {
            throw new Exception('Error searching emails: ' . $e->getMessage());
        }
    }

    private function parseMessage($message)
    {
        $headers = $message->getPayload()->getHeaders();

        $email = [
            'id'        => $message->getId(),
            'thread_id' => $message->getThreadId(),
            'snippet'   => $message->getSnippet(),
            'timestamp' => date('Y-m-d H:i:s', $message->getInternalDate() / 1000),
            'subject'   => '',
            'from'      => '',
            'to'        => '',
            'body'      => '',
            'labels'    => $message->getLabelIds(),
        ];

        // Extract headers
        foreach ($headers as $header) {
            switch (strtolower($header->getName())) {
                case 'subject':
                    $email['subject'] = $header->getValue();
                    break;
                case 'from':
                    $email['from'] = $header->getValue();
                    break;
                case 'to':
                    $email['to'] = $header->getValue();
                    break;
                case 'date':
                    $email['date'] = $header->getValue();
                    break;
            }
        }

        // Extract body
        $email['body'] = $this->extractBody($message->getPayload());

        return $email;
    }

    private function extractBody($payload)
    {
        $body = '';

        if ($payload->getParts()) {
            foreach ($payload->getParts() as $part) {
                if ($part->getMimeType() == 'text/plain' || $part->getMimeType() == 'text/html') {
                    $data = $part->getBody()->getData();
                    $body = base64url_decode($data);
                    break;
                } elseif ($part->getParts()) {
                    $body = $this->extractBody($part);
                    if (!empty($body)) {
                        break;
                    }

                }
            }
        } else {
            $data = $payload->getBody()->getData();
            if ($data) {
                $body = base64url_decode($data);
            }
        }

        return $body;
    }
}

function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}
