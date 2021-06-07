<?php

namespace App\Controllers;

use App\Core\Helpers;
use App\Core\View;
use App\Models\Comment as CommentModel;

class CommentsController
{
    public function showCommentsAction()
    {

        $view = new View("b_comments", "back");
        $view->assign("title", 'Comments management');

        $status = Helpers::getQueryParam('status');

        $commentModel = new CommentModel();

        $comments = is_null($status) ? $commentModel->findAll() : $commentModel->findAll([
            'where' => [
                [
                    'column' => 'status',
                    'operator' => '=',
                    'value' => $status
                ]
            ]
        ]);
        foreach($comments as $comment) {
            $comment['event'] = $eventModel->findById($comment['eventId'])['title'];
        };
        $view->assign('comments', $comments);
    }

    public function addCommentAction()
    {
        $id = Helpers::getQueryParam('id');
        $data = $_POST;

        $commentModel = new CommentModel();
        $commentModel->setName($data['name']);
        $commentModel->setContent($data['content']);
        $commentModel->setEventId($id);

        $commentModel->save();

        Helpers::redirect('/events?id=' . $id);
    }

    public function approveCommentAction()
    {
        $id = Helpers::getQueryParam('id');

        $commentModel = new CommentModel();
        $comment = $commentModel->findById($id);

        $commentModel->populate($commentModel, $comment);

        $commentModel->setStatus('APPROVED');

        $commentModel->save();

        Helpers::redirect('/bo/comments' . $id);
    }

    public function declineCommentAction()
    {
        $id = Helpers::getQueryParam('id');

        $commentModel = new CommentModel();
        $comment = $commentModel->findById($id);

        $commentModel->populate($commentModel, $comment);

        $commentModel->setStatus('DECLINED');

        $commentModel->save();

        Helpers::redirect('/bo/comments' . $id);
    }
}
