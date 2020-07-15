<?php

Broadcast::channel('orders.{id}', function ($user, $id) {
    return $user->id === $id;
});
