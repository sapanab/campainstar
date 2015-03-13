<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class campaigngroup_model extends CI_Model
{
    public function create($campaign,$order,$status,$group)
    {
        $data=array(
            "campaign" => $campaign,
            "order" => $order,
            "status" => 2,
            "group" => $group
        );
        $query=$this->db->insert( "campaign_campaigngroup", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
        
}
?>
