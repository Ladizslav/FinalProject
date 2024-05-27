<?php

class DBC
{
    const SERVER_IP = "localhost";
    const USER = "root";
    const PASSWORD = "student";
    const DATABASE = "logintest";
    const PORT = 3306;

    private static $instance = null;
    private $connection;

    private function __construct()
    {
    }

    public static function getConnection()
    {
        if (!self::$instance) {
            self::$instance = new DBC();
            self::$instance->connect();
        }

        return self::$instance->connection;
    }

    private function connect()
    {
        $this->connection = mysqli_connect(
            self::SERVER_IP,
            self::USER,
            self::PASSWORD,
            self::DATABASE,
            self::PORT
        );

        if (!$this->connection) {
            die('Nelze se připojit k databázi: ' . mysqli_connect_error());
        }
    }

    public static function closeConnection()
    {
        if (self::$instance && self::$instance->connection) {
            mysqli_close(self::$instance->connection);
        }
    }
}

/*
create database logintest;
use logintest;

create table users (
  id int auto_increment primary key,
  username varchar(100) not null,
  password varchar(100) not null
);

create table threads (
    id int auto_increment primary key,
    title VARCHAR(255) not null,
    user_id int not null,
    created_at timestamp default current_timestamp,
    foreign key (user_id) references users(id)
);

create table messages (
    id int auto_increment primary key,
    thread_id int not null,
    user_id int not null,
    content text not null,
    created_at timestamp default current_timestamp,
    foreign key (thread_id) references threads(id),
    foreign key (user_id) references users(id)
);



select * from users; 
*/
