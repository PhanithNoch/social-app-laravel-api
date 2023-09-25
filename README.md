

1. register user with user profile
2. login 
3. post photo with caption
4. update user profile 
5. follow other users

## Database Schema Design

### Users
    id  int primary key auto_increment
    username varchar(255) not null
    email varchar(255) not null
    password varchar(255) not null
    profile_pic varchar(255) not null
    bio varchar(255) not null
### Posts
    id  int primary key auto_increment
    user_id int not null
    caption varchar(255) not null
    image varchar(255) not null
### Follows
    id  int primary key auto_increment
    user_id int not null
    follower_id int not null
### Likes
    id  int primary key auto_increment
    user_id int not null
    post_id int not null
### Comments
    id  int primary key auto_increment
    user_id int not null
    post_id int not null
    comment varchar(255) not null

## Laravel Passport Authentication 
