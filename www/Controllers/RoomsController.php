<?php

namespace App\Controllers;

use App\Core\FormValidator;
use App\Core\Helpers;
use App\Core\View;

use App\Models\Room as RoomModel;

class RoomsController
{
    public function defaultAction()
    {
        $id = Helpers::getQueryParam('id');

        if ($id) {
            $this->showEditRoomAction($id);
        } else {
            $this->showRoomsAction();
        }
    }


    public function showRoomsAction()
    {
        $view = new View("b_rooms", 'back');
        $view->assign("title", 'Gestion des salles');

        $roomModel = new RoomModel();
        $rooms = $roomModel->findAll();

        foreach ($rooms as $key => $room) {
            $roomId = $room['id'];
            $rooms[$key]['sessions'] = $roomModel->getSessionsCount($roomId);
            $rooms[$key]['nextSession'] = $roomModel->getNextSessionDate($roomId);
            $rooms[$key]['nextMovie'] = $roomModel->getNextEvent($roomId);
        }

        $view->assign("rooms", $rooms);
    }

    public function createRoomAction()
    {
        $view = new View("b_rooms_create", 'back');
        $view->assign("title", 'Gestion des salles > Nouvelle salle');

        $room = new RoomModel();
        $form = $room->formBuilderCreate();

        if (!empty($_POST)) {

            $errors = FormValidator::check($form, $_POST);
            if (empty($_FILES['media']['name'])) {
                $errors[] = "Vous n'avez pas ajouté d'image de la salle";
            }

            if ($_FILES['media']['size'] === 0) {
                $errors[] = "La photo ne doit pas dépasser 2M";
            }

            if (empty($errors)) {

                $data = $_POST;
                $file = $_FILES['media'];

                $room->setLabel($data['label']);
                $room->setCapacity($data['capacity']);

                $file_type = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $media = "/Views/images/room_" .  Helpers::slugify($room->getLabel()) . '.' . $file_type;

                if (!getimagesize($file["tmp_name"])) {
                    $view->assign("errors", ["L'image est invalide"]);
                    exit;
                }

                $allowed_types = ['jpg', 'jpeg', 'png'];
                if (!in_array($file_type, $allowed_types)) {
                    $view->assign("errors", ["Le format de l'image est invalide"]);
                    exit;
                }


                if (!move_uploaded_file($file["tmp_name"], '/var/www/html' . $media)) {
                    $view->assign("errors", ["La photo n'a pas pu être ajoutée"]);
                    exit;
                }

                $room->setMedia($media);

                $room->save();
                Helpers::redirect('/bo/rooms');
            } else {
                $view->assign("errors", $errors);
            }
        }

        $view->assign('form', $form);
    }

    public function editRoomAction($id = null)
    {
        if (!$id) {
            $id = Helpers::getQueryParam('id');
        }

        if ($id) {
            $roomModel = new RoomModel();
            $room = $roomModel->findById($id);

            if ($room) {
                $view = new View("b_rooms_edit", 'back');
                $view->assign("title", 'Gestion des salles > Modifier une salle');

                $form = $roomModel->formBuilderUpdate($room);

                if (!empty($_POST)) {

                    $data = $_POST;
                    $file = $_FILES['media'];

                    $data['isAvailable'] = isset($data['isAvailable']) ? 1 : 0;
                    $data['isHandicapAccess'] = isset($data['isHandicapAccess']) ? 1 : 0;

                    $errors = FormValidator::check($form, $data);

                    if (empty($errors)) {

                        $roomModel->setId($id);
                        $roomModel->setLabel($data['label']);
                        $roomModel->setCapacity($data['capacity']);
                        $roomModel->setMedia($room['media']);
                        $roomModel->setIsAvailable($data['isAvailable']);
                        $roomModel->setIsHandicapAccess($data['isHandicapAccess']);

                        if (!empty($file['name'])) {

                            if ($file['size'] === 0) {
                                $errors[] = "La photo ne doit pas dépasser 2M";
                            }

                            $file_type = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                            $media = "/Views/images/room_" . Helpers::slugify($roomModel->getLabel()) . '.' . $file_type;

                            if (!getimagesize($file["tmp_name"])) {
                                $view->assign("errors", ["L'image est invalide"]);
                                exit;
                            }

                            $allowed_types = ['jpg', 'jpeg', 'png'];
                            if (!in_array($file_type, $allowed_types)) {
                                $view->assign("errors", ["Le format de l'image est invalide"]);
                                exit;
                            }

                            if (!move_uploaded_file($file["tmp_name"], '/var/www/html' . $media)) {
                                $view->assign("errors", ["La photo n'a pas pu être ajoutée"]);
                                exit;
                            }

                            $roomModel->setMedia($media);
                        }

                        $roomModel->save();
                        Helpers::redirect('/bo/rooms');
                    } else {
                        $view->assign("errors", $errors);
                    }
                }

                $view->assign('form', $form);
                $view->assign('room_id', $id);
                return;
            }
        }
        $view = new View('f_404', 'front');
    }

    public function deleteRoomAction()
    {
        $id = Helpers::getQueryParam('id');

        $room = new RoomModel();
        $room->deleteById($id);

        Helpers::redirect('/bo/rooms');
    }
}
