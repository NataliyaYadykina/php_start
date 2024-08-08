<?php

namespace Geekbrains\Application1\Domain\Models;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Infrastructure\Storage;

class User
{
    private ?int $userId;
    private ?string $userName;
    private ?string $userLastName;
    private ?int $userBirthday;
    private ?string $login;
    private ?string $password;

    public function __construct(int $userId = null, string $login = null, string $password = null, string $name = null, string $userLastName = null, int $birthday = null)
    {
        $this->userId = $userId;
        $this->login = $login;
        $this->password = $password;
        $this->userName = $name;
        $this->userLastName = $userLastName;
        $this->userBirthday = $birthday;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUserLogin(): string
    {
        return $this->login;
    }

    public function setName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getUserLastName(): string
    {
        return $this->userLastName;
    }

    public function setUserLastName(string $userLastName): void
    {
        $this->userLastName = $userLastName;
    }

    public function getUserBirthday(): ?int
    {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString): void
    {
        $this->userBirthday = strtotime($birthdayString);
    }

    public static function getUserFromStorageById(int $id): User
    {
        $sql = "SELECT * FROM users WHERE id_user = :id";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id' => $id]);
        $result = $handler->fetch();
        if ($result) {
            return new User(
                $result['id_user'],
                $result['login'],
                $result['password_hash'],
                $result['user_name'],
                $result['user_lastname'],
                $result['user_birthday_timestamp']
            );
        } else {
            return null;
        }
    }

    public static function getAllUsersFromStorage(): array|false
    {
        $sql = "SELECT * FROM users";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute();
        $result = $handler->fetchAll();

        $users = [];

        foreach ($result as $item) {
            $user = new User($item['id_user'], $item['login'], $item['password_hash'], $item['user_name'], $item['user_lastname'], $item['user_birthday_timestamp']);
            $users[] = $user;
        }

        return $users;
    }

    public static function validateRequestData(): bool
    {
        $result = true;

        if (!(
            isset($_POST['login']) && !empty($_POST['login'])
            && isset($_POST['password']) && !empty($_POST['password'])
            && isset($_POST['name']) && !empty($_POST['name'])
            && isset($_POST['lastname']) && !empty($_POST['lastname'])
            && isset($_POST['birthday']) && !empty($_POST['birthday'])
        )) {
            $result = false;
        }

        // Регулярное выражение для проверки отсутствия HTML-тегов
        $htmlTagPattern = '/<([^>]+)>/';
        if (
            preg_match($htmlTagPattern, $_POST['login']) ||
            preg_match($htmlTagPattern, $_POST['password']) ||
            preg_match($htmlTagPattern, $_POST['name']) ||
            preg_match($htmlTagPattern, $_POST['lastname'])
        ) {
            $result = false;
        }

        if (!preg_match('/^(\d{2}-\d{2}-\d{4})$/', $_POST['birthday'])) {
            $result = false;
        }

        if (
            !isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']
        ) {
            $result = false;
        }

        return $result;
    }

    public function setParamsFromRequestData(): void
    {
        $this->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $this->login = htmlspecialchars($_POST['login']);
        $this->userName = htmlspecialchars($_POST['name']);
        $this->userLastName = htmlspecialchars($_POST['lastname']);
        $this->login = htmlspecialchars($_POST['login']);
        $this->setBirthdayFromString($_POST['birthday']);
    }

    public function saveToStorage(): void
    {
        $sql = "INSERT INTO users(login, password_hash, user_name, user_lastname, user_birthday_timestamp) VALUES (:user_login, :user_password, :user_name, :user_lastname, :user_birthday)";

        $handler = Application::$storage->get()->prepare($sql);

        $handler->execute([
            'user_login' => $this->login,
            'user_password' => $this->password,
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday
        ]);
    }
    
    public static function getUserDataByID(int $userID): array
    {
        $userSql = "SELECT * FROM users WHERE id_user = :id";


        $handler = Application::$storage->get()->prepare($userSql);
        $handler->execute(['id' => $userID]);
        return $handler->fetch();
    }

    public static function exists(int $id): bool
    {
        $sql = "SELECT count(id_user) as user_count FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'id_user' => $id
        ]);

        $result = $handler->fetchAll();

        if (count($result) > 0 && $result[0]['user_count'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUser(array $userDataArray): void
    {
        $sql = "UPDATE users SET ";

        $counter = 0;
        foreach ($userDataArray as $key => $value) {
            $sql .= $key . " = :" . $key;

            if ($counter != count($userDataArray) - 1) {
                $sql .= ",";
            }

            $counter++;
        }
        $sql .= " WHERE id_user = {$this->getUserId()}";


        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute($userDataArray);
    }

    public static function deleteFromStorage(int $user_id): void
    {
        $sql = "DELETE FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id_user' => $user_id]);
    }

    public static function destroyToken(): array
    {
        $userSql = "UPDATE users SET token = :token WHERE id_user = :id";

        $handler = Application::$storage->get()->prepare($userSql);
        $handler->execute(['token' => md5(bin2hex(random_bytes(16))), 'id' => $_SESSION['auth']['id_user']]);
        $result = $handler->fetchAll();

        return $result[0] ?? [];
    }

    public static function verifyToken(string $token): array
    {
        $userSql = "SELECT * FROM users WHERE token = :token";


        $handler = Application::$storage->get()->prepare($userSql);
        $handler->execute(['token' => $token]);
        $result = $handler->fetchAll();

        return $result[0] ?? [];
    }

    public static function setToken(int $userID, string $token): void
    {
        $userSql = "UPDATE users SET token = :token WHERE id_user = :id";


        $handler = Application::$storage->get()->prepare($userSql);
        $handler->execute(['id' => $userID, 'token' => $token]);


        setcookie(
            'auth_token',
            $token,
            time() + 60 * 60 * 24 * 30,
            '/'
        );
    }
}

