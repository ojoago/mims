<?php
class View{
    private $db;
    private $db_tbl="comsprime_customer";
    protected $payments='comsprime_payments';
    private $edat_tbl = EDAT_TBL;
    private $met_tbl = MET_TBL;
    private $user_tbl = USER_TBL;
    protected $cmp="company";
    public function __construct(){
        $this->db = new Database;
    }
    public function viewCompleteInfo(){
        $this->db->query("SELECT * FROM ".$this->cust_tbl." LEFT JOIN ".$this->met_tbl." ON
        ".$this->cust_tbl.".cid = ".$this->met_tbl.".cid LEFT JOIN ".$this->edat_tbl." ON eid=edat_id LEFT JOIN ".$this->user_tbl."
        ON ".$this->user_tbl.".user_id=installer ORDER BY pdate DESC LIMIT 200");
        $results = $this->db->resultSet();
        return $results;
    }
    public function viewCustomer(){
        $this->db->query("SELECT ".$this->db_tbl.".*,".$this->payments.".payment_date,".$this->payments.".gateway,
        ".$this->payments.".reference,".$this->user_tbl.".uid,".$this->cmp.".names FROM ".$this->db_tbl."
        INNER JOIN ".$this->payments." ON ".$this->payments.".cid = ".$this->db_tbl.".id
        LEFT JOIN ".$this->user_tbl." ON asignedto = ".$this->user_tbl.".user_id LEFT JOIN ".$this->cmp." ON cmid=cmp
        WHERE ".$this->payments.".status='paid' ORDER BY ".$this->payments.".payment_date DESC");
        $results = $this->db->resultSet();
        return $results;
    }

    public function viewEdat(){
        $this->db->query("SELECT * FROM ".$this->edat_tbl." LEFT JOIN ".$this->user_tbl." ON installer=user_id");
        $results = $this->db->resultSet();
        return $results;
    }
    public function viewMeter(){
        $this->db->query("SELECT * FROM ".$this->met_tbl."");
        $results = $this->db->resultSet();
        return $results;
    }

}
