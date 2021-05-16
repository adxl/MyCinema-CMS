<?php

namespace App\Controllers;

use App\Core\Helpers;

use App\Models\User as UserModel;
use App\Models\Session as SessionModel;

class Security
{
    private static $sessionModel = new SessionModel();


    public static function isAuthenticated($authSession): bool
    {
        $session = self::$sessionModel->findById($authSession['id']);

        if (!$session)
            return false;

        if ($session['expireAt'] < Helpers::now())
            return false;

        $user = self::getSessionUser($authSession);

        return !is_null($user);
    }

    public static function hasPermission($authSession, $scope): bool
    {

        $session = self::$sessionModel->findById($authSession['id']);

        if (!$session)
            return false;

        $user = self::getSessionUser($authSession);

        if (is_null($user))
            return false;

        $roles = explode(' ', $scope);

        return in_array($user["role"], $roles);
    }

    private static function getSessionUser($session)
    {
        $userModel = new UserModel();
        $sessionUserId = $session['userId'];
        $user = $userModel->findById($sessionUserId);

        return $user ?? null;
    }
}
