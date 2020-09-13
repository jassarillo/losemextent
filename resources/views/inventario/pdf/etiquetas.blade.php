<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Etiquetas</title>
</head>
<body>
    
    <br>
    <?php //echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33,"green", true);?>

   <br>
<?php 
$i =1 ;
$anio = date("Y");
?>
 <table border="0" cellspacing=0 style="font-size: 10px; padding: -20px;">
    <?php echo "<tr>";?>
    @foreach($resguardosEtiquetas as $etiquetas)
        <?php 
            echo "<td style='text-align: center; width: 250px; height:87 px;' >";
       
         ?>
        <table> 
            <tr>
                <td>
                    &nbsp;
                </td>
                <td>
                    <?php
                        echo DNS1D::getBarcodeHTML($etiquetas['progresivo'], "C39",1.5,28); 
                        echo $etiquetas['par_pre'] . $etiquetas['progresivo']. ' - '. substr($etiquetas['cambDesc'], 0, 19);
                    ?>
                </td>
            </tr>
        </table>
        
        <?php    
        if ($i == 3 or $i == 6 or $i == 9 or $i == 12 or $i == 15 or $i == 18 
            or $i == 21 or $i == 24 or $i == 27 or $i == 30)
            {echo "</td></tr><tr>"; } else { echo "</td>";}
               //echo "</td>";
       //if (($i % 3) == 1){ echo "<td></tr>";} else { echo "</td>";}
            //echo "</td>";
            $i++;
       
       
        ?>
    @endforeach
    <?php echo "</tr>";?>
</table>
</html>