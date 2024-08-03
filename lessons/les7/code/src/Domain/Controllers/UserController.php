<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\User;
use Geekbrains\Application1\Domain\Controllers\AbstractController;

class UserController extends AbstractController
{

    protected array $actionsPermissions = [
        'actionHash' => ['admin', 'manager'],
        'actionSave' => ['admin']
    ];

    public function actionIndex()
    {
        $users = User::getAllUsersFromStorage();

        $render = new Render();

        if (!$users) {
            return $render->renderPage(
                'users/user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]
            );
        } else {
            return $render->renderPage(
                'users/user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]
            );
        }
    }

    public function actionSave(): string
    {
        if (User::validateRequestData()) {
            $user = new User();
            $user->setParamsFromRequestData();
            $user->saveToStorage();

            $render = new Render();
            return $render->renderPage(
                'users/user-created.twig',
                [
                    'title' => 'Пользователь создан',
                    'message' => "Создан пользователь {$user->getUserName()} {$user->getUserLastName()}."
                ]
            );
        } else {
            throw new \Exception("Переданные данные некорректны.");
        }
    }

    public function actionShow(): string
    {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
        if (User::exists($id)) {
            $user = User::getUserFromStorageById($id);
            $render = new Render();
            return $render->renderPage(
                'users/user-page.twig',
                [
                    'title' => 'Просмотр пользователя',
                    'user' => $user
                ]
            );
        }
        throw new \Exception("Пользователь с указанным ID не найден.");
    }

    public function actionUpdate(): string
    {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
        if (User::exists($id)) {
            $user = new User();
            $user->setUserId($id);

            $arrayData = [];

            if (isset($_GET['name']))
                $arrayData['user_name'] = $_GET['name'];

            if (isset($_GET['lastname'])) {
                $arrayData['user_lastname'] = $_GET['lastname'];
            }

            if (isset($_GET['birthday'])) {
                $user->setBirthdayFromString($_GET['birthday']);
                $arrayData['user_birthday_timestamp'] = $user->getUserBirthday();
            }

            $user->updateUser($arrayData, $user->getUserId());
        } else {
            throw new \Exception("Пользователь не существует");
        }

        $render = new Render();
        return $render->renderPage(
            'users/user-created.twig',
            [
                'title' => 'Пользователь обновлен',
                'message' => "Обновлен пользователь " . $user->getUserId()
            ]
        );
    }

    public function actionDelete(): string
    {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
        if (User::exists($id)) {
            User::deleteFromStorage($id);

            $render = new Render();

            return $render->renderPage(
                'users/user-removed.twig',
                []
            );
        } else {
            throw new \Exception("Пользователь не существует");
        }
    }

    public function actionEdit(): string
    {
        $render = new Render();
        return $render->renderPageWithForm(
            'users/user-form.twig',
            [
                'title' => 'Форма создания пользователя'
            ]
        );
    }
    
    public function actionHash(): string
    {
        return Auth::getPasswordHash($_GET['pass_string']);
    }
    
    public function actionAuth(): string
    {
        $render = new Render();
        return $render->renderPageWithForm(
            'users/user-auth.twig',
            [
                'title' => 'Форма логина'
            ]
        );
    }
    
    public function actionLogin(): string
    {
        $result = false;
        if (isset($_POST['login']) && isset($_POST['password'])) {
            $result = Application::$auth->proceedAuth(
                $_POST['login'],
                $_POST['password']
            );
        }
        if (!$result) {
            $render = new Render();
            return $render->renderPageWithForm(
                'users/user-auth.twig',
                [
                    'title' => 'Форма логина',
                    'auth-success' => false,
                    'auth-error' => 'Неверные логин или пароль'
                ]
            );
        } else {
            header('Location: /');
            return "";
        }
    }
}
