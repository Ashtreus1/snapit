create database snapit;

use snapit;

create table users (
    id int primary key auto_increment,
    email varchar(100) unique not null,
    username varchar(100) unique not null,
    password varchar(100) not null,
    avatar_path varchar(50),
    created_at timestamp default CURRENT_TIMESTAMP   
);

create table tags (
    id int primary key auto_increment,
    name varchar(100)
);

create table users_images (
    id int primary key auto_increment,
    user_id int,
    tag_id int,
    title varchar(100) not null,
    description varchar(100),
    image_path varchar(255),
    is_favorite boolean default 0,
    created_at timestamp default CURRENT_TIMESTAMP,
    foreign key (user_id) references users(id) on delete cascade,
    foreign key (tag_id) references tags(id) on delete cascade
);

create table comments (
    id int primary key auto_increment,
    user_id int,
	image_id int,
    message text,
    created_at timestamp default CURRENT_TIMESTAMP,
    foreign key (user_id) references users(id) on delete cascade,
    foreign key (image_id) references users_images(id)
);

CREATE TABLE pinned_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    image_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_pin (user_id, image_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES users_images(id) ON DELETE CASCADE
);

    