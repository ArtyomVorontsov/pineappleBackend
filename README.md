# Pineapple Backend

## Description
This is web beveloper test task. 

In task we have 3 parts: 

1. HTML5 and CSS3
2. Javascript
3. PHP

This repo contains PHP backend part of the task.

## Installation

#### Database:
To run it locally first you need to have installed MySQL db and then create database in example "PineappleDB", 
after that you should create 2 tables for emails and email providers.
All commands to create db we can see below:
```
CREATE DATABASE PineappleDb;

USE PineappleDb;

CREATE TABLE `emails` (
  `email` VARCHAR(255) NOT NULL,    
  `id` INT(255) NOT NULL auto_increment,    
  `emailProvider` VARCHAR(255) NOT NULL,    
  `createdAt` TIMESTAMP default NOW(),
  PRIMARY KEY(`id`));
  
CREATE TABLE `emailProviders` (
  `emailProvider` VARCHAR(255) NOT NULL unique,
  `id` INT(255) NOT NULL auto_increment unique,
  PRIMARY KEY(`emailProvider`));
```

#### Apache and PHP:

Because my project uses .htaccess file to get url routes you should use webserver Apache and
configure it in httpd.conf file.
Server should allow overwrite self behavior by .htaccess files.

You should install php thread safe version 7 or higher.
My project use PDO to connect to MySQL, your php should have a PDO MySQL driver. 
You should turn on it in **php.ini**

Clone all code from this repo to folder which serves your apache server. 
Configure Service.php file with your db password, username , name, host and run server 
with command **apachectl start**. After that you will be able to handle requests from client. 
(client repo: https://github.com/ArtyomVorontsov/pineapple)

