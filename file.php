<?php
include $_SERVER["DOCUMENT_ROOT"] . "/php/sessionStart.php";
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>333 Morewood Apt 5</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="/css/file.css">
    <script src="js/file.js"></script>
</head>

<body>
<div id="file-ls">
	<?php
	    $_SESSION["currentPage"] = "FILE";
        include $_SERVER["DOCUMENT_ROOT"] . "/screenComponents/header.php"
	?>

	<table class="sortable">
	    <thead>
		<tr>
			<th>Filename</th>
            <th>Uploader</th>
			<th>Type</th>
			<th>Size</th>
			<th>Date Modified</th>
            <th></th>
		</tr>
	    </thead>
	    <tbody>
        <?php
    $uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";
	// Return file size as a string
	function pretty_filesize($file) {
		$size=filesize($file);
		if($size<1024){$size = $size . " Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
	}

	// Opens directory
    $myDirectory=opendir($uploadDir);

	// Gets each entry
	while($entryName=readdir($myDirectory)) {
	   $dirArray[]=$entryName;
	}

	// Closes directory
	closedir($myDirectory);

	// Counts elements in array
	$indexCount=count($dirArray);

	// Loops through the array of files
	for($index=0; $index < $indexCount; $index++) {

	    // Resets Variables
		$favicon="";
		$class="file";

	    // Gets File Display Names
		$name= $dirArray[$index];
		$namehref=$dirArray[$index];

	    // Gets Date Modified
		$modtime=date("M j Y g:i A", filemtime($_SERVER["DOCUMENT_ROOT"]. "/uploads/" . $dirArray[$index]));
		$timekey=date("YmdHis", filemtime($_SERVER["DOCUMENT_ROOT"]. "/uploads/" .$dirArray[$index]));


	    // Separates directories, and performs operations on those directories
		if(is_dir($uploadDir.$dirArray[$index])) {
            $extn="&lt;Directory&gt;";
            $size="&lt;Directory&gt;";
            $sizekey="0";
            $class="dir";

			// Gets favicon.ico, and displays it, only if it exists.
            if(file_exists("$namehref/favicon.ico"))
            {
                $favicon=" style='background-image:url($namehref/favicon.ico);'";
                $extn="&lt;Website&gt;";
            }

			// Cleans up . and .. directories
            if($name==".") continue;
            if($name=="..") continue;
		} else { // File-only operations
			// Gets file extension
			$extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);

			// Prettifies file type
			switch ($extn){
				case "png": $extn="PNG Image"; break;
				case "jpg": $extn="JPEG Image"; break;
				case "jpeg": $extn="JPEG Image"; break;
				case "svg": $extn="SVG Image"; break;
				case "gif": $extn="GIF Image"; break;
				case "ico": $extn="Windows Icon"; break;

				case "txt": $extn="Text File"; break;
				case "log": $extn="Log File"; break;
				case "htm": $extn="HTML File"; break;
				case "html": $extn="HTML File"; break;
				case "xhtml": $extn="HTML File"; break;
				case "shtml": $extn="HTML File"; break;
				case "php": $extn="PHP Script"; break;
				case "js": $extn="Javascript File"; break;
				case "css": $extn="Stylesheet"; break;

				case "pdf": $extn="PDF Document"; break;
				case "xls": $extn="Spreadsheet"; break;
				case "xlsx": $extn="Spreadsheet"; break;
				case "doc": $extn="Microsoft Word Document"; break;
				case "docx": $extn="Microsoft Word Document"; break;

				case "zip": $extn="ZIP Archive"; break;
				case "htaccess": $extn="Apache Config File"; break;
				case "exe": $extn="Windows Executable"; break;

				default: if($extn!=""){$extn=strtoupper($extn)." File";} else{$extn="Unknown";} break;
			}

			// Gets and cleans up file size
            $size=pretty_filesize($uploadDir.$dirArray[$index]);
            $sizekey=filesize($uploadDir.$dirArray[$index]);
		}
		// Retrieve Uploader
        // db parameters
        $db_server="morewood.life";
        $db_user="root";
        $db_password="qweasdzxc";
        $dbname = "morewoodapt";
        //$dbname = "morewoodapt_test";
        $conn = new mysqli($db_server, $db_user, $db_password, $dbname);
        if($conn->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $conn->query("SET NAMES utf8;");
        // prepare and bind
        $stmt = $conn->prepare("SELECT firstname FROM files, users WHERE files.userid = users.userid AND filename = ?");
        $stmt->bind_param("s", $name);
        /* execute query */
        $stmt->execute();

        /* bind result variables */
        $stmt->bind_result($username);

        /* fetch value */
        $stmt->fetch();

        /* close statement */
        $stmt->close();

        $conn->close();
	    // Output
        if($username == "") $username = "Unknown";
        echo <<<HTML
		    <tr class='$class'>
                <td><a href='./$namehref'$favicon class='name' download>$name</a></td>
                <td><a href='./$namehref'>$username</td>
                <td><a href='./$namehref'>$extn</a></td>
                <td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
                <td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
                <td>
HTML;
        if(!empty($_SESSION["username"])) {
            if (($_SESSION["username"] == $username) ||
                $username == "Unknown") {
                echo <<<HTML
            <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"
                        style='color: red;' onclick='DeleteFile(this);'
            ></span>

HTML;
            }
        }
    echo <<<HTML
            </td>
		</tr>
HTML;
	}
	?>
	    </tbody>
	</table>
</div>

<?php
if(!empty($_SESSION["username"])){
	echo <<<HTML
	    <div id="file-container">
		    <div id="upload-progress"></div>
		    <div id="file-panel">
				<label id="file-upload-label" for="file-upload-input">Choose File</label>
				<input type="file" name="fileToUpload" id="file-upload-input" onchange="handleFiles(this.files)"/>
				<button type="button" id="file-upload-btn" class="btn-disable">Upload</button>
			</div>
		</div>
HTML;
}
?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/upload.js"></script>
</body>
</html>
