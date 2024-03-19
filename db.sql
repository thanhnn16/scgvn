# drop database if exists scgvn_dev;
# create database if not exists scgvn_dev;
#
use scgvn_dev;
#
# create table users
# (
#     id             serial primary key,
#     username       varchar(255) not null,
#     password       varchar(255) not null,
#     remember_token varchar(100) null,
#     created_at     timestamp    not null default current_timestamp,
#     updated_at     timestamp    not null default current_timestamp
# );
#
# create table personal_access_tokens
# (
#     id             serial primary key,
#     tokenable_id   integer      not null,
#     tokenable_type varchar(255) not null,
#     name           varchar(255) not null,
#     token          varchar(64)  not null unique,
#     abilities      text         null,
#     last_used_at   timestamp    null,
#     expires_at     timestamp    null,
#     created_at     timestamp    not null default current_timestamp,
#     updated_at     timestamp    not null default current_timestamp
# );
#
# create table events
# (
#     id         serial primary key,
#     title      varchar(255) not null,
#     content    text         null,
#     start_date date         not null,
#     end_date   date         not null,
#     status     enum ('draft', 'published', 'archived') default 'draft' not null,
#     created_at timestamp    not null                   default current_timestamp,
#     updated_at timestamp    not null                   default current_timestamp
# );
#
# create table provinces
# (
#     id         serial primary key,
#     province   varchar(50) not null,
#     created_at timestamp   not null default current_timestamp,
#     updated_at timestamp   not null default current_timestamp
# );
#
# create table distributors
# (
#     id               serial primary key,
#     distributor_name varchar(255) not null,
#     created_at       timestamp    not null default current_timestamp,
#     updated_at       timestamp    not null default current_timestamp,
#     province_id      integer references provinces (id)
# );
#
# create table prizes
# (
#     id         serial primary key,
#     prize_name varchar(255) not null,
#     prize_qty  integer      not null,
#     prize_desc text         null,
#     created_at timestamp    not null default current_timestamp,
#     updated_at timestamp    not null default current_timestamp,
#     event_id   integer references events (id)
# );
#
# create table agencies
# (
#     agency_id   varchar(20)  not null unique primary key,
#     keywords    varchar(50)  null,
#     agency_name varchar(255) not null,
#     created_at  timestamp    not null default current_timestamp,
#     updated_at  timestamp    not null default current_timestamp,
#     province_id integer references provinces (id)
# );
#
# create table event_agencies
# (
#     event_id   integer references events (id),
#     agency_id  varchar(20) references agencies (agency_id),
#     created_at timestamp   not null default current_timestamp,
#     updated_at timestamp   not null default current_timestamp,
#     primary key (event_id, agency_id),
#     prize_id  integer references prizes (id)
# );
#
#
# SET GLOBAL time_zone = '+7:00';
# SET time_zone = '+7:00';
drop trigger if exists update_remaining;

ALTER TABLE prizes
MODIFY COLUMN remaining integer;

# Q: is type INT = type integer in mysql?
# A: Yes, it is.

#
# DELIMITER //
# CREATE TRIGGER update_remaining
# BEFORE INSERT ON prizes
# FOR EACH ROW
# BEGIN
#    SET NEW.remaining = NEW.prize_qty;
# END;//
# DELIMITER ;
# remove trigger
# drop trigger update_remaining;
