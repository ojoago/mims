<?php

namespace App\Imports;

use App\Models\Region\Schedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;

class ImportScheduleList implements ToModel,WithGroupedHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        logError($row);

        return new Schedule([
            'region_pid' => getRegionPid(),
            'pid' => public_id(),
            'state' => $row['state'],
            'region' => $row['region'],
            // 'meter_number' => $row['region'],
            'account_number' => $row['account_number'],
            'account_name' => $row['account_name'],
            'contact' => $row['contact_information'],
            'feeder_33' => $row['33kv_feeder'],
            'feeder_11' => $row['11kv_feeder'],
            'dt_name' => $row['dt_name'],
            'band' => $row['band'],
            'load' => $row['expected_load_in_amps'],
            'meter_type' => $row['meter_type'],
            'connection_status' => $row['connection_status'],
            'address' => $row['address'],
           
            'creator'  => getUserPid()
        ]);
          
    }
}
