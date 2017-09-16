<?php session_start()?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>333 Morewood Apt 5</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

   <link rel="stylesheet" href=".style.css">
   <script src=".sorttable.js"></script>
</head>

<body>
<div id="container">
	<?php
	    $_SESSION["currentPage"] = "FILE";
		include "../header.php"
	?>
	<h1>Data Center</h1>

	<table class="sortable">
	    <thead>
		<tr>
			<th>Filename</th>
			<th>Type</th>
			<th>Size</th>
			<th>Date Modified</th>
		</tr>
	    </thead>
	    <tbody><?php

	// Adds pretty filesizes
	function pretty_filesize($file) {
		$size=filesize($file);
		if($size<1024){$size = $size . " Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
	}

 	// Checks to see if veiwing hidden files is enabled
	if($_SERVER['QUERY_STRING']=="hidden")
	{$hide="";
	 $ahref="./.index.php";
	 $atext="Hide";}
	else
	{$hide=".";
	 $ahref="./.index.php?hidden";
	 $atext="Show";}

	 // Opens directory
	 $myDirectory=opendir(".");

	// Gets each entry
	while($entryName=readdir($myDirectory)) {
	   $dirArray[]=$entryName;
	}

	// Closes directory
	closedir($myDirectory);

	// Counts elements in array
	$indexCount=count($dirArray);

	// Sorts files
	sort($dirArray);

	// Loops through the array of files
	for($index=0; $index < $indexCount; $index++) {

	// Decides if hidden files should be displayed, based on query above.
	    if(substr("$dirArray[$index]", 0, 1)!=$hide) {

	// Resets Variables
		$favicon="";
		$class="file";

	// Gets File Names
		$name=$dirArray[$index];
		$namehref=$dirArray[$index];

	// Gets Date Modified
		$modtime=date("M j Y g:i A", filemtime($dirArray[$index]));
		$timekey=date("YmdHis", filemtime($dirArray[$index]));


	// Separates directories, and performs operations on those directories
		if(is_dir($dirArray[$index]))
		{
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
				if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($namehref/.favicon.ico);'";}
				if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;";}
		}

	// File-only operations
		else{
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
				$size=pretty_filesize($dirArray[$index]);
				$sizekey=filesize($dirArray[$index]);
		}

	// Output
	 echo("
		<tr class='$class'>
			<td><a href='./$namehref'$favicon class='name' download>$name</a></td>
			<td><a href='./$namehref'>$extn</a></td>
			<td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
			<td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
		</tr>");
	   }
	}
	?>

	    </tbody>
	</table>
    <h2><?php echo("<a href='$ahref'>$atext hidden files</a>"); ?></h2>



</div>

<?php
if(!empty($_SESSION["username"])){
    echo <<<HTML
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="button" value="Upload Image" id="upload-btn" name="submit">
HTML;
}
?>

<div class="progress" id = "bar-box" style="display:none">
    <div id = "progress-bar"
         class="progress-bar progress-bar-info progress-bar-striped"
         role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
         style="width: 0%">
        <span class="sr-only">20% Complete</span>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../js/upload.js"></script>
</body>
</html>
