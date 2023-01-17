<?php
$auth = false;

if ($method === 'GET') {
    $auth = true;
} else {
    if ($modx->user->isAuthenticated('web') && $modx->user->isMember('apiuser')) {
        $auth = true;
    }
}
return $auth;