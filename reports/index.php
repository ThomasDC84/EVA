<!DOCTYPE html>
<html>
<head>
<title>Visualizzatore rapporti di sistema</title>
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('report[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
</head>
<?php
$report = 'Nessun report selezionato per la visualizzazione';
$reportFileName = 'NONAME00';
function listReports() {
	$files = array();
	$dir = ".";
	$dh  = opendir($dir);
	while (false !== ($file = readdir($dh))) {
		if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'log') {
			$files[] = $file;
		}
	}
	return $files;
}


define('__EVA_HOME__', $_SERVER['DOCUMENT_ROOT'] . '/eva');

include $_SERVER['DOCUMENT_ROOT'] . '/eva/functions/default.php';

//read Log if any
if(isset($_GET['readLog'])) {
	if(file_exists($_GET['readLog'])) {
		$reportFileName = $_GET['readLog'];
		$report = file_get_contents($_GET['readLog']);
	}
}

//delete logs if any
if(isset($_POST['report'])) {
	if(!is_array($_POST['report'])) {
		if(file_exists($_POST['report'])) {
			unlink($_POST['report']);
		}
	}
	else {
		foreach($_POST['report'] as $report) {
			if(file_exists($report)) {
				unlink($report);
			}
		}
	}
}
	

//read logs
$files = listReports();

?>
<body>
    <div id="wrapper">
        <div id="headerwrap">
        <div id="header">
            <p><a href="index.php">Visualizzatore rapporti di sistema</a></p>
        </div>
        </div>
        <div id="contentwrap">
        <div id="content">
				<h1>Visualizzazione Rapporto<?php if($reportFileName != 'NONAME00') echo ' - ' . $reportFileName; ?></h1><br/>
				<pre><?php echo $report ?></pre>
        </div>
        </div>
        <div id="leftcolumnwrap">
        <div id="leftcolumn">
				<br/>
            <form method='post' action='index.php?action=deletePosts'>
					<fieldset>
						<legend style="text-align: center;">Elenco Rapporti:</legend><br/>
							<?php
								foreach($files as $log) {
									echo '<input type="checkbox" name="report[]" id="' . $log . '" value="' . $log . '" />';
									echo '<label for="' . $log . '">' . $log . '</label> | <a href="index.php?readLog=' . $log . '" />Visualizza</a><br/>';
								}
							?>
							<br/>
							<input type="checkbox" id="selectAll" onClick="toggle(this)" /><label for="selectAll">Seleziona Tutti</label><br/>
							<p style="text-align: center;">
								<input type="submit" value="Cancella Selezionati" />
								<input type="reset" value="Annulla Selezione">
							</p>
					</fieldset>
				</form>
				</p>
        </div>
        </div>
        <div id="footerwrap">
        <div id="footer">
            <p>EVA</p>
        </div>
        </div>
    </div>
</body>
</html>