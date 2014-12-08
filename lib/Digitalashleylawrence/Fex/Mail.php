<?php

namespace Digitalashleylawrence\Fex;

class Mail {


  public $to;
  public $from;
  public $subject;
  public $message;
  public $headers;
  public $params;

  /**
   * @param bool $to
   * @param bool $from
   * @param bool $subject
   * @param bool $message
   * @param bool $headers
   * @param bool $params
   */
  public function __construct($to = FALSE, $from = FALSE, $subject = FALSE, $message = FALSE, $headers = FALSE, $params = FALSE) {

    if ($to)
      $this->to = $to;

    if ($from)
      $this->from = $from;

    if ($subject)
      $this->subject = $subject;

    if ($message)
      $this->message = $message;

    if ($headers)
      $this->headers = $headers;

    if ($params)
      $this->params = $params;
  }

  public function send(){

   $result =  mail($this->to, $this->subject, $this->message, $this->headers, $this->params);
    if (!$result) {
      throw new Exception('Mail failed to send');
    }
  }


}