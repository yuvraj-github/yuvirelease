<?php

use Illuminate\Support\Facades\Session;

/**
 * Function to flash message.
 *
 * @param  array $message
 * @return JSON
 */
function showMessage($message = [])
{
    $message = (object)$message;
    Session::flash('status', $message->status);
    Session::flash('alert-class', $message->messageClass);
    return response()->json(['type' => $message->type, 'message' => $message->status]);
}
