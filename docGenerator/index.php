<?php
	if(isset($_GET)){
		$fType = '';
		$sDir = '';
		$dDir = '';
		$uName = '';
		$pswd = '';
		if(isset($_GET['fileType']))
			$fType = $_GET['fileType'];
		if(isset($_GET['sourceDirPath']))
			$sDir = $_GET['sourceDirPath'];
		if(isset($_GET['destDirPath']))
			$dDir = $_GET['destDirPath'];
		if(isset($_GET['userName']))
			$uName = $_GET['userName'];
		if(isset($_GET['password']))
			$pswd = $_GET['password'];
		if($fType){
			$smountName	=	"/media/source/".rand(0, 100).$uName.rand(0, 100)."/";
			$dmountName	=	"/media/dest/".rand(101, 200).$uName.rand(101, 200)."/";
			$createSourceMountingQuery	=	"sudo mount -t cifs ".$sDir." ".$smountName." -o username=".$uName.",password=".$pswd;
			$createDestMountingQuery	=	"sudo mount -t cifs ".$dDir." ".$dmountName." -o username=".$uName.",password=".$pswd;
			$openJsDocDirQuery	=	"cd /jsdoc-master";
			$createJSDocQuery  = "sudo jsdoc ".$smountName." -d ".$dmountName;
			$createphpDocQuery = "sudo apigen generate -s ".$smountName." -d ".$dmountName;
			
			
			$createSMount	=	shell_exec($createSourceMountingQuery);
			if($createSMount){
				$createDMount	=	shell_exec($createDestMountingQuery);
				if($createDMount){
					if($fType == "60" || $fType == "70"){
						$openJsDoc = shell_exec($openJsDocDirQuery);
						if($openJsDoc){
							$runJSDoc	=	shell_exec($createJSDocQuery);
							if($runJSDoc){
								$output = true;
							}
							else{
								$output = false;
							}
						}
					}
					if($fType == "50" || $fType == "70"){
						$runphpDoc	=	shell_exec($createphpDocQuery);
						if($runphpDoc){
							$output = true;
						}
						else{
							$output = false;
						}
					}
				}
			}
			echo $output;
		}
	}
?>
<html>
	<head>
	</head>
	<body>
		<h3>Venera Document Generator (WEB)</h3>
		<form method="get" action="./index.php">
			<table>
				<tr>
					<td>
						Select filetype
					</td>
					<td>
						<div>
							<label for="phpFileType">php</label><input type="radio" id="phpFileType" name="fileType" value="50">
							<label for="jsFileType">JS</label><input type="radio" id="jsFileType" name="fileType" value="60">
							<label for="bothFileType">Both</label><input type="radio" id="bothFileType" name="fileType" value="70">
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label for="sourceDirPath">
						Enter Source Directory
						</label>
						<input type="text" id="sourceDirPath" name="sourceDirPath" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label for="destDirPath">
						Enter Ouput Directory
						</label>
						<input type="text" id="destDirPath" name="destDirPath" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label for="userName">
						Username for source machine
						</label>
						<input type="text" id="userName" name="userName" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label for="password">
						Password for source machine
						</label>
						<input type="password" id="password" name="password" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" value="Submit" />
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>