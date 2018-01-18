<?php

// This is the database connection configuration.
return array(
    //'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    // uncomment the following lines to use a MySQL database
    
    'connectionString' => 'mysql:host=localhost;port=3309;dbname=blog',
    'emulatePrepare' => true,
    'username' => 'cat104',
    'password' => 'cat1221',
    'charset' => 'utf8',
    'tablePrefix' => 'tbl_',
    'enableParamLogging' => true,
    'enableProfiling' =>true,
);
