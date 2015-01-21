<?php

// Note: This is a demo only. Don't store emails
// in a text file like this on a real site!
$fp = fopen ('contenu.json', 'a');
fwrite ($fp, $_POST['input'] . "\n");
fclose ($fp);
?>