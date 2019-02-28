<?php

namespace MyApp\Exception;

class DuplicateId extends \Exception {

  protected $message = '入力のIDは登録済みです';

}

 ?>
