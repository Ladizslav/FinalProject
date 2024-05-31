1. Láďova vláknová stránka

2. Na webu si uživatel může čist ostatních lidí vlákna.
   Když se přihlásí může vytvořit vlasní vlákno.
   Stránka zabezpečuje hesla uživatelů na databázi.

3. Visual studio code, XAMPP Conrol Panel, MySQL Workbench 8.0 CE

4. a) Stáhní dokumenty z GitHubu
   b) Stáhní/Zapni XAMPP Conrol Panel
   c) U Apache klikni na Config a zvol Apache (httpd.conf)
   d) Přepiš následujíci texty na umístění souboru stránky
   DocumentRoot "D:\...\..."
   <Directory "D:\...\...">
   e) Zapni Apache
   f) Zapni MySQL Workbench
   g) Připoj se jako root, heslo student
   h) Do Query vlož následujíci a executni to:
   create database logintest;
    use logintest;

    CREATE TABLE users (
     id int auto_increment primary key,
    username varchar(100) NOT NULL,
    password varchar(100) NOT NULL
    );
    create table threads (
        id int auto_increment primary key,
        title VARCHAR(255) not null,
        username VARCHAR(255) not null,
        user_id int,
        content text not null,
	    created_at timestamp default current_timestamp,
        foreign key (user_id) references users(id)
    );

    create table messages (
        id int auto_increment primary key,
        thread_id int not null,
        user_id int,
        content text not null,
        created_at timestamp default current_timestamp,
        foreign key (thread_id) references threads(id),
        foreign key (user_id) references users(id)
    );
   i) Bež do prohlížeče a bež na localhost
   j) Užij si stránku

PS: Pro kontrolu zabezpečení uživatele použijte příkaz:
    select * from users; 


