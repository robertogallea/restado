<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 8/30/2017
 * Time: 1:47 PM
 */

namespace Robertogallea\Restado\Facades;
use Illuminate\Support\Facades\Facade;

class Restado extends Facade{
    protected static function getFacadeAccessor() { return 'restado'; }
}