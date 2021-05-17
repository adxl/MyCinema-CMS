<?php

namespace App\Core;

use App\Core\Helpers;

use App\Models\User as UserModel;
use App\Models\Session as SessionModel;

class Security
{
    // checks si user est connecté
    public static function isAuthenticated(): bool
    {
        session_start();
        $authSession = $_SESSION['authSession'] ?? null;

        if (is_null($authSession))
            return false;

        $sessionModel = new SessionModel();
        $session = $sessionModel->findById($authSession['id']);

        if (!$session)
            return false;

        if ($session['expireAt'] < Helpers::now())
            return false;

        $user = self::getSessionUser($authSession);

        return !is_null($user);
    }

    // checks si user a les droits d'accès
    public static function hasPermission($scope): bool
    {
        $authSession = $_SESSION['authSession'];

        $sessionModel = new SessionModel();
        $session = $sessionModel->findById($authSession['id']);

        if (!$session)
            return false;

        $user = self::getSessionUser($authSession);

        if (is_null($user))
            return false;

        $roles = explode(' ', $scope);

        return in_array($user["role"], $roles);
    }

    // initialise la session locale
    public static function initSession($userId)
    {

        $session = new SessionModel();
        $session->setUserId($userId);

        $sessionId = $session->save();

        $authSession = [
            'id' => $sessionId,
            'userId' => $userId
        ];

        $_SESSION['authSession'] = $authSession;
    }

    // récupère user de la session locale
    private static function getSessionUser($session)
    {
        $userModel = new UserModel();
        $sessionUserId = $session['userId'];
        $user = $userModel->findById($sessionUserId);

        return $user ?? null;
    }

    public static function getCurrentUser()
    {
        if (!self::isAuthenticated())
            return null;

        $authSession = $_SESSION['authSession'];
        $user = self::getSessionUser($authSession);

        return $user;
    }
}
