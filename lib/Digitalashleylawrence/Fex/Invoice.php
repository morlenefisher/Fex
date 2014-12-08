<?php

namespace Digitalashleylawrence\Fex;

use \PDO, \Digitalashleylawrence\Fex\Contact;

class Invoice {

  public $bill_id;

  public $bill_desc;

  public $bill_number;

  public $bill_date;

  public $cpn_id;

  public $bill_sent;

  public $bill_paydate;

  public $bill_startsum;

  public $bill_endsum;

  public $bmt_d;

  public $curr_id;

  public $bill_footer;

  public $bill_payterm;

  public $bill_date_due;

  public $pe_id_recipient;

  public $rBill_id;

  public $bill_additional_ine;

  public $bill_note;

  public $line_items;

  public $companies;

  // mapping

  /**
   * @var mixed
   *   (Optional, If omitted next invoice reference will be used)
   */
  public $reference;

  /**
   * URL of contact get including contact id
   * https://api.freeagent.com/v2/contacts/2
   * @var string
   *   Required
   */
  public $contact;

  /**
   * Project
   * @var string
   */
  public $project;

  /**
   * @var
   *    (Optional, this is called "Additional Text" in the UI)
   */
  public $comments;

  /**
   * Discount on invoice
   * @var
   */
  public $discount_percent;

  /**
   * ISO date string of invoice date
   * @var string
   *    (Required)
   */
  public $dated_on;

  /**
   * ISO date string of invoice due date
   * @var string
   *
   */
  public $due_on;

  /**
   * Exchange rate
   * @var string
   */
  public $exchange_rate;

  /**
   * Payment terms
   * @var string
   *    (Required)
   */
  public $payment_terms_in_days;

  /**
   * ISO currency 3 char code
   * @var string
   */
  public $currency;

  /**
   * @var
   *   Can be one of
   * Non-EC, EC Goods or EC Services
   */
  public $ec_status;

  /**
   * PDO connection
   * @var PDO
   */
  protected $db_conn;

  /**
   * returns the db connection
   */
  protected function getConn() {

    global $db_default;
    new PDO('mysql:host=' . $db_default['host'] . ';port=3306;dbname=' . $db_default['dbname'],
      $db_default['username'], $db_default['password'],
      array(PDO::ATTR_PERSISTENT => FALSE));
  }

  public function __construct() {

    $this->mapTo();
    $this->getConn();
    $this->line_items = $this->getBillItems();
    $this->companies = $this->getBillCompany();
  }

  public function getBillItems() {

    return $this->db_conn->query("select * from lineitems where bill_id = $this->bill_id")
                         ->fetchAll(PDO::FETCH_CLASS);
  }

  public function getBillCompany() {

    return $this->db_conn->query("select * from companies where cpn_id = $this->cpn_id")
                         ->fetchAll(PDO::FETCH_CLASS, '\Digitalashleylawrence\Fex\Contact');
  }

  protected function mapTo() {

    $this->reference = $this->bill_id;
    $this->dated_on = $this->formatDateIso($this->bill_date);
    $this->contact = $this->cpn_id;

    $this->comments = $this->bill_desc;
    $this->currency = $this->curr_id;

    $this->due_on = $this->formatDateIso($this->bill_date_due);
    $this->payment_terms_in_days = $this->getPayTerms($this->bill_payterm);
    $this->ec_status = $this->getEcStatus();

  }

  /**
   * Returns an ISO formated date string or false of null value passed
   * @param $date
   *
   * @return bool|string
   */
  private function formatDateIso($date) {
    if (empty($date)) return FALSE;
    return date("c", strtotime($date));
  }

  /**
   * Returns default terms if none are set
   * @param string $terms
   *
   * @return string
   */
  private function getPayTerms($terms = '') {

    if ($terms) return $terms;
    return '30';
  }

  /**
   * Returns EC status of our invoice, must be one of
   * Non-EC, EC Goods or EC Services
   * If Company VAT registered at the time EC Services
   * If client company outside EC NON-EC
   */
  private function getEcStatus() {

    if ($this->companies[0]->ctr_id == 3) {
      return 'EC Services';
    }
    else {
      return "Non-EC";
    }
  }
}