<?php

namespace Digitalashleylawrence\Fex;
use \PDO, \PDOStatement;
class Company {
//
//cpn_id
//| cpn_name
//| cpn_address
//| cpn_city
//| cpn_zip            | varchar(30)  | YES  | MUL | NULL    |       |
//| cpn_region         | varchar(40)  | YES  | MUL | NULL    |       |
//| ctr_id             | int(11)      | NO   | MUL | 0       |       |
//| ccat_id            | tinyint(4)   | NO   | MUL | 0       |       |
//| cpn_taxnr          | varchar(30)  | YES  | MUL | NULL    |       |
//| cpn_url            | varchar(200) | YES  |     | NULL    |       |
//| cpn_phone          | varchar(30)  | YES  |     | NULL    |       |
//| cpn_fax            | varchar(30)  | YES  |     | NULL    |       |
//| cpn_email          | varchar(100) | YES  |     | NULL    |       |
//| cpn_public         | tinyint(4)   | YES  | MUL | NULL    |       |
//| pe_id              | bigint(20)   | NO   | MUL | 0       |       |
//| cpn_logoname       | varchar(250) | YES  |     | NULL    |       |
//| cpn_bill_footer    | varchar(250) | YES  |     | NULL    |       |
//| cpn_owner_taxnr    | varchar(30)  | YES  |     | NULL    |       |
//| cpn_defaultpayterm | varchar(30)  | YES  |     | NULL    |       |
//| cpn_address2

  protected $db_conn;

  protected function getConn() {
    $this->db_conn = new PDO('mysql:host=localhost;port=3306;dbname=ashleylawrenceledgerphpaga', 'root', 'jungle',
      array( PDO::ATTR_PERSISTENT => true));
  }

  public function __construct() {
    $this->getConn();
    $this->line_items = $this->getBillItems();
    $this->companies = $this->getBillCompany();
  }


  public function getBillItems() {
    return $this->db_conn->query("select * from lineitems where bill_id = $this->bill_id")->fetchAll(PDO::FETCH_CLASS);
  }

  public function getBillCompany() {
    return $this->db_conn->query("select * from companies where cpn_id = $this->cpn_id")->fetchAll(PDO::FETCH_CLASS);
  }


}