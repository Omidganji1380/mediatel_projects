<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Seo implements Rule
{
 private $len;
 private $title;

 /**
  * Create a new rule instance.
  * @return void
  */
 public function __construct($title, $type = 'title')
 {
  $this->len = seoPreviewLen($type)['max'];
  $this->title = $title;
 }

 /**
  * Determine if the validation rule passes.
  * @param string $attribute
  * @param mixed $value
  * @return bool
  */
 public function passes($attribute, $value)
 {
  return strlen(seoPreview($value, $this->title)) <= $this->len;
 }

 /**
  * Get the validation error message.
  * @return string
  */
 public function message()
 {
  return str_replace(':max', $this->len, 'فیلد :attribute باید حداکثر :max حرف باشد.');
 }
}
