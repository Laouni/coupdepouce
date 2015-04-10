<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');    

    $trace = $this->getTrace();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Erreur dans l'application</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Fichier Erreur debug</h1>
        <p><?php echo $this->message; ?></p>
        <p>Fichier : <?php echo $this->file; ?></p>
        <p>Ligne : <?php echo $this->line; ?></p>
        <?php if(count($trace)>0): ?>
        <p>Fonction : <?php echo $trace[0]['class'].'::'.$trace[0]['function']; ?></p>
        <pre><?php echo $this->getTraceAsString(); ?></pre>
        <?php endif; ?>
    </body>
</html>


