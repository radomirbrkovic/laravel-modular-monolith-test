<?php

namespace Modules\Payment\Exceptions;

class EventCloseException extends \Exception
{
    protected $message = "The event is closed.";
}
