
<?php
	//include connection file 
	include_once("connection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$userCls = new User($connString);

	switch($action) {
	 case 'add':
		$userCls->insertUser($params);
	 break;
	 case 'edit':
		$userCls->updateUser($params);
	 break;
	 case 'delete':
		$userCls->deleteUser($params);
	 break;
	 default:
	 $userCls->getUsers($params);
	 return;
	}
	
	class user {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getUsers($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertuser($params) {
		$data = array();;
		$sql = "INSERT INTO `users` (username, phone, email) VALUES('" . $params["username"] . "', '" . $params["phone"] . "','" . $params["email"] . "');  ";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert users data");
		
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {   
			$where .=" WHERE ";
			$where .=" ( User_name LIKE '".$params['searchPhrase']."%' ";    
			$where .=" OR User_salary LIKE '".$params['searchPhrase']."%' ";

			$where .=" OR User_age LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT * FROM `users` ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot Users data");
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch Users data");
		
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			$data[] = $row;
		}

		$json_data = array(
			"current"            => intval($params['current']), 
			"rowCount"            => 10, 			
			"total"    => intval($qtot->num_rows),
			"rows"            => $data   // total data array
			);
		
		return $json_data;
	}
	function updateUser($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "Update `users` set username = '" . $params["edit_username"] . "', User_phone='" . $params["edit_phone"]."', User_phone='" . $params["edit_email"] . "' WHERE id='".$_POST["edit_id"]."'";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update User data");
	}
	
	function deleteUser($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "delete from `User` WHERE id='".$params["id"]."'";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete User data");
	}
}
?>
	