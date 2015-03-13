<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class User_model extends CI_Model
{
	protected $id,$username ,$password;
	public function validate($username,$password)
	{
		
		$password=md5($password);
		$query ="SELECT `user`.`id`,`user`.`name` as `name`,`email`,`user`.`accesslevel`,`accesslevel`.`name` as `access` FROM `user`
		INNER JOIN `accesslevel` ON `user`.`accesslevel` = `accesslevel`.`id` 
		WHERE `email` LIKE '$username' AND `password` LIKE '$password' AND `accesslevel`.`id` IN (3) ";
		$row =$this->db->query( $query );
		if ( $row->num_rows() > 0 ) {
			$row=$row->row();
			$this->id       = $row->id;
			$this->name = $row->name;
			$this->email = $row->email;
			$newdata        = array(
				'id' => $this->id,
				'email' => $this->email,
				'name' => $this->name ,
				'accesslevel' => $row->accesslevel ,
				'logged_in' => 'true',
			);
			$this->session->set_userdata( $newdata );
			return true;
		} //count( $row_array ) == 1
		else
			return false;
	}
	
	 public function getsexdropdown()
	{
		$sex= array(
			 "Male" => "Male",
			 "Female" => "Female"
			);
		return $sex;
	}
	 public function getcollegedropdown()
	{
		$college= array(
			 "1" => "Somaiiya",
			 "2" => "Ibsar"
			);
		return $college;
	}
	public function create($name,$email,$password,$accesslevel,$contact,$facebookid,$twitterid,$instagramid,$dob,$sex,$college,$city)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
			'password' =>md5($password),
			'accesslevel' => $accesslevel,
            'contact'=> $contact,
            'facebookid'=> $facebookid,
            'twitterid'=> $twitterid,
            'instagramid'=> $instagramid,
            'dob'=> $dob,
            'sex'=> $sex,
            'city'=> $city,
            'college'=> $college
		);
		$query=$this->db->insert( 'user', $data );
		$id=$this->db->insert_id();
        
		if(!$query)
			return  0;
		else
			return  1;
	}
    
	function viewusers($startfrom,$totallength)
	{
		$user = $this->session->userdata('accesslevel');
		$query="SELECT DISTINCT `user`.`id` as `id`,`user`.`firstname` as `firstname`,`user`.`lastname` as `lastname`,`accesslevel`.`name` as `accesslevel`	,`user`.`email` as `email`,`user`.`contact` as `contact`,`user`.`status` as `status`,`user`.`accesslevel` as `access`
		FROM `user`
	   INNER JOIN `accesslevel` ON `user`.`accesslevel`=`accesslevel`.`id`  ";
	   $accesslevel=$this->session->userdata('accesslevel');
	   if($accesslevel==1)
		{
			$query .= " ";
		}
		else if($accesslevel==2)
		{
			$query .= " WHERE `user`.`accesslevel`> '$accesslevel' ";
		}
		
	   $query.=" ORDER BY `user`.`id` ASC LIMIT $startfrom,$totallength";
		$query=$this->db->query($query)->result();
        
        $return=new stdClass();
        $return->query=$query;
        $return->totalcount=$this->db->query("SELECT count(*) as `totalcount` FROM `user`
	   INNER JOIN `accesslevel` ON `user`.`accesslevel`=`accesslevel`.`id`  ")->row();
        $return->totalcount=$return->totalcount->totalcount;
		return $return;
	}
	public function getnormaluserdata( $id )
	{
		$query=$this->db->query("SELECT `user`.`id`, `user`.`name`, `user`.`password`, `user`.`email`, `user`.`accesslevel`, `user`.`timestamp`, `user`.`status`,`user`. `contact`, `user`.`sex`, `user`.`dob`,`user`. `college`, `user`.`facebookid`, `user`.`twitterid`, `user`.`instagramid`,`user`. `image`,`college`.`name` AS `collegename` 
        FROM `user`
        LEFT OUTER JOIN `college` ON `college`.`id`=`user`.`college`
       WHERE `user`.`id`='$id'")->row();
		return $query;
	}
	
	public function getnormaluserdataold( $id )
	{
		$query=$this->db->query("SELECT `user`.`id` as `id`,`user`.`name` as `name`,`accesslevel`.`name` as `accesslevel`,`user`.`dob` AS `dob`	,`user`.`email` as `email`,`user`.`contact` as `contact`,`user`.`facebookid` as `facebookid`,`user`.`twitterid` as `twitterid`,`user`.`accesslevel` as `access`
		FROM `user`
	   INNER JOIN `accesslevel` ON `user`.`accesslevel`=`accesslevel`.`id`
       WHERE `user`.`id`='$id'")->row();
		return $query;
	}
	
	public function getnormaluserfacebookpost( $id )
	{
		$query=$this->db->query("SELECT `userpost`.`id`, `userpost`.`user`, `userpost`.`post`, `userpost`.`likes`, `userpost`.`share` ,`post`.`text`,`post`.`posttype`,`post`.`timestamp`,`user`.`name` AS `username`
FROM `userpost` 
LEFT OUTER JOIN `post` ON `post`.`id`=`userpost`.`post`
LEFT OUTER JOIN `user` ON `user`.`id`=`userpost`.`user`
       WHERE `post`.`posttype`=1")->result();;
		return $query;
	}
	
	public function gettotalcompassadors()
	{
		$query=$this->db->query("SELECT count(`id`) AS `totalcompassadore` FROM `user` WHERE `accesslevel`='2'  ")->row();
		return $query->totalcompassadore;
	}
	
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'user' )->row();
		return $query;
	}
	
	public function edit($id,$name,$email,$password,$accesslevel,$contact,$facebookid,$twitterid,$instagramid,$dob,$sex,$college,$city)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
			'accesslevel' => $accesslevel,
            'contact'=> $contact,
            'facebookid'=> $facebookid,
            'twitterid'=> $twitterid,
            'instagramid'=> $instagramid,
            'dob'=> $dob,
            'sex'=> $sex,
            'city'=> $city,
            'college'=> $college
		);
		if($password != "")
			$data['password'] =md5($password);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'user', $data );
        
		return 1;
	}
    
	public function changepassword($id,$password)
	{
		if($password != "")
        {
			$password =md5($password);
		    $this->db->query("UPDATE `user` SET `password`='$password' WHERE `id`='$id'");
            return 1;
        }
        else
        {
		    return 0;
        }
	}
    
	public function getuserimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `user` WHERE `id`='$id'")->row();
		return $query;
	}
	public function getemailbyuserid($id)
	{
		$query=$this->db->query("SELECT `email` FROM `user` WHERE `id`='$id'")->row();
        $email=$query->email;
		return $email;
	}
	function deleteuser($id)
	{
		$query=$this->db->query("DELETE FROM `user` WHERE `id`='$id'");
	}
    
//	function changepassword($id,$password)
//	{
//		$data  = array(
//			'password' =>md5($password),
//		);
//		$this->db->where('id',$id);
//		$query=$this->db->update( 'user', $data );
//		if(!$query)
//			return  0;
//		else
//			return  1;
//	}
    
    public function getuserdropdown()
	{
		$query=$this->db->query("SELECT * FROM `user`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    public function getlistingownerdropdown()
	{
		$query=$this->db->query("SELECT * FROM `user`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function getaccesslevels()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `accesslevel` ORDER BY `id` DESC")->result();
		$accesslevel=$this->session->userdata('accesslevel');
			foreach($query as $row)
			{
				if($accesslevel==1)
				{
					$return[$row->id]=$row->name;
				}
				else if($accesslevel==2)
				{
					if($row->id > $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
				else if($accesslevel==3)
				{
					if($row->id > $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
				else if($accesslevel==4)
				{
					if($row->id == $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
			}
	
		return $return;
	}
    public function getstatusdropdown()
	{
		$query=$this->db->query("SELECT * FROM `statuses`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	function changestatus($id)
	{
		$query=$this->db->query("SELECT `status` FROM `user` WHERE `id`='$id'")->row();
		$status=$query->status;
		if($status==1)
		{
			$status=0;
		}
		else if($status==0)
		{
			$status=1;
		}
		$data  = array(
			'status' =>$status,
		);
		$this->db->where('id',$id);
		$query=$this->db->update( 'user', $data );
		if(!$query)
			return  0;
		else
			return  1;
	}
	function editaddress($id,$address,$city,$pincode)
	{
		$data  = array(
			'address' => $address,
			'city' => $city,
			'pincode' => $pincode,
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'user', $data );
		if($query)
		{
			$this->saveuserlog($id,'User Address Edited');
		}
		return 1;
	}
	
	function saveuserlog($id,$status)
	{
//		$fromuser = $this->session->userdata('id');
		$data2  = array(
			'onuser' => $id,
			'status' => $status
		);
		$query2=$this->db->insert( 'userlog', $data2 );
        $query=$this->db->query("UPDATE `user` SET `status`='$status' WHERE `id`='$user'");
	}
    function signup($email,$password) 
    {
         $password=md5($password);   
        $query=$this->db->query("SELECT `id` FROM `user` WHERE `email`='$email' ");
        if($query->num_rows == 0)
        {
            $this->db->query("INSERT INTO `user` (`id`, `firstname`, `lastname`, `password`, `email`, `website`, `description`, `eventinfo`, `contact`, `address`, `city`, `pincode`, `dob`, `accesslevel`, `timestamp`, `facebookuserid`, `newsletterstatus`, `status`,`logo`,`showwebsite`,`eventsheld`,`topeventlocation`) VALUES (NULL, NULL, NULL, '$password', '$email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, NULL, NULL,NULL, NULL, NULL,NULL);");
            $user=$this->db->insert_id();
            $newdata = array(
                'email'     => $email,
                'password' => $password,
                'logged_in' => true,
                'id'=> $user
            );

            $this->session->set_userdata($newdata);
            
          //  $queryorganizer=$this->db->query("INSERT INTO `organizer`(`name`, `description`, `email`, `info`, `website`, `contact`, `user`) VALUES(NULL,NULL,NULL,NULL,NULL,NULL,'$user')");
            
            
           return $user;
        }
        else
         return false;
        
        
    }
    function login($email,$password) 
    {
        $password=md5($password);
        $query=$this->db->query("SELECT `id` FROM `user` WHERE `email`='$email' AND `password`= '$password'");
        if($query->num_rows > 0)
        {
            $user=$query->row();
            $user=$user->id;
            

            $newdata = array(
                'email'     => $email,
                'password' => $password,
                'logged_in' => true,
                'id'=> $user
            );

            $this->session->set_userdata($newdata);
            //print_r($newdata);
            return $user;
        }
        else
        return false;


    }
    function authenticate() {
        $is_logged_in = $this->session->userdata( 'logged_in' );
        //print_r($is_logged_in);
        if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
            return false;
        } //$is_logged_in !== 'true' || !isset( $is_logged_in )
        else {
            $userid = $this->session->userdata( 'id' );
         return $userid;
        }
    }
    
    function frontendauthenticate($email,$password) 
    {
        $query=$this->db->query("SELECT `id`, `name`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `username`, `socialid`, `logintype`, `json` FROM `user` WHERE `email` LIKE '$email' AND `password`='$password' LIMIT 0,1");
        if ($query->num_rows() > 0)
        {
        	$query=$query->row();
            $data['user']=$query;
            $id=$query->id;
            $status=$query->status;
            if($status==3)
            {
//                $updatequery=$this->db->query("UPDATE `user` SET `status`=4 WHERE `id`='$id'");
                $status=4;
//                if($updatequery)
//                {
                    $this->saveuserlog($id,$status);
//                }
            }
            else if($status==1)
            {
                $status=2;
//                $updatequery=$this->db->query("UPDATE `user` SET `status`=2 WHERE `id`='$id'");
//                if($updatequery)
//                {
                    $this->saveuserlog($id,$status);
//                }
            }
            
        $query2=$this->db->query("SELECT `id`, `name`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `username`, `socialid`, `logintype`, `json` FROM `user` WHERE `id`='$id' LIMIT 0,1")->row();
            
        $newdata        = array(
				'id' => $query2->id,
				'email' => $query2->email,
				'name' => $query2->name ,
				'accesslevel' => $query2->accesslevel ,
				'status' => $query2->status ,
				'logged_in' => 'true',
			);
			$this->session->set_userdata( $newdata );
            
            
            $accesslevel=$query->accesslevel;
            if($accesslevel==2)
            {
            $data['category']=$this->db->query("SELECT `id`,`categoryid`,`operatorid` FROM `operatorcategory` WHERE `operatorid`='$id'")->result();
            }
        	return $data;
        }
        else 
        {
        	return false;
        }
    }
    
    function frontendregister($name,$email,$password,$socialid,$logintype,$json) 
    {
        $data  = array(
			'name' => $name,
			'email' => $email,
			'password' =>md5($password),
			'accesslevel' => 3,
			'status' => 2,
            'socialid'=> $socialid,
            'json'=> $json,
			'logintype' => $logintype
		);
		$query=$this->db->insert( 'user', $data );
		$id=$this->db->insert_id();
        $queryselect=$this->db->query("SELECT * FROM `user` WHERE `id` LIKE '$id' LIMIT 0,1")->row();
        
        $accesslevel=$queryselect->accesslevel;
//        $queryselect=$query;
        $data1['user']=$queryselect;
        if($accesslevel==2)
        {
            $data1['category']=$this->db->query("SELECT `id`,`categoryid`,`operatorid` FROM `operatorcategory` WHERE `operatorid`='$id'")->result();
        }
        return $data1;
    }
    
	function getallinfoofuser($id)
	{
		$user = $this->session->userdata('accesslevel');
		$query="SELECT DISTINCT `user`.`id` as `id`,`user`.`firstname` as `firstname`,`user`.`lastname` as `lastname`,`accesslevel`.`name` as `accesslevel`	,`user`.`email` as `email`,`user`.`contact` as `contact`,`user`.`status` as `status`,`user`.`accesslevel` as `access`
		FROM `user`
	   INNER JOIN `accesslevel` ON `user`.`accesslevel`=`accesslevel`.`id` 
       WHERE `user`.`id`='$id'";
		$query=$this->db->query($query)->row();
		return $query;
	}
    
	public function getlogintypedropdown()
	{
		$query=$this->db->query("SELECT * FROM `logintype`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function frontendlogout($user)
	{
        $query=$this->db->query("SELECT `id`, `name`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `username`, `socialid`, `logintype`, `json` FROM `user` WHERE `id`='$user' LIMIT 0,1")->row();
        $status=$query->status;
        if($status==4)
        {
            $status=3;
//            $updatequery=$this->db->query("UPDATE `user` SET `status`=3 WHERE `id`='$user'");
//            if($updatequery)
//            {
                $this->saveuserlog($id,$status);
//            }
        }
        else if($status==2)
        {
            $status=1;
//            $updatequery=$this->db->query("UPDATE `user` SET `status`=1 WHERE `id`='$user'");
//            if($updatequery)
//            {
                $this->saveuserlog($id,$status);
//            }
        }
//        $updatequery=$this->db->query("UPDATE `user` SET `status`=5 WHERE `id`='$user'");
        
//        if(!$updatequery)
//            return 0;
//        else
//        {
            
		$this->session->sess_destroy();
            return 1;
//        }
	}
    public function assignranks()
    {
        $query=$this->db->query("
SELECT `id`,`name`,`email`,`score`,`facebook`,`twitter`, 
CASE `score`
    WHEN @prev_value THEN @rank_count
    WHEN @prev_value:=score THEN @rank_count := @rank_count + 1
END as `rank` 
FROM (SELECT  `user`.`id`  AS `id` ,  `user`.`name`  AS `name` ,  `user`.`email`  AS `email` ,  IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`+`userpost`.`retweet`+`userpost`.`favourites`),0)  AS `score` ,  IFNULL(SUM(`userpost`.`share`+`userpost`.`likes`+`userpost`.`comment`),0)  AS `facebook` ,  IFNULL(SUM(`userpost`.`retweet`+`userpost`.`favourites`),0)  AS `twitter` ,  `college`.`name`  AS `college`  FROM `user` LEFT OUTER JOIN `userpost` ON `user`.`id`=`userpost`.`user` LEFT OUTER JOIN `college` ON `college`.`id`=`user`.`college`   WHERE `user`.`accesslevel`=2 AND (  1 )  GROUP BY `user`.`id`    ORDER BY  `score` DESC ) as `allusers`,(SELECT @prev_value := NULL,@rank_count := 0) as `r` ")->result();
        foreach($query as $row)
        {
            $this->db->query("UPDATE `user` SET `rank`='$row->rank' WHERE `id`='$row->id'");
        }
        
    }
    
    
	public function createuserbycsv($file)
	{
//        print_r($file);
        foreach ($file as $row)
        {
        $college=$row['college'];
        $collegequery=$this->db->query("SELECT * FROM `college` where `name` LIKE '$college'")->row();
        if(empty($collegequery))
        {
            $this->db->query("INSERT INTO `college`(`name`) VALUES ('$college')");
            $collegeid=$this->db->insert_id();
        }
        else
        {
            $collegeid=$collegequery->id;
        }
         
            $name=$row['name'];
            $password=md5($row['password']);
            $data  = array(
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => $password,
                'contact' => $row['contact'],
                'college' => $collegeid,
                'accesslevel' => 2,
                'status' => 2
            );

            $query=$this->db->insert( 'user', $data );
        }
		if(!$query)
			return  0;
		else
			return  1;
	}
}
?>