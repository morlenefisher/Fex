<?php
/**
 * Created by PhpStorm.
 * User: stirlyn
 * Date: 08/12/14
 * Time: 12:57
 */
require ("bootstrap.php");


$db = new PDO('mysql:host=localhost;port=3306;dbname=ashleylawrenceledgerphpaga', 'root', 'jungle',
  array( PDO::ATTR_PERSISTENT => false));

$res = $db->query("select * from bills order by bill_id DESC limit 10")->fetchAll(PDO::FETCH_CLASS, 'Digitalashleylawrence\Fex\Invoice');
print "<pre>";
print_r($res);
print "</pre>";

