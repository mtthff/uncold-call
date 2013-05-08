<?php


try{
    $db_name = 'nocoldcalls.sqlite';

// open the database - if database exists, then opens the existing one, else opens a new one.
	
    $db = new PDO("sqlite:$db_name");
	
    echo "Database - $db_name<br /><br />";
	
    //create a table in the database
    
    //Table CUSTOMER
    $db->exec("
        CREATE TABLE IF NOT EXISTS customer (
            id INT(255) NOT NULL auto_increment,
            organisation VARCHAR(255) NULL DEFAULT NULL,
            street VARCHAR(255) NULL DEFAULT NULL,
            postcode INT(5) NULL DEFAULT NULL,
            city VARCHAR(255) NULL DEFAULT NULL,
            phone VARCHAR(255) NULL DEFAULT NULL,
            mobil VARCHAR(255) NULL DEFAULT NULL,
            email VARCHAR(255) NULL DEFAULT NULL,
          PRIMARY KEY (id)
        );
    ");    
	
   //Table APPOINTMENT
    $db->exec("
        CREATE TABLE IF NOT EXISTS appointment (
            id INT(255) NOT NULL auto_increment,
            customer-id INT(255) NULL DEFAULT NULL,
            datetime DATETIME NULL DEFAULT '0000-00-00 00:00:00',
            contact VARCHAR(255) NULL DEFAULT NULL,
            phone VARCHAR(255) NULL DEFAULT NULL,
            mobil VARCHAR(255) NULL DEFAULT NULL,
            email VARCHAR(255) NULL DEFAULT NULL,
            number INT(24) NULL DEFAULT NULL,
            listed-id INT(255) NULL DEFAULT NULL,
            listed-date DATE NULL DEFAULT NULL'0000-00-00',
            type-id INT(255) NULL DEFAULT NULL,
            specialized-value MEDIUMTEXT NULL DEFAULT NULL,
          PRIMARY KEY (id)
        );        
    ");
    
   //Table SPECIALIZED
    $db->exec("
        CREATE TABLE IF NOT EXISTS specialized (
          id INT(255) NOT NULL auto_increment,
          name VARCHAR(255) NULL DEFAULT NULL,
          type-id INT(255) NULL DEFAULT NULL,
          PRIMARY KEY (id)
        );
    ");
    
   //Table TYPE
    $db->exec("
        CREATE TABLE IF NOT EXISTS type (
          id INT(255) NOT NULL auto_increment,
          name VARCHAR(255) NULL DEFAULT NULL,
          PRIMARY KEY (id)
        );
    ");
    
   //Table CONTRIBUTOR
    $db->exec("
        CREATE TABLE IF NOT EXISTS contributor (
          id INT(255) NOT NULL auto_increment,
          name VARCHAR(255) NULL DEFAULT NULL,
          PRIMARY KEY (id)
        );
    ");
    
    //close the database connection
    $db = NULL;
    
}catch(PDOException $e){
    print 'Exception : '.$e->getMessage();
}
