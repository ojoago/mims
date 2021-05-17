<?php

  class Spreadsheet{

    private $db;
    public function __construct(){
      $this->db=new Database;
    }




    public function writeMeterNumber($data){
      $i=1;
      foreach($data as $row){
        $this->db->query("INSERT INTO meter_numbers SET number=:n, type=:t, box=:b, created_on=:o,pid=:pid ");
        // $this->db->bind(':i',$i);
        $this->db->bind(':n',removeSpace($row[1]));
        $this->db->bind(':b',escapeString($row[2]));
        $this->db->bind(':t',escapeString($row[3]));
        $this->db->bind(':pid',getPID());
        $this->db->bind(':o',dateTime());
        if(strtoupper($row[1])=='METER NUMBER' or $row[2]=='Meter BOX No' or $row[0]=='SN' or findByCol('meter_numbers','number',removeSpace($row[0])))
          continue;
        $this->db->execute();
        $i++;
      }
    }
    public function writeMeterCustomer($data){
      $i=1;
      foreach($data as $row){
        $this->db->query("INSERT INTO jed_customers SET id=:i,account_number=:no, fullname=:name, address=:adr,feeder33kv=:f33,tariff_code=:tariff,
                        transformer_number=:dt, dt_name=:dtn,feeder=:f,area=:area, region=:region, gsm=:gsm,date=:date,cin=:cin ");
        $this->db->bind(':no',removeSpace(escapeString($row[0])));
        $this->db->bind(':cin',' '.$row[1]);
        $this->db->bind(':dtn',$row[2]);
        $this->db->bind(':name',$row[3]);
        $this->db->bind(':adr',$row[4]);
        $this->db->bind(':f33',$row[5]);
        $this->db->bind(':tariff',$row[6]);
        $this->db->bind(':dt',$row[7]);
        $this->db->bind(':f',$row[8]);
        $this->db->bind(':area',$row[9]);
        $this->db->bind(':region',$row[10]);
        $this->db->bind(':gsm',$row[11]);
        $this->db->bind(':date',dateTime());
        $this->db->bind(':i',$i);
        //571667	07051022101028503201302002	ALHERI	YUNUSA AHMED	ALHERI	DOMA	R2	GM-0C-1A-1E-11-03	BCGA	DOMA	GOMBE	7030936284
        if($row[3]=='CustomerFirstName' or $row[4]=='CustomerAddress' or $row[0]=='Customer AccountNo' or findByCol('jed_customers','account_number',removeSpace(escapeString($row[0]))))
          continue;
          // findByCol('jed_customers','account_number',removeSpace(escapeString($row[0])));
          // continue;
        $this->db->execute();
        $i++;
      }
    }
  }
