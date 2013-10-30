<?php
	/**
	* SQL Backup
	*
	* @return string $fileName
	*/
	public static function db_backup()
	{
		
		$DBType = Config::get('database.default');
		$connections = Config::get('database.connections');

		switch($DBType) {
			
			case 'sqlite':
				
				$fileName = $connections[$DBType]['database'] . '.' . $connections[$DBType]['driver'];
			
			break;
			
			case 'mysql':
				
				$link = mysql_connect($connections[$DBType]['host'],$connections[$DBType]['username'],$connections[$DBType]['password']);
				mysql_select_db($connections[$DBType]['database'],$link);
				
				$tables = array();
				$result = mysql_query('SHOW TABLES');

				while($row = mysql_fetch_row($result)){
					$tables[] = $row[0];
				}
				
				//Set time now
				$now = date('Y-m-d-H-i-s');
				
				//File header
				$return ="### DB BACKUP: " . $connections[$DBType]['database'] . " at " . $now . " ###\n\n\n";
				
				//cycle through
				foreach($tables as $table) {

					$result = mysql_query('SELECT * FROM '.$table);
					$numFields = mysql_numFields($result);
					
					$return.= 'DROP TABLE IF EXISTS '.$table.';';
					$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
					$return.= "\n\n".$row2[1].";\n\n";
					
					for ($i = 0; $i < $numFields; $i++) {

						while($row = mysql_fetch_row($result)) {

							$return.= 'INSERT INTO '.$table.' VALUES(';
							for($j=0; $j<$numFields; $j++) {

								$row[$j] = addslashes($row[$j]);
								$row[$j] = preg_replace("#\n#i","\\n",$row[$j]);

								if (isset($row[$j])) {
									$return.= '"'.$row[$j].'"' ;
								} else {
									$return.= '""'; 
								}

								if ($j < ($numFields-1)) {
									$return.= ',';
								}

							}
							$return.= ");\n";
						}
					}

					$return.="\n\n\n";

				}
				
				//save file
				$fileName = 'db-backup-'.$now.'.sql';
				
				$handle = fopen(path('storage') . 'database/' . $fileName, 'w+');
				fwrite($handle, utf8_encode($return));
				fclose($handle);
		}

		return $fileName;

	}
