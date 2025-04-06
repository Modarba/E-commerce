<?php

namespace App\Actions;

 abstract class FilterSpecification
{
     abstract public function apply($query, $value);
}
