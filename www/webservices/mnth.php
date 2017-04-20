<?php
 for($i = 1; $i <=  date('t'); $i++)
        {
           // add the date to the dates array
           $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
        }

        // show the dates array
        $dates;
?>
<?php
$var=date('d');
?><font color="#567890"> <?php echo $var; ?></font>