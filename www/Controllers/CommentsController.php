<?php

namespace App\Controllers;

use App\Core\Helpers;
use App\Core\View;
use App\Models\Comment as CommentModel;
use App\Models\Event as EventModel;

class CommentsController
{
    public function showCommentsAction()
    {
        $view = new View("b_comments", "back");
        $view->assign("title", 'Gestion des commentaires');

        $status = Helpers::getQueryParam('status') ?: 'WAITING';

        $commentModel = new CommentModel();

        $eventModel = new EventModel();

        $comments = $status === 'ALL' ? $commentModel->findAll(
            [
                'order' => [
                    'column' => 'createdAt',
                    'order' => 'DESC'
                ]
            ]
        ) : $commentModel->findAll([
            'where' => [
                [
                    'column' => 'status',
                    'operator' => '=',
                    'value' => $status
                ]
            ],
            'order' => [
                'column' => 'createdAt',
                'order' => 'DESC'
            ]
        ]);
        foreach ($comments as $key => $comment) {
            $comments[$key]['event'] = $eventModel->findById($comment['eventId'])['title'];
        };
        $view->assign('comments', $comments);
        $view->assign('status', $status);
    }

    public function approveCommentAction()
    {
        $id = Helpers::getQueryParam('id');
        $status = Helpers::getQueryParam('status');

        $commentModel = new CommentModel();
        $comment = $commentModel->findById($id);

        $commentModel->populate($commentModel, $comment);

        $commentModel->setStatus('APPROVED');

        $commentModel->save();

        Helpers::redirect('/bo/comments?status=' . $status);
    }

    public function suspendCommentAction()
    {
        $id = Helpers::getQueryParam('id');
        $status = Helpers::getQueryParam('status');

        $commentModel = new CommentModel();
        $comment = $commentModel->findById($id);

        $commentModel->populate($commentModel, $comment);

        $commentModel->setStatus('WAITING');

        $commentModel->save();

        Helpers::redirect('/bo/comments?status=' . $status);
    }

    public function declineCommentAction()
    {
        $id = Helpers::getQueryParam('id');
        $status = Helpers::getQueryParam('status');

        $commentModel = new CommentModel();
        $comment = $commentModel->findById($id);

        $commentModel->populate($commentModel, $comment);

        $commentModel->setStatus('DECLINED');

        $commentModel->save();

        Helpers::redirect('/bo/comments?status=' . $status);
    }
}
