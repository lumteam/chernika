<?php

namespace PDV\Handlers;

class User
{
    public static function updateUserLogin(& $args)
    {
        if (strlen($args["EMAIL"]) > 0 && filter_var($args["EMAIL"], FILTER_VALIDATE_EMAIL)) {
            $args["LOGIN"] = $args["EMAIL"];
            return true;
        }
    }
}