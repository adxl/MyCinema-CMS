<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Event as EventModel;
use App\Models\Room as RoomModel;
use App\Models\Event_room as EventRoomModel;
use App\Models\Comment as Comment;

class DashboardController
{
    public function showDashboardAction()
    {
        $view = new View("b_dashboard", 'back');

        $eventModel = new EventModel;
        $nbMovies = count($eventModel->findAll());

        $roomModel = new RoomModel;
        $rooms = $roomModel->findAll();
        $nbRooms = count($rooms);
        $nbUnavailableRooms = count(array_filter($rooms, function ($v) {
            return $v['isAvailable'] == 0;
        }));
        $lastRooms = $roomModel->findAll(['order by' => 'createdAt']);
        $lastRooms = array_slice($lastRooms, 0, 3);


        $eventRoomModel = new EventRoomModel;
        $nbScheduled = count($eventRoomModel->findAll());

        $lastMovies = $eventModel->findAll(['order by' => 'createdAt']);
        $lastMovies = array_slice($lastMovies, 0, 3);

        $commentModel = new Comment;
        $allComments = $commentModel->findAll();
        $comments = [
            'total' => count($allComments),
            'waiting' => count(array_filter($allComments, function ($v) {
                return $v['status'] == 'WAITING';
            })),
            'approved' => count(array_filter($allComments, function ($v) {
                return $v['status'] == 'APPROVED';
            })),
            'declined' => count(array_filter($allComments, function ($v) {
                return $v['status'] == 'DECLINED';
            }))
        ];

        $view->assign("title", 'Tableau de bord');
        $view->assign("nbRooms", $nbRooms);
        $view->assign("nbUnavailableRooms", $nbUnavailableRooms);
        $view->assign("nbMovies", $nbMovies);
        $view->assign("nbScheduled", $nbScheduled);
        $view->assign("lastMovies", $lastMovies);
        $view->assign("lastRooms", $lastRooms);
        $view->assign("comments", $comments);
    }
}
