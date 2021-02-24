<?php

use Ypho\RSA\Message;

include_once '../../vendor/autoload.php';

$request = $_POST;
$arrResponse['success'] = true;

// Determine some actions
try {
    switch ($request['action'] ?? '') {
        case 'generate_keypair':
            $rsa = new Ypho\RSA\KeyPair((int)$request['p'], (int)$request['q']);
            $arrResponse['keys'] = $rsa->getKeyPair();
            break;

        case 'encrypt_message':
            // Get public key, and set it to the Message object
            $pubkey = json_decode(str_replace(['{', '}'], ['[', ']'], $request['pubkey']));
            if(!isset($pubkey[0]) || !isset($pubkey[1])) {
                throw new Exception('Please provide a public key in format: {e, N}');
            }

            $msg = new Message();
            $msg->setPublicKey(['e' => $pubkey[0], 'N' => $pubkey[1]]);

            $arrResponse['encrypted_message'] = $msg->encrypt($request['message_to_encrypt']);
            break;

        case 'decrypt_message':
            // Get private key, and set it to the Message object
            $privateKey = json_decode(str_replace(['{', '}'], ['[', ']'], $request['privkey']));
            if(!isset($privateKey[0]) || !isset($privateKey[1])) {
                throw new Exception('Please provide a private key in format: {d, N}');
            }

            $msg = new Message();
            $msg->setPrivateKey(['d' => $privateKey[0], 'N' => $privateKey[1]]);

            $arrResponse['decrypted_message'] = $msg->decrypt(explode(',', $request['message_to_decrypt']));
            break;

        default:
            $arrResponse['success'] = false;
            $arrResponse['error'] = 'No valid action.';
            $arrResponse['request'] = $request;
            break;
    }
} catch (Throwable $exception) {
    $arrResponse['success'] = false;
    $arrResponse['error'] = $exception->getMessage();
}

// Set headers
header('Content-Type: application/json');

if (isset($arrResponse['error'])) {
    header("HTTP/1.1 400 Bad Request");
} else {
    header("HTTP/1.1 200 OK");
}

die(json_encode($arrResponse));
