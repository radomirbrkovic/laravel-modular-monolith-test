<?php

namespace Modules\Payment\Exceptions;

class NotAvelableSeatsException extends \Exception
{
    protected $message = "No available seats for this event.";
}
