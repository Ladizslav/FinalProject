<?php

class User{
    public int $id;
    protected string $name;
    protected string $password;

    // Konstruktor pro vytvoření uživatele
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

    //Získání uživatele pomocí uživatelského jména a hesla
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

    // Registrace nového uživatele.
    public static function registerUser($username, $password)
    {
        $connection = DBC::getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Zabezpečení hesla

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $user = new User(mysqli_insert_id($connection), $username, $hashedPassword);
            return $user;
        } else {
            return null;
        }
    }
    
    // Získá uživatelské jméno pomocí ID uživatele.
    public static function getUsernameById($user_id) {
        $connection = DBC::getConnection();
        $query = "SELECT username FROM users WHERE id = ?";
        $statement = $connection->prepare($query);
        $statement->bind_param("i", $user_id);
        $statement->execute();
        $result = $statement->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['username'];
        } else {
            return null;
        }
    }

}

?>