<?php

use App\Models\Notification;
use App\Models\Setting;

function sendNotification($userId, $title, $message, $type = null)
{
    Notification::create([
        'user_id' => $userId,
        'title' => $title,
        'message' => $message,
        'type' => $type
    ]);
}



function setting($key)
{
return Setting::get($key);
}
