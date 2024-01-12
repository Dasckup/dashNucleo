<?php

namespace App\Http\Extensions;
use App\Models\OptionsUsersReports;


class OptionsReport{

    static public function get(){
        return OptionsUsersReports::all();
    }
}
