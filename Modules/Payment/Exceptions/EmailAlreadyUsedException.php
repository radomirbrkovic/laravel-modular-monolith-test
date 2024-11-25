<?php

namespace Modules\Payment\Exceptions;

class EmailAlreadyUsedException extends \Exception
{
    protected $message = "Email already used for this event.";
}
