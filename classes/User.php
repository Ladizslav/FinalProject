<?php

class User{
    public int $id;
    //private int $age;
    protected string $name;
    protected string $password;

    /*public function __construct(int $id, int $age, string $name){
        $this-> id = $id;
        $this-> age = $age;
        $this-> name = $name;
    }*/
    public function __construct(int $id, string $name,string $password){
        $this-> id = $id;
        $this-> name = $name;
        $this-> password = $password;
    }
    /*
     * @return void
     */ 
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


    /*public static function bark(){
        echo "BARK!";
    }
    */

    public function __toString(){
        return $this->jmeno .":". $this->heslo;
    }

    public static function getUserByUsernameAndPassword($username, $password)
{
    $connection = DBC::getConnection();
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if ($result && $user_data = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user_data['password'])) {
            $user = new User($user_data['id'], $user_data['username'], $user_data['password']);
            return $user;
        }
    }

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