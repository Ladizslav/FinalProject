<?php

class User{
    public int $id;
    protected string $name;
    protected string $password;

    public function __construct(int $id, string $name,string $password){
        $this-> id = $id;
        $this-> name = $name;
        $this-> password = $password;
    }

    public function setId(int $id): void{
        $this -> id = $id;
    }

    public function getId(): int{
        return $this->id;
    }
    

    public function setAge(int $age): void{
        $this -> age = $age;
    }

    public function getAge(int $age): int{
        return $this -> age;
    }

    public function setName(string $name): void{
        $this -> name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(){
        return $this->jmeno .":". $this->heslo;
    }

    public static $failedLoginAttempts = array();

    public static function getUserByUsernameAndPassword($username, $password)
    {
        if (isset(self::$failedLoginAttempts[$username]) && count(self::$failedLoginAttempts[$username]) >= 3) {
            $logMessage = "Failed login attempt after three failures: Username - $username, IP - {$_SERVER['REMOTE_ADDR']}, Time - " . date('Y-m-d H:i:s') . PHP_EOL;
            $logFile = 'login_attempts.log';
            file_put_contents($logFile, $logMessage, FILE_APPEND);
            return null;
        }

        $connection = DBC::getConnection();
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);

        if ($result && $user_data = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user_data['password'])) {
                unset(self::$failedLoginAttempts[$username]); 
                $user = new User($user_data['id'], $user_data['username'], $user_data['password']);
                return $user;
            }
        }
        if (!isset(self::$failedLoginAttempts[$username])) {
            self::$failedLoginAttempts[$username] = array();
        }
        self::$failedLoginAttempts[$username][] = time();

        return null;
    }



    public static function registerUser($username, $password)
    {
        $connection = DBC::getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $user = new User(mysqli_insert_id($connection), $username, $hashedPassword);
            return $user;
        } else {
            return null;
        }
    }


}

?>