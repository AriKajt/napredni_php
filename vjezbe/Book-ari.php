
<?php

class Book {
  // Properties
  private $title;
  private $author;
  private $isbn;
  public $available;

  // Methods
  function __construct(string $title, string $author, $isbn)
  {
    $this->title = $title; 
    $this->author = $author; 
    $this->isbn = $isbn; 
    $this->available = true;
  }

  function borrow() : bool {
    if ($this->available) {
      $this->available = false;
      return true;
    } else {
      return false;
    }
  }

  function returnBook() {
    $this->available = true;
  }

  function getInfo() : string {
    return "$this->title, $this->author, $this->isbn";
  }

}


?>
