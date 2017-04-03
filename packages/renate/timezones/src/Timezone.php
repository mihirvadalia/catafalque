<?php

namespace Renate\Timezones;

use Carbon\Carbon;

class Timezone {

    public static function currentTimezone() {
        return date_default_timezone_get();
    }

}