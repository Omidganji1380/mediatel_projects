<?php

namespace App\Services\Seeder;

use Thread;

class Seeder extends Thread
{
 public function __construct($i)
 {
  $this->i = $i;
 }

 public function ad()
 {
  return 'ad';
 }

 public function post()
 {
  return 'post';
 }

 public function run()
 {
  if ($this->i = 1) {
   $this->ad();
  }
  if ($this->i = 2) {
   $this->post();
  }
 }
}