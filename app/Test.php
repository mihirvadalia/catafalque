<?php

namespace App;

use LaravelArdent\Ardent\Ardent;

class Test extends Ardent
{
    public static $rules = array(
        'name'                  => 'required|between:3,80|alpha_dash',
        'address'               => 'required|between:5,64|email',
        'status'                => 'required|min:6'
    );
}
