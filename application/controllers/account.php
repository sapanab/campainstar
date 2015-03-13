<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class account extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
    function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}

	public function details()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'account';
           $data['title']='Account';
            $this->load->view('template',$data);
   }
    	public function campany()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'campany';
           $data['title']='campany';
            $this->load->view('template',$data);
   }
    	public function setting()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'setting';
           $data['title']='setting';
            $this->load->view('template',$data);
   }
    	public function billing()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'billing';
           $data['title']='billing';
            $this->load->view('template',$data);
   }
    	public function mycampaign()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'mycampaign';
           $data['title']='mycampaign';
            $this->load->view('template',$data);
   }
    	public function resultsandanaltys()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'resultsandanaltys';
           $data['title']='resultsandanaltys';
            $this->load->view('template',$data);
   }
    public function result()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'result';
           $data['title']='result';
            $this->load->view('template',$data);
   }

public function mycampaignteam()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'mycampaignteam';
           $data['title']='mycampaignteam';
            $this->load->view('template',$data);
   }
public function team()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'team';
           $data['title']='team';
            $this->load->view('template',$data);
   }
	public function selectteama()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'selectteama';
           $data['title']='selectteama';
            $this->load->view('template',$data);
   }
    	public function campangnedit()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'campangnedit';
           $data['title']='campangnedit';
            $this->load->view('template',$data);
   }
}
?>