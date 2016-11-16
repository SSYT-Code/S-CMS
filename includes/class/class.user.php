<?php
	class USER {
		public function is_loggedin()
		{
			if(isset($_SESSION['user_session']))
			{
				return true;
			}
		}
		
		public function logout()
		{
			session_destroy();
			unset($_SESSION['user_session']);
			$db = SCMSDB();
				$db->query('UPDATE accounts SET logged = 0 WHERE id = '. $_SESSION['user_session'] .'');
			$db = null;
			return true;
		}
   
		public function userLogin($usernameEmail, $password)
		{
			try {
				$db = SCMSDB();
				$hash_password= hash('sha256', $password);
				$stmt = $db->prepare("SELECT id FROM accounts WHERE (username=:usernameEmail or email=:usernameEmail) AND password=:hash_password"); 
				$stmt->bindParam("usernameEmail", $usernameEmail, PDO::PARAM_STR);
				$stmt->bindParam("hash_password", $hash_password, PDO::PARAM_STR);
				$stmt->execute();
				$count = $stmt->rowCount();
				$data = $stmt->fetch(PDO::FETCH_OBJ);
				$db = null;
				
				if($count > 0)
				{
					$_SESSION['user_session'] = $data->id;
					$db = SCMSDB();
					$user_update = $db->query('UPDATE accounts SET logged = 1, lastlogin = CURRENT_TIMESTAMP WHERE id = '. $data->id .'');
					$db = null;
					return true;
				}
				else {
					return false;
				}
			}
			catch(PDOException $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}
		}
		
		public function userLogout()
		{
			try {
				$db = SCMSDB();
					$user_update = $db->prepare('UPDATE accounts SET logged = :loggedvalue, lastlogin=:time WHERE id = '. $_SESSION['user_session'] .'');
					$user_update->bindParam(":loggedvalue", 0, PDO::PARAM_STR);
					$user_update->bindParam(":time", CURRENT_TIMESTAMP, PDO::PARAM_STR);
					$user_update->execute();
				$db = null;
			}
			catch(PDOException $e) {
				echo '{"error" : {"text" : '. $e->getMessage() .'}}';
			}
		}
		
		public function userRegistration($username, $password, $email, $name)
		{
			try {
				$db = SCMSDB();
				$st = $db->prepare("SELECT uid FROM users WHERE username=:username OR email=:email"); 
				$st->bindParam("email", $email,PDO::PARAM_STR);
				$st->execute();
				$count = $st->rowCount();
				if($count < 1)
				{
					$stmt = $db->prepare("INSERT INTO users(username,password,email,name) VALUES (:username,:hash_password,:email,:name)");
					$stmt->bindParam("username", $username,PDO::PARAM_STR) ;
					$hash_password= hash('sha256', $password);
					$stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
					$stmt->bindParam("email", $email,PDO::PARAM_STR) ;
					$stmt->bindParam("name", $name,PDO::PARAM_STR) ;
					$stmt->execute();
					$uid = $db->lastInsertId();
					$db = null;
					$_SESSION['uid'] = $uid;
					return true;
				}
				else
				{
					$db = null;
					return false;
				}
			}
			catch(PDOException $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}'; 
			}
		}
	}
?>