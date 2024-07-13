<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Slot;
use App\Models\Rack;
use App\Models\Issue;
use App\Models\Strain;
use App\Models\Infrastructure;
use App\Models\Maintenance;
use App\Models\Dailyherdrecord;

use DateTime;

trait DashTempHumidityGraphTrait
{
    
    public function processTempHumidGraphData()
    {
        
        //$input = Dailyherdrecord::all();
        $input =Dailyherdrecord::with('sops')->orderBy('created_at', 'desc')->take(7)->get();
        
        //dd($input);
        
        if(count($input) > 0 )
        {
          $a = array();
          $b = array();
          
          foreach($input as $row)
          {
              $res1 = Dailyherdrecord::select('entry_date','temperature', 'humidity')->where('herd_id', $row->herd_id)->get()->toArray();
              $a[$row->herd_id] = $res1;
              $res1 = array();
          }
  
          foreach($a as $key => $row)
          {
              $herds[] = $key;
              foreach($row as $kk => $val)
              {
                $Xaxis[] = date('M d', strtotime($val['entry_date']));
                $temp[$val['entry_date']][] = intval($val['temperature']);
                $humidity[$val['entry_date']][] = intval($val['humidity']);
              }
          }
          
         
          foreach($temp as $key => $val)
          {
              $temp[$key] = reset($val);
          }
          
          foreach($humidity as $key => $val)
          {
              $humidity[$key] = reset($val);
          }
          
          foreach($temp as $key => $val)
          {
              $xtempx[] = $val;
          }
          
          foreach($humidity as $key => $val)
          {
              $xhumdx[] = $val;
          }
          
          $px = array_values(array_unique($Xaxis));
              
          //collect only Last 7 days only
          $px = array_slice($px, 0, 7);
          $xtempx = array_slice($xtempx, 0, 7);
          $xhumdx = array_slice($xhumdx, 0, 7);

          $px = array_reverse($px);
          $xtempx = array_reverse($xtempx);
          $xhumdx = array_reverse($xhumdx);

          //make json array
          $xax = json_encode($px);
          $tempx = json_encode($xtempx);
          $humdx = json_encode($xhumdx);
          //dd($herds, $xax, $tempx, $humdx);

          //return values
          $final['xth'] = $xax;
          $final['temp'] = $tempx;
          $final['humid'] = $humdx;
          $final['drecords'] = $input;
        }
        else {
          //return empty array
          //make json array
          $px = [];
          $xtempx =[];
          $xhumdx = [];
          
          $xax = json_encode($px);
          $tempx = json_encode($xtempx);
          $humdx = json_encode($xhumdx);
          //dd($herds, $xax, $tempx, $humdx);
          
          //return values
          $final['xth'] = $xax;
          $final['temp'] = $tempx;
          $final['humid'] = $humdx;
          $final['drecords'] = $input;

        }
        return $final;
    }
    
}