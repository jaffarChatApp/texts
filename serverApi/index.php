<?php
	header("Access-Control-Allow-Origin: *");
	include("application.php");
	//include("tasksheet.php");
	//include("user.php");
	//include("admin.php");
	//session_start();
	
	$function= $_REQUEST['function'];
	//$data= $_REQUEST["data"];
	
	switch ($function){
        case "logIn":
			logIn($_REQUEST["data"],$conn);
			break;
		case "getUserList":
			//getUserList($_REQUEST["data"],$conn);
			getUserList($conn);
			break;
		case "saveUsers":
			saveUsers($_REQUEST["data"], $conn);
			break;
        case "saveAssignTask":
            saveAssignTask($_REQUEST["data"],$conn);
            break;
        case "getAssignedTask":
            getAssignedTask($_REQUEST["data"],$conn);
            break;
        case "saveRating":
            saveRating($_REQUEST["data"],$conn);
            break;
        case "updateTaskStatus":
            updateTaskStatus($_REQUEST["data"],$conn);
            break;
		default: 
			echo json_encode(array("msg"=>"No such function exist","success"=>false));
	}
	
?>
