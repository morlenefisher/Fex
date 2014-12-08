<?php

namespace Digitalashleylawrence\Fex;

class Invoice {

  public $vendor;
  public $code;
  public $expires;
  public $value;
  public $email;
  public $uuid;
  public $id;


  public function __construct() {
    $this->id = \UUID::v4();
  }


}