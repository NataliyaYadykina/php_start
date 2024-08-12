<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\User;
use Geekbrains\Application1\Domain\Controllers\AbstractController;
use Geekbrains\Application1\Domain\Controllers\Controller;

class UserController extends AbstractController
{

    protected array $actionsPermissions = [
        'actionHash' => ['admin', 'manager'],
        'actionSave' => ['admin'],
        'actionEdit' => ['admin'],
        'actionIndex' => ['admin'],
        'actionLogout' => ['admin'],
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
                    'users' => $users,
                    'isAdmin' => User::isAdmin($_SESSION['auth']['id_user'] ?? null)
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
        $id = isset($_POST['user_id']) && is_numeric($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        if (User::exists($id)) {
            $user = new User();
            $user->setUserId($id);

            $arrayData = [];

            if (isset($_POST['name']))
                $arrayData['user_name'] = $_POST['name'];

            if (isset($_POST['lastname'])) {
                $arrayData['user_lastname'] = $_POST['lastname'];
            }

            if (isset($_POST['birthday'])) {
                $user->setBirthdayFromString($_POST['birthday']);
                $arrayData['user_birthday_timestamp'] = $user->getUserBirthday();
            }

            $user->updateUser($arrayData);
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

    public function actionDelete(): void
    {

        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
        if (User::exists($id)) {
            User::deleteFromStorage($id);

            $render = new Render();

            header('Location: /user/index/');

            // return $render->renderPage(
            //     'users/user-index.twig',
            //     []
            // );
        } else {
            throw new \Exception("Пользователь не существует");
        }
    }

    public function actionEdit(): string
    {
        $action = '/user/save';
        $render = new Render();

        if (!isset($_GET['user_id'])) {
            return $render->renderPageWithForm(
                'users/user-form.twig',
                [
                    'title' => 'Форма создания пользователя',
                    'action' => $action
                ]
            );
        }

        $id = isset($_GET['user_id']) && is_numeric($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

        if (User::exists($id)) {
            $userId = $id;
            $action = '/user/update';
            $userData = User::getUserDataByID($userId);
            return $render->renderPageWithForm(
                'users/user-form.twig',
                [
                    'title' => 'Форма редактирования пользователя',
                    'user_data' => $userData ?? [],
                    'action' => $action
                ]
            );
        } else {
            throw new \Exception("Ошибка! Вы хотите изменить несуществующего пользователя.");
        }
    }

    public function actionHash(): string
    {
        if (isset($_GET['pass_string']) && !empty($_GET['pass_string'])) {
            return Auth::getPasswordHash($_GET['pass_string']);
        } else {
            throw new \Exception("Невозможно сгенерировать хэш. Не передан пароль.");
        }
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

            if (
                $result &&
                isset($_POST['user-remember']) && $_POST['user-remember'] == 'remember'
            ) {
                $token = Application::$auth->generateToken($_SESSION['auth']['id_user']);

                User::setToken($_SESSION['auth']['id_user'], $token);
            }
        }

        if (!isset($_POST['csrf_token'])) {
            $render = new Render();

            return $render->renderPageWithForm(
                'users/user-auth.twig',
                [
                    'title' => 'Форма логина',
                    'auth_success' => 1
                ]
            );
        }

        if (!$result) {

            $render = new Render();
            return $render->renderPageWithForm(
                'users/user-auth.twig',
                [
                    'title' => 'Форма логина',
                    'auth_success' => false,
                    'auth_error' => 'Неверные логин или пароль'
                ]
            );
        } else {
            header('Location: /');
            return "";
        }
    }

    public function actionLogout(): void
    {
        User::destroyToken();
        session_destroy();
        unset($_SESSION['auth']);
        header("Location: /");
        die();
    }

    public function actionIndexRefresh()
    {
        $limit = null;

        if (isset($_POST['maxId']) && $_POST['maxId'] > 0) {
            $limit = $_POST['maxId'];
        }
        $users = User::getAllUsersFromStorage($limit);
        $usersData = [];

        if (count($users) > 0) {
            foreach ($users as $user) {
                $usersData[] = $user->getUserDataAsArray();
            }
        }

        return json_encode($usersData);

        /*$render = new Render();
	if(!$users){
		return $render->renderPartial(
			'users/user-empty.twig',
			[
				'title' => 'Список пользователей в хранилище',
				'message' => "Список пуст или не найден"
			]);
	}
	else{
		return $render->renderPartial(
			'users/user-index.twig',
			[
				'title' => 'Список пользователей в хранилище',
				'users' => $users
			]);
	}*/
    }
}
