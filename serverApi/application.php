<?php

    $servername = "192.168.1.80";
    $username = "root";
    $password = "pass";
    $dbname = "nodered";
    //$dbname = "test";

    //Create connection
    $GLOBALS['conn'] = mysqli_connect($servername, $username, $password,$dbname);
    //$conn = mysqli_connect($servername, $username, $password, $dbname);

    //Check connection
    if (!$conn) {
        echo "Not Connected";
        die("Connection failed: " . mysqli_connect_error());
    }else{
        //echo "Database Connected";
    }

    /*User Login*/
    function login($data, $conn){
        $validate = json_decode($data);
        
        $query = "SELECT *FROM chatappusers WHERE email='$validate->email' And password='$validate->password'";
        $result = mysqli_query($conn, $query);
        $jsondata = array();
        if(mysqli_num_rows($result) == 1){
            $queryData = "SELECT *FROM chatappusers WHERE email='$validate->email'";
            $getData = mysqli_query($conn, $queryData);
            $row = mysqli_fetch_object($getData);
            $jsondata = $row;
            echo json_encode(array("msg"=>"Logged in successfully", "success"=>true, "userData"=>$jsondata));
            
        }else{
			echo json_encode(array("msg"=>"User does not exists", "success"=>false));
		}  
    }

    /*Save Users*/
    function saveUsers($data, $conn){
        
        $user = json_decode($data);
        
        //echo json_encode($user->firstName);
        
        //$query = "INSERT INTO `chatappusers`(`id`, `firstName`, `lastName`, `email`, `password`, `mobile`, `profession`, `registeredDate`, `uniqueId`) VALUES (Null, '".$user->firstName."', '".$user->lastName."', '".$user->email."', '".$user->password."', '"$user->mobile"', '".$user->profession."','".$user->registeredDate."', '".$user->userId."')";
        
       $query= "INSERT INTO chatappusers (firstName, lastName, email, password, mobile, profession, registeredDate, uniqueId) VALUES ('".$user->firstName."', '".$user->lastName."', '".$user->email."', '".$user->password."', '".$user->mobile."', '".$user->profession."', '".$user->registeredDate."', '".$user->userId."')";
       
        //$query= "INSERT INTO chatappusers (firstName, lastName, email, password, mobile, profession, registeredDate, uniqueId) VALUES ('Assalamu', 'Alaikum', 'assalamu@gmail.com', 'bismi', '9020000154', 'Tester', '1535720472956', 'tuylbu')";
        
        //INSERT INTO chatappusers (firstName, lastName, email, password, mobile, profession, registeredDate, uniqueId)
        
        /*$sqlQuery = "INSERT INTO `task`(`project_id`,`task_name`,`assigned_by`,`task_assign_date`,`assigned_to`,`priority`,`status`,`rating`) 
        VALUES (".$task->project_id.",'".$task->task."',".$task->assigned_by.",'".$task->task_assign_date."',".$task->assigned_to.",'".$task->priority."','".$task->status."',".$task->rating.")";*/
        
        if(mysqli_query($conn, $query)){
			echo json_encode(array("success"=>true, "msg"=>"User saved successfully"));
		}  
    }

    function getUserList($conn){
        $query = "SELECT * FROM `chatappusers`";
        $result = mysqli_query($conn, $query);
        
        $jsondata=array();
        if (mysqli_num_rows($result) > 0) 
		  {
            while($row = mysqli_fetch_assoc($result)) 
                {
					$jsondata[]=$row;
				}
		  }
		  else
		  {
				$jsondata =array();
		  }
        echo json_encode(array("msg"=>"Success","success"=>true,"userList"=>$jsondata));
    }

	function saveTasksheet($data,$connection){
		
		$task=json_decode($data);
		$query="SELECT * FROM user WHERE email='$task->email'";
		$result=mysqli_query($connection,$query);
		$obj=mysqli_fetch_object($result);
		
		$ts=time();
		$sqlQuery = "INSERT INTO `tasksheet`(`user_id`,`project_id`,`start_time`,`end_time`,`created_at`,`activity`) VALUES (".$obj->id.",".$task->project_id.",".$task->start_time.",".$task->end_time.",$ts,'".$task->activity_id."')";

		if(mysqli_query($connection,$sqlQuery)){
			echo json_encode(array("success"=>true,"msg"=>"Task Sheet saved successfully"));
		}
	}
	
	function updateTasksheet($data,$connection){
		$task=json_decode($data);
		$query="SELECT * FROM user WHERE email='$task->email'";
		$result=mysqli_query($connection,$query);
		$obj=mysqli_fetch_object($result);
		$ts=time(); 
		$sqlQuery="update tasksheet set activity='$task->activity_id',project_id='$task->project_id',start_time='$task->start_time',end_time='$task->end_time' where id='$task->task_id'";
		
		if(mysqli_query($connection,$sqlQuery)){
			echo json_encode(array("success"=>true,"msg"=>"Task Sheet updated Successfully"));
		}
	}
	
	function getProjects($data,$connection){
		$q=json_decode($data);
		$query="SELECT id as project_id,project_name from project where project_name like '%$q->query%'";
		$projectList=getJsonData($query,$connection);
		echo json_encode(array("msg"=>"success","projectList"=>$projectList,"success"=>true));
	}
	
	function getActivity($data,$connection){
		$q=json_decode($data);
		$query="SELECT id as activity_id,activity from activitiy_list where activity like '%$q->query%'";
		$activityList=getJsonData($query,$connection);
		echo json_encode(array("msg"=>"success","activityList"=>$activityList,"success"=>true));
	}

?>
