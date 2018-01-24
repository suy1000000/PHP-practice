<?php

// This is the database connection configuration.
return array(
    //'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    // uncomment the following lines to use a MySQL database
    //http://www.yiiframework.com/doc/blog/1.1/en/final.deployment
    'class'=>'system.db.CDbConnection',
    'connectionString' => 'mysql:host=localhost;port=3309;dbname=blog',
    'schemaCachingDuration'=>3600,
    'emulatePrepare' => true,
    'username' => 'cat104',
    'password' => 'cat1221',
    'charset' => 'utf8',
    'tablePrefix' => 'tbl_',
    'enableParamLogging' => true,
    'enableProfiling' =>true,
);
