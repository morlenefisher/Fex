<?php

namespace Digitalashleylawrence\Fex;

use \PDO, \PDOStatement;

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

  protected function getConn() {

    $this->db_conn = new PDO('mysql:host=localhost;port=3306;dbname=ashleylawrenceledgerphpaga', 'root', 'jungle',
      array(PDO::ATTR_PERSISTENT => TRUE));
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