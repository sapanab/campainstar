<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HAuth extends CI_Controller {

	public function index()
	{
		$this->load->view('hauth/home');
	}

	public function login($provider)
	{
		//log_message('debug', "controllers.HAuth.login($provider) called");

		try
		{
			//log_message('debug', 'controllers.HAuth.login: loading HybridAuthLib');
			//$this->load->library('HybridAuthLib');

			if ($this->hybridauthlib->providerEnabled($provider))
			{
				//log_message('debug', "controllers.HAuth.login: service $provider enabled, trying to authenticate.");
				$service = $this->hybridauthlib->authenticate($provider);

				if ($service->isUserConnected())
				{
					//log_message('debug', 'controller.HAuth.login: user authenticated.');

					$user_profile = $service->getUserProfile();

					//log_message('info', 'controllers.HAuth.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));
                    $userid=$this->session->userdata("id");
					$data["message"]=$user_profile;
					
                    if ($this->uri->segment(3) == 'Facebook')
                    {
                        $name=$user_profile->firstName.' '.$user_profile->lastName;
                        $dob=$user_profile->birthYear.'-'.$user_profile->birthMonth.'-'.$user_profile->birthDay;
                        $newid=$user_profile->identifier;
                        $checkfacebook=$this->db->query("SELECT count(*) as `count1` FROM `user` WHERE `facebookid`='$newid'")->row();
                        if($checkfacebook->count1=='0')
                        {
                            $this->db->query("UPDATE `user` SET `facebookid`='$user_profile->identifier',`name`='$name',`sex`='$user_profile->gender',`dob`='$dob',`image`='$user_profile->photoURL' WHERE `id`='$userid'");

                            $data = $this->session->all_userdata();
                            $data['alertsuccess']="Successfully loggedin with Facebook Account.";
                            $data['facebook'] = $user_profile->identifier;
                            $this->session->set_userdata($data);
                            
                        }
                        else
                        {
                            $data['alerterror']="An another user has already logged in to Facebook acount using same login.";
                            $service->logout(); 
                        }
                    }
                    if ($this->uri->segment(3) == 'Twitter')
                    {
                        $newid=$user_profile->identifier;
                        $checktwitter=$this->db->query("SELECT count(*) as `count1` FROM `user` WHERE `twitterid`='$newid'")->row();
                        if($checktwitter->count1=='0')
                        {
                            $this->db->query("UPDATE `user` SET `twitterid`='$user_profile->identifier' WHERE `id`='$userid'");
                            $data = $this->session->all_userdata();
                            $data['alertsuccess']="Successfully loggedin with Twitter Account.";
                            $data['twitter'] = $user_profile->identifier;
                            $this->session->set_userdata($data); 
                            
                        }
                        else
                        {
                            $data['alerterror']="An another user has already logged in to Twitter acount using same login.";
                            $service->logout(); 
                        }
                    }
                    
                    $data['redirect']="site/index";
			        $this->load->view("redirect",$data);
				}
				else // Cannot authenticate user
				{
					show_error('Cannot authenticate user');
				}
			}
			else // This service is not enabled.
			{
				//log_message('error', 'controllers.HAuth.login: This provider is not enabled ('.$provider.')');
				show_404($_SERVER['REQUEST_URI']);
			}
		}
		catch(Exception $e)
		{
			$error = 'Unexpected error';
			switch($e->getCode())
			{
				case 0 : $error = 'Unspecified error.'; break;
				case 1 : $error = 'Hybriauth configuration error.'; break;
				case 2 : $error = 'Provider not properly configured.'; break;
				case 3 : $error = 'Unknown or disabled provider.'; break;
				case 4 : $error = 'Missing provider application credentials.'; break;
				case 5 : //log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
				         //redirect();
				         if (isset($service))
				         {
				         	//log_message('debug', 'controllers.HAuth.login: logging out from service.');
				         	$service->logout();
				         }
				         show_error('User has cancelled the authentication or the provider refused the connection.');
				         break;
				case 6 : $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
				         break;
				case 7 : $error = 'User not connected to the provider.';
				         break;
			}

			if (isset($service))
			{
				$service->logout();
			}

			//log_message('error', 'controllers.HAuth.login: '.$error);
			show_error('Error authenticating user.');
		}
	}

	public function endpoint()
	{

		//log_message('debug', 'controllers.HAuth.endpoint called.');
		//log_message('info', 'controllers.HAuth.endpoint: $_REQUEST: '.print_r($_REQUEST, TRUE));

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			//log_message('debug', 'controllers.HAuth.endpoint: the request method is GET, copying REQUEST array into GET array.');
			$_GET = $_REQUEST;
		}

		//log_message('debug', 'controllers.HAuth.endpoint: loading the original HybridAuth endpoint script.');
		require_once APPPATH.'/third_party/hybridauth/index.php';

	}
    public function posttweet()
    {
        $twitter = $this->hybridauthlib->authenticate("Twitter");
        $message=$this->input->get_post("message");
        $post=$this->input->get('id');
        $twitterid = $twitter->getUserProfile();
        $twitterid = $twitterid->identifier;
        
        $userid=$this->session->userdata('id');
        $querytwitter=$this->db->query("SELECT `twitterid` FROM `user` WHERE `id`='$userid'")->row();
        $twitternid=$querytwitter->twitterid;
        if($twitterid==$twitternid) {
        $data["message"]=$twitter->api()->post("statuses/update.json?status=$message");
        if(isset($data["message"]->id_str))
        {
            $this->userpost_model->addpostid($data["message"]->id_str,$post);
            $data['alertsuccess']="Tweeted Successfully.";
            $data['redirect']="site/viewtwitterpost";
            $this->load->view("redirect",$data);
        }
        else
        {
			$data['alerterror'] = "Tweet Error";
            $data['redirect']="site/viewtwitterpost";
		    $this->load->view("redirect",$data);
        }
        }
        else
        {
                $data['alerterror'] = "Please login with your own Twitter Profile.";
                $data['redirect']="site/viewtwitterpost";
                $this->load->view("redirect",$data);
        }
//        $this->load->view("json",$data);
    }
    public function postfb()
    {
        $post=$this->input->get('id');
        $facebook = $this->hybridauthlib->authenticate("Facebook");
        $message=$this->input->get_post("message");
        $image=$this->input->get_post("image");
        $link=$this->input->get_post("link");
        
        $facebookid = $facebook->getUserProfile();
        $facebookid = $facebookid->identifier;
        
        $userid=$this->session->userdata('id');
        $queryfacebook=$this->db->query("SELECT `facebookid` FROM `user` WHERE `id`='$userid'")->row();
        $facebooknid=$queryfacebook->facebookid;
        
        if($facebookid==$facebooknid)
        {
            
        if($image=="")
        {
            $data["message"]=$facebook->api()->api("v2.2/me/feed", "post", array(
                "message" => "$message",
                "link"=>"$link"
            ));
            
            if(isset($data["message"]['id']))
            {
			$data['alertsuccess']="Posted Successfully.";
            $this->userpost_model->addpostid($data["message"]['id'],$post);
            $data['redirect']="site/viewfacebookpost";
            $this->load->view("redirect",$data);
            }
            else
            {
                $data['alerterror'] = "Post Error";
                $data['redirect']="site/viewfacebookpost";
                $this->load->view("redirect",$data);
            }
        }
        else
        {
            $data["message"]=$facebook->api()->api("v2.2/me/feed", "post", array(
                "message" => "$message",
                "picture"=> "$image",
                "link"=>"$link"
            ));
            
//            print_r($data['message']["id"]);
            
            if(isset($data["message"]["id"]))
            {
			$data['alertsuccess']="Posted Successfully.";
            $this->userpost_model->addpostid($data["message"]["id"],$post);
            $data['redirect']="site/viewfacebookpost";
            $this->load->view("redirect",$data);
            }
            else
            {
                $data['alerterror'] = "Post Error";
                $data['redirect']="site/viewfacebookpost";
                $this->load->view("redirect",$data);
            }
        }
        
        
        }
        else
        {
            
                $data['alerterror'] = "Please login with your own Facebook Profile.";
                $data['redirect']="site/viewfacebookpost";
                //echo $data['alerterror'];
                $this->load->view("redirect",$data);
        }

        
    }
    function checkfacebooklike() {
        $facebook = $this->hybridauthlib->getAdapter("Facebook");
        $likes=$facebook->api()->api("v2.2/921220457889147_923034417707751/likes?summary=1");
        print_r($likes["summary"]["total_count"]);
        $share=$facebook->api()->api("v2.2/921220457889147_923034417707751");
        print_r($share["shares"]);
        $comment=$facebook->api()->api("v2.2/921220457889147_923034417707751/comments?summary=1");
        print_r($comment["summary"]["total_count"]);
        $this->load->view("json",$data);
    }
    function checktwitterupdates() {
        
        // Loading TwitterOauth library. Delete this line if you choose autoload method.
		$this->load->library('twitteroauth');
		// Loading twitter configuration.
		$this->config->load('twitter');
        $data["message"] = $this->rest->get('statuses/show.json?id=548520769760673792');
        
        
        //$twitter = $this->hybridauthlib->getAdapter("Twitter");
        //$data["message"]=$twitter->api()->get("statuses/show.json?id=548520769760673792");
        //print_r($data["message"]->retweet_count);print_r($data["message"]->favorite_count);
        $this->load->view("json",$data);
    }
}

/* End of file hauth.php */
/* Location: ./application/controllers/hauth.php */
