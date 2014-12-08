<?php

namespace Digitalashleylawrence\Fex;

use \PDO;

class Contact {

  protected $db_conn;

  /**
   * (Required if either first_name or last_name are empty)
   * @var
   */
  public $organisation_name;

  /**
   * (Required if organisation_name is empty)
   * @var
   */
  public $first_name;

  /**
   *  (Required if organisation_name is empty)
   * @var
   */
  public $last_name;

  public $email;

  public $phone_number;

  public $address1;

  public $town;

  public $region;

  public $postcode;

  public $address2;

  public $address3;

  public $contact_name_on_invoices;

  public $country;

  public $sales_tax_registration_number;

  public $uses_contact_invoice_sequence;

  // from PHPAga
  public $cpn_id;

  public $cpn_name;

  public $cpn_address;

  public $cpn_city;

  public $cpn_zip;

  public $cpn_region;

  public $ctr_id;

  public $cpn_taxnr;

  public $cpn_url;

  public $cpn_phone;

  public $cpn_fax;

  public $cpn_email;

  public $cpn_public;

  public $cpn_logoname;

  public $cpn_bill_footer;

  public $cpn_owner_taxnr;

  public $cpn_defaultpayterm;

  public $cpn_address2;

  public $pe_id;

  protected function getConn() {

    global $db_default;
    $this->db_conn = new PDO('mysql:host=' . $db_default['host'] . ';port=3306;dbname=' . $db_default['dbname'],
      $db_default['username'], $db_default['password'],
      array(PDO::ATTR_PERSISTENT => FALSE));
  }

  public function __construct() {

    $this->getConn();
    $this->people = $this->getContactPeople();
  }

  public function getContactPeople() {

    return $this->db_conn->query("select * from persons where pe_id = $this->pe_id")
                         ->fetchAll(PDO::FETCH_CLASS);
  }

  /**
   * Maps the phpaga fields to the FreeAgent API fields
   */
  protected function mapToFreeAgentApi() {

    $this->organisation_name = $this->cpn_name;
    //$this->first_name;
    //$this->last_name;
    $this->email = $this->cpn_email;
    $this->phone_number = $this->cpn_phone;
    $this->address1 = $this->cpn_address;
    $this->address2 = $this->cpn_address2;
    $this->town = $this->cpn_city;
    $this->region = $this->cpn_region;
    //$this->contact_name_on_invoices;
    $this->postcode = $this->cpn_zip;
    $this->country = $this->getCountryCode($this->ctr_id);
    $this->sales_tax_registration_number = $this->cpn_taxnr;
    $this->uses_contact_invoice_sequence = FALSE;
  }
}