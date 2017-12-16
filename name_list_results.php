<html>
   <meta charset="UTF-8"> 
<body>
<head>

<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="cxc.css" type="text/css" media="all">

</head>

<?php

$n=trim(htmlspecialchars($_GET["n"]));

include "testata.php";

//print "<br>";


function SqliteNumRows($ris){
    $numRows = 0;
    while($row = $ris->fetchArray()){
        ++$numRows;
    }
    return $numRows;
}

$db = new SQLite3('catasto.db');
//$db->loadExtension('mod_spatialite.so');




$query="
  select 
DISTINCT tit.idSoggetto as idSog,
tit.titoloNonCod as titplus,


CASE
WHEN tit.tipoSoggetto='P'
THEN per.cognome||' '||per.nome
WHEN tit.tipoSoggetto='G'
THEN giu.denominazione
END as denomin,

CC.decodifica as lnasc,

substr('per'.'dataNascita',9,2)||'/'||substr('per'.'dataNascita',6,2)||'/'||substr('per'.'dataNascita',1,4) as dnasc,

CASE
WHEN tit.tipoSoggetto='P'
THEN trim(per.codFiscale)
WHEN tit.tipoSoggetto='G'
THEN trim(giu.codFiscale)
END as codice_fiscale

From titolarita as tit

left join persona_fisica as per On tit.idSoggetto = per.idSoggetto
left join persona_giuridica as giu On tit.idSoggetto = giu.idSoggetto
left join COD_COMUNE as CC On per.luogoNascita = CC.codice
where denomin like '%" . $n . "%' 

GROUP BY idSog

ORDER BY denomin ASC, substr('per'.'dataNascita',1,4) DESC, idSog ASC ";


## imposto il limite di tempo, in secondi, per eseguire la query . Di default è 30 s

set_time_limit(360);


//$risultato = $db->query($query);
$risultato = $db->query($query);

$totRows=SqliteNumRows($risultato);

if ($totRows>0)
{


                echo "<hr>";
                print "<h3>ricerca per</h3><p>" . $n . "</p>";
                // se il risultato e' maggiore di 1
                if ($totRows>1)
                                {
                                print "<p>restituiti " . $totRows . " risultati</p>";
                                }
                echo "<hr>";


                print "<form id=\"ListaIdForm\" method=\"POST\" action=\"nctr_soggetto_multi_diviso.php\">";
                print "<div id=\"checkboxlist\">";

                print "<table>";

                print "<tr ><th></th><th></th><th style='text-align:left';>denominazione</th><th style='text-align:left';>luogo di<br>nascita</th><th style='text-align:left';>data di<br>nascita</th><th>codice<br>fiscale</th></tr>";

                while ($table = $risultato->fetchArray(SQLITE3_ASSOC)) 
                {

                    $idSog= $table['idSog'];
                    $denomin=$table['denomin'] ." " . $table['titplus']. " " .$table['lnasc']. " " .$table['dnasc']." ".$table['codice_fiscale'];
                    print "<tr>";

                    print "<td><div><input type=\"checkbox\" value=\"" . $idSog . "," . $denomin . "\" class=\"chk\"></div></td>\n";

                    print "<td>" . "<p><a href=\"nctr_soggetto.php?idSog=$idSog&n=$denomin\" target=\"_self\">".$idSog."</a></p>" . "</td>";
                    print "<td style='text-align:left';>" . $table['denomin'] . "</td>"; 
                    print "<td style='text-align:left';>" . $table['lnasc'] . "</td>"; 
                    print "<td style='text-align:left';>" . $table['dnasc'] . "</td>"; 
                    print "<td>" . $table['codice_fiscale'] . "</td>";
                     
                    print "</tr>";
                }  



print "</table>"; 

print "</div>";
print '<input type="hidden" id="idSogList" name="idSogList" value="" />';
#print '<input type="hidden" id="nSogList" name="nSogList" value="" />';
print "<br>";
print '<input type="button" value="Cerca i selezionati dettaglio diviso" id="buttonClassDiviso"> ';
print '<input type="button" value="Cerca i selezionati dettaglio unito" id="buttonClassUnito"> ';
print ' </div>';



print "</form>";
?>

<script type="text/javascript">

/* if the page has been fully loaded we add two click handlers to the button */
$(document).ready(function () {
  /* Get the checkboxes values based on the class attached to each check box */
  $("#buttonClassDiviso").click(function() {
      document.getElementById("ListaIdForm").action="nctr_soggetto_multi_diviso.php";
      getValueUsingClass();
  });
  
  $("#buttonClassUnito").click(function() {
      document.getElementById("ListaIdForm").action="nctr_soggetto_multi_unito.php";
      getValueUsingClass();
  });
  

  /* Get the checkboxes values based on the parent div id */
  $("#buttonParent").click(function() {
      getValueUsingParentTag();
  });
});

function getValueUsingClass(){
  /* declare an checkbox array */
  var chkArray = [];
  
  /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
  $(".chk:checked").each(function() {
    chkArray.push($(this).val());
    //document.getElementById('idSogList').push($(this).val());
  });
  
  /* we join the array separated by the comma */
  var selected;
  selected = chkArray.join(',') + ",";
  document.getElementById('idSogList').value = selected; 
  

  /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
  if(selected.length > 1){
    // se ci sono selezionati fa' il submit del form
    document.getElementById("ListaIdForm").submit(); 

  }else{
    alert("Selezionate almeno una riga tramite il checkbox");
   return false;
  }
}

function getValueUsingParentTag(){
  var chkArray = [];
  
  /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
  $("#checkboxlist input:checked").each(function() {
    chkArray.push($(this).val());
  });
  
  /* we join the array separated by the comma */
  var selected;
  selected = chkArray.join(',') + ",";
  
  /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
  if(selected.length > 1){
    alert("Hai selezionato " + selected); 
  }else{
    alert("Please at least one of the checkbox"); 
  }
}
</script>

<?php
}ELSE {
?>



<!-- se il risultato della ricerca non è > 0 esegue lo java script... e riporta alla pagina di ricerca -->


<script type="text/javascript">


  function doRedirect() {
    //Genera il link alla pagina che si desidera raggiungere
    location.href = "cerca_nominativo.php"
  }
  
  //Questo è il messaggio di attesa di redirect in corso…
  document.write("Nessun risultato... sarai riportato alla maschera di ricerca");
  
  //Fa partire il redirect dopo 10 secondi da quando l'intermprete JavaScript ha rilevato la funzione
  window.setTimeout("doRedirect()", 3000);

</script>


<!-- FINE java -->

<?php
}
echo "<br>";
?>



</body>
</html>