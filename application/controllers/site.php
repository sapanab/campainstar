<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
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
//	function checkaccess($access)
//	{
//		$accesslevel=$this->session->userdata('accesslevel');
//		if(!in_array($accesslevel,$access))
//			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
//        if($accesslevel==2)
//        {
//            $data[ 'facebook' ] = $this->session->userdata("facebook")=="";
//            $data[ 'twitter' ] = $this->session->userdata("twitter")=="";
//            if(!$data['twitter'] && !$data[ 'facebook' ])
//            {
//            }
//            else
//            {
//                if($this->uri->segment(2)=="index")
//                {
//                }
//                else
//                {
//                    redirect('/site/index/', 'refresh');
//                }
//            }
//        }
//	}
	public function index()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
            $data[ 'page' ] = 'dashboard';
//            $data['base_url'] = site_url("site/index");
//            $data['totalcompassadors'] = $this->user_model->gettotalcompassadors();
//            $data['admindash'] = $this->userpost_model->getadmindash();
            $data['title']='Admin Dashboard';
            $this->load->view('template',$data);
            
	}
	public function viewmycampaign()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
        $data[ 'page' ] = 'viewmycampaign';
        $userid=$this->session->userdata('id');
        $data['table'] = $this->campaignaccess_model->getcampaignbyuser($userid);
        $data['title']='My Campaigns';
        $this->load->view('template',$data);
            
	}
	public function editcampaignbyuser()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
        $data[ 'page' ] = 'editcampaignbyuser';
        $userid=$this->session->userdata('id');
        $campaignid=$this->input->get('id');
        $data['before'] = $this->campaignaccess_model->beforeedit($campaignid);
//        $data['table'] = $this->campaignaccess_model->getcampaignbyuser($userid);
        $data['title']='Edit Campaigns';
        $this->load->view('template',$data);
            
	}
	public function deletecampaignbyuser()
    {
        $access=array("1","3");
        $this->checkaccess($access);
        $this->campaignaccess_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewmycampaign";
        $this->load->view("redirect",$data);
    }
    public function editcampaignsubmitbyuser()
    {
        $access=array("1","3");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("Name","Name","trim");
        $this->form_validation->set_rules("startdate","Start Date","trim");
        $this->form_validation->set_rules("testdate","Test Date","trim");
        $this->form_validation->set_rules("publishingdate","Publishing Date","trim");
        $this->form_validation->set_rules("user","User","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data[ 'page' ] = 'editcampaignbyuser';
            $userid=$this->session->userdata('id');
            $campaignid=$this->input->post('id');
            $data['before'] = $this->campaignaccess_model->beforeedit($campaignid);
            $data['title']='Edit Campaigns';
            $this->load->view('template',$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $Name=$this->input->get_post("Name");
            $startdate=$this->input->get_post("startdate");
            $testdate=$this->input->get_post("testdate");
            $publishingdate=$this->input->get_post("publishingdate");
            $user=$this->input->get_post("user");
            if($this->campaignaccess_model->edit($id,$Name,$startdate,$testdate,$publishingdate,$user)==0)
                $data["alerterror"]="New campaign could not be Updated.";
            else
                $data["alertsuccess"]="campaign Updated Successfully.";
            $data["redirect"]="site/viewmycampaign";
            $this->load->view("redirect",$data);
        }
    }
    
	public function viewcampaigngroup()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
        $data[ 'page' ] = 'viewcampaigngroup';
        $campaignid=$this->input->get('id');
//        $data['table'] = $this->campaignaccess_model->getallgroup();
        $data['table'] = $this->campaignaccess_model->getallgroupbycampaign($campaignid);
        $data['before'] = $this->campaignaccess_model->beforeedit($campaignid);
        $data['selectedgroup']=$this->campaignaccess_model->getselectedcampaigngroupbycampaign($campaignid);
//        $data['campaigntestreports']=$this->campaignaccess_model->getcampaigntestreportbycampaign($campaignid);
        $data['campaigntestreports']=$this->campaignaccess_model->getcampaigntestreportbycampaign1($campaignid);
        $data['campaignresultreports']=$this->campaignaccess_model->getcampaignresultreportbycampaign($campaignid);
        $data['campaignid']=$this->input->get('id');
        $data['title']='Campaign Groups';
        $this->load->view('template',$data);
            
	}
    
	function changecampaigngroupstatustoactive()
	{
		$access = array("1","3");
		$this->checkaccess($access);
        $campaigngroupid=$this->input->get('campaigngroupid');
        $campaignid=$this->input->get('id');
		$this->campaignaccess_model->changecampaigngroupstatustoactive($this->input->get('campaigngroupid'),$campaignid);
//        $data["redirect"]="site/viewcampaigngroup?id=".$campaignid;
        $data["redirect"]="site/viewcampaigngroupsbycampaign?id=".$campaignid;
        $this->load->view("redirect2",$data);
	}
	function changecampaigngroupstatustoreject()
	{
		$access = array("1","3");
		$this->checkaccess($access);
        $campaigngroupid=$this->input->get('campaigngroupid');
        $campaignid=$this->input->get('id');
		$this->campaignaccess_model->changecampaigngroupstatustoreject($this->input->get('campaigngroupid'));
//        $data["redirect"]="site/viewcampaigngroup?id=".$campaignid;
        $data["redirect"]="site/viewcampaigngroupsbycampaign?id=".$campaignid;
        $this->load->view("redirect2",$data);
	}
	function changecampaignstatustopublishcomplete()
	{
		$access = array("1","3");
		$this->checkaccess($access);
        $campaignid=$this->input->get('id');
		$this->campaignaccess_model->changecampaignstatustopublishcomplete($this->input->get('id'));
        $data["redirect"]="site/viewcampaigngroup?id=".$campaignid;
        $this->load->view("redirect2",$data);
	}
	function changecampaignstatustoabtestcomplete()
	{
		$access = array("1","3");
		$this->checkaccess($access);
        $campaignid=$this->input->get('id');
		$this->campaignaccess_model->changecampaignstatustoabtestcomplete($this->input->get('id'));
        $data["redirect"]="site/viewcampaigngroup?id=".$campaignid;
        $this->load->view("redirect2",$data);
	}
    
	public function viewcalender()
	{
		$access = array("1","2","3");
		$this->checkaccess($access);
        $data[ 'page' ] = 'viewcalender';
        $data['title']='Calender';
        $this->load->view('template',$data);
	}
	public function createcampaign()
	{
		$access = array("3");
		$this->checkaccess($access);
        $data[ 'page' ] = 'createcampaign';
        $data['title']='Create Campaign';
        $this->load->view('template',$data);
	}
    public function createcampaignsubmit() 
    {
        $access=array("3");
        $this->checkaccess($access);
        $this->form_validation->set_rules("Name","Name","trim|required");
        $this->form_validation->set_rules("startdate","Start Date","trim|required");
        $this->form_validation->set_rules("testdate","Test Date","trim|required");
        $this->form_validation->set_rules("publishingdate","Publishing Date","trim|required");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createcampaign";
            $data["title"]="Create campaign";
//            $data["status"]=$this->campaign_model->getcampaignstatusdropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $Name=$this->input->get_post("Name");
            $startdate=$this->input->get_post("startdate");
            $testdate=$this->input->get_post("testdate");
            $publishingdate=$this->input->get_post("publishingdate");
            $user=$this->session->userdata('id');
            if($this->campaignaccess_model->create($Name,$startdate,$testdate,$publishingdate,$user)==0)
            $data["alerterror"]="New Campaign could not be created.";
            else
            $data["alertsuccess"]="Campaign created Successfully.";
            $data["redirect"]="site/viewmycampaign";
            $this->load->view("redirect",$data);
        }
    }
    
    public function viewcampaigngroupsbycampaign()
    {
        $access=array("3");
        $this->checkaccess($access);
        $data["page"]="viewcampaigngroupsbycampaign";
        $campaignid=$this->input->get('id');
        $data['before']=$this->campaignaccess_model->beforeedit($campaignid);
        $data['table'] = $this->campaignaccess_model->getallgroupbycampaign($campaignid);
        $data['selectedgroup']=$this->campaignaccess_model->getselectedcampaigngroupbycampaign($campaignid);
//        print_r($data["base_url"]);
        $data["title"]="View Groups";
        $this->load->view("template",$data);
    }
    
    public function createcampaigngroup()
    {
           $access=array("3");
           $this->checkaccess($access);
        
//           $data["status"]=$this->CampaignGroup_model->getstatusdropdown();
           $data["group"]=$this->campaignaccess_model->getgroupdropdown();
           $data['campaign']=$this->input->get('id');
           $data["page"]="createcampaigngroupbycampaign";
           $data["title"]="Create Campaign Group";
           $this->load->view("template",$data);
    }
    public function createcampaigngroupsubmit() 
    {
        $access=array("3");
        $this->checkaccess($access);
         $campaign=$this->input->get_post("campaign");
        $this->form_validation->set_rules("order","order","trim");
        $this->form_validation->set_rules("status","Status","trim");
        $this->form_validation->set_rules("group","group","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
           $data["group"]=$this->campaignaccess_model->getgroupdropdown();
           $data['campaign']=$this->input->get_post('campaign');
            $data["page"]="createCampaignGroup";
            $data["title"]="Create CampaignGroup";
            $this->load->view("template",$data);
        }
        else
        {
            $campaign=$this->input->get_post("campaign");
            $order=$this->input->get_post("order");
            $status=$this->input->get_post("status");
            $group=$this->input->get_post("group");
            if($this->campaigngroup_model->create($campaign,$order,$status,$group)==0)
            $data["alerterror"]="New Campaign Group could not be created.";
        else
            $data["alertsuccess"]="Campaign Group created Successfully.";
             $data["redirect"]="site/viewcampaigngroupsbycampaign?id=".$campaign;
        $this->load->view("redirect2",$data);
        }
    }
}
?>