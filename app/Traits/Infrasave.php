<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\Infrastructure;

trait Infrasave
{
  public function save_infra_item($input)
  {
    $infra = new Infrastructure();
    $infra->name = $input['name'];
    $infra->nickName = $input['nickname'];
    $infra->description = $input['desc'];
    $infra->date_acquired = $input['dateacqrd'];
    $infra->make = $input['make'];
    $infra->model = $input['model'];
    $infra->vendor_address = $input['vendor'];
    $infra->vendor_phone = $input['phone'];
    $infra->vendor_email = $input['email'];
    $infra->building = $input['building'];
    $infra->floor = $input['floor'];
    $infra->room = $input['room'];
    $infra->amc = $input['amc'];
    $infra->amc_start = $input['amcstart'];
    $infra->amc_end = $input['amcend'];
    $infra->supervisor = $input['supervisor'];
    //dd($infra);

    $result = $infra->save();
  }
}