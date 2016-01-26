<?php

// application.php
$idprescricao=$_GET['idprescricao'];

require_once('./dbinfo.inc.php');

//session_start();	

// Generate the application page

$c = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
// Set the client identifier after every connection call
// using a value unique for the web end user.
oci_set_client_identifier($c, ORA_CON_UN);

$username = htmlentities(ORA_CON_UN, ENT_QUOTES);
echo <<<EOD
<link rel="stylesheet" type="text/css" href="style_tab.css" />
<table class="features-table" >
EOD;

$s = oci_parse($c, "select null , coluna1, coluna2 from pc_plano_terapeutico where ordem=1 AND ID_PRESCRICAO='".$idprescricao."' AND ROWNUM<2 order by ordem");
oci_execute($s);
while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS))
        != false) {
  echo "<thead> <tr>\n";
  foreach ($row as $item) {
    echo "  <td>" .
      ($item!==null?htmlentities($item, ENT_QUOTES):"&nbsp;") .
      "</td>\n";
  }
  echo "</tr>\n <thead>";
}


$s = oci_parse($c, "select rubrica , coluna1, coluna2 from pc_plano_terapeutico where ordem>1 AND ID_PRESCRICAO='".$idprescricao."' order by ordem");
oci_execute($s);
while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS))
        != false) {
  echo "<tbody> <tr>\n";
  foreach ($row as $item) {
    echo "  <td>" .
      ($item!==null?htmlentities($item, ENT_QUOTES):"&nbsp;") .
      "</td>\n";
  }
  echo "</tr>\n <tbody>";
}



echo <<<EOD
</table>
EOD;

?>
