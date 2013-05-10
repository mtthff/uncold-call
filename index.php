<?php
try{
    $DBH = new PDO("sqlite:nocoldcalls.sqlite");
    $DBH->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);// ::TODO:: change it befor productive

    $STH = $DBH->query('SELECT strftime("%d.%m.%Y", a.datetime) AS day,
                                strftime("%H:%M", a.datetime) AS time,
                                cu.organisation,
                                a.contact,
                                a.phone AS appoint_phone,
                                a.mobil AS appoint_mobil,
                                cu.phone AS custom_phone,
                                cu.mobil AS custom_mobil,
                                a.number,
                                a.comment,
                                a.specialized_value,
                                co.name,
                                strftime("%d.%m.%Y", a.listed_date) AS listed_date
                            FROM appointment AS a
                            LEFT JOIN customer AS cu ON (a.customer_id = cu.id)
                            LEFT JOIN contributor AS co ON (a.contributor_id = co.id)
                            ORDER BY day ASC');

    $STH->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $STH->fetch()){
        $app[]= $row;
    }
//    echo "<pre>";
//    print_r($app);
//    exit;
    
    
}
catch(PDOException $e) //Besonderheiten anzeigen
{
	print 'Exception : '.$e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <title>No Cold Calls</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Matthias Hoffmann">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a class="brand" href="index.html">No Cold Call</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Übersicht</a></li>
              <li><a href="customer.php">Kundenverwaltung</a></li>
              <li><a href="#">Admin</a></li>
              <li><a href="#">Backup</a></li>
              <li><a href="about.php">About</a></li>			  
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

        <!-- Example row of columns -->
      <div class="row">
        <div class="span12">
          <h2>Übersicht <a href="#" class="btn btn disabled">Neuen Termin eingeben</a></h2>
          <table class="table table-hover table-condensed tablesorter" id="sortTable">

            <thead>
                <tr>
                    <th>Termin</th>
                    <th>Beginn</th>
                    <th>Einrichtung/Schule</th>
                    <th>Leiter</th>
                    <th>Telefon</th>
                    <th>Alter/Klassenstufe</th>
                    <th>Teilnehmerzahl</th>
                    <th>Tarif</th>
                    <th>JuHe</th>
                    <th>Version</th>
                    <th>Foto-CD</th>
                    <th>Bemerkung</th>                    
                    <th>eingetragen durch</th>
                    <th>eingetragen am</th>
                    <th></th>
                    <th></th>                    
                </tr>
            </thead>
            <tbody style="font-size:.9em">
<?php

    foreach ($app as $value) {
        $spec = unserialize($value['specialized_value']);
        
        if (!$phone = $value['appoint_phone']) $phone = $value['custom_phone'];
        if (!$phone = $value['appoint_mobil']) $phone = $value['custom_mobil'];
        
        if ($spec['JuHe']) $juhe = '<i class="icon-ok">'; 
        if ($spec['Foto-CD']) $fotoCD = '<i class="icon-ok">'; 
        
        echo '<tr>';
        echo '<td>'.$value['day'].'</td>';
        echo '<td>'.$value['time'].'</td>';
        echo '<td>'.$value['organisation'].'</td>';
        echo '<td>'.$value['contact'].'</td>';
        echo '<td>'.$phone.'</td>';
        echo '<td>'.$spec['Klassenstufe'].'</td>';
        echo '<td>'.$value['number'].'</td>';
        echo '<td>'.$spec['Tarif'].'</td>';
        echo '<td>'.$juhe.'</td>';
        echo '<td>'.$spec['Version'].'</td>';
        echo '<td>'.$fotoCD.'</td>';
        echo '<td>'.$value['comment'].'</td>';
        echo '<td>'.$value['name'].'</td>';
        echo '<td>'.$value['listed_date'].'</td>';
        echo '<td><i class="icon-pencil"></i></td>';
        echo '<td><i class="icon-trash"></i></td>';                    
        echo '</tr>';
        
        $juhe = NULL;
        $fotoCD = NULL;
}
?>
                
            </tbody>
          </table>    
        </div>
      </div>

      <hr>

      <footer>
        <p>Stand: 30.04.2013</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-2.0.0.min.js"></script>
    <script src="js/jquery.tablesorter.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>

  </body>
</html>
