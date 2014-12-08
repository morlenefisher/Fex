<?php
/**
 * Created by PhpStorm.
 * User: stirlyn
 * Date: 08/12/14
 * Time: 12:57
 */
require("bootstrap.php");

$db = new PDO('mysql:host=' . $db_default['host'] . ';port=3306;dbname=' . $db_default['dbname'],
  $db_default['username'], $db_default['password'],
  array(PDO::ATTR_PERSISTENT => FALSE));

$res = $db->query("select * from bills order by bill_id DESC limit 10")
          ->fetchAll(PDO::FETCH_CLASS, 'Digitalashleylawrence\Fex\Invoice');
print "<pre>";
print_r($res);
print "</pre>";

