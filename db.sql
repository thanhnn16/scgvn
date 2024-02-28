drop database if exists scgvn_dev;
create database if not exists scgvn_dev;

use scgvn_dev;

create table users
(
    id             serial primary key,
    username       varchar(255) not null,
    password       varchar(255) not null,
    remember_token varchar(100) null,
    created_at     timestamp    not null default current_timestamp,
    updated_at     timestamp    not null default current_timestamp
);

create table personal_access_tokens
(
    id             serial primary key,
    tokenable_id   integer      not null,
    tokenable_type varchar(255) not null,
    name           varchar(255) not null,
    token          varchar(64)  not null unique,
    abilities      text         null,
    last_used_at   timestamp    null,
    expires_at     timestamp    null,
    created_at     timestamp    not null default current_timestamp,
    updated_at     timestamp    not null default current_timestamp
);

create table events
(
    id         serial primary key,
    title      varchar(255) not null,
    content    text         not null,
    start_date date         not null,
    end_date   date         not null,
    status     enum('draft', 'published', 'archived') default 'draft' not null,
    created_at timestamp    not null default current_timestamp,
    updated_at timestamp    not null default current_timestamp
);

create table agencies
(
    id           serial primary key,
    keywords     varchar(50)  null,
    agency_id    varchar(20)  not null unique,
    agency_name  varchar(255) not null,
    province     varchar(50),
    district     varchar(50),
    created_at   timestamp    not null default current_timestamp,
    updated_at   timestamp    not null default current_timestamp,
    event_id     integer references events (id)
);

create table prizes
(
    id         serial primary key,
    prize_name varchar(255) not null,
    prize_qty  integer      not null,
    prize_desc text         null,
    created_at timestamp    not null default current_timestamp,
    updated_at timestamp    not null default current_timestamp,
    event_id   integer references events (id),
    agency_id  integer references agencies (id)
);


# change timezone to UTC +7
SET GLOBAL time_zone = '+7:00';
SET time_zone = '+7:00';

#
# SELECT user, plugin
# FROM mysql.user
# WHERE user = 'root';
# ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'test_123';
# flush privileges;
