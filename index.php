<?php
  include 'FootballData.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>phplib football-data.org</title>
        <link href="./css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
                <div class="page-header">
                    <h1>Showcasing some library functions...</h1>
					<?php
					$day = date('w');
					
					$week_start = date('Y-m-d', strtotime('-'.$day + 1 .' days'));
					$week_end = date('Y-m-d', strtotime('+'.(6-$day + 1 ).' days'));
					
					$servername = "localhost";
					$username = "root";
					$password = "javi#1234";
					$dbname = "futbol";
					
					try {
						$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $conn->prepare("SELECT * FROM partidos WHERE estado != 'FINISHED'");
						$stmt->execute();

						// set the resulting array to associative
						$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
						foreach(RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
							echo $v;
						}
					}
					catch(PDOException $e){
						echo $sql . "<br>" . $e->getMessage();
					}

					$conn = null;
					die();
					?>
                </div>
                <?php
                // Create instance of API class
                $api = new FootballData();
                
                echo "<p><hr><p>";
                // fetch all available upcoming matches for the next 3 days
				
                $response = $api->findMatchesForDateRange($week_start, $week_end);
				//var_dump($response);
				foreach($response->matches as $partido){
					
					$time = strtotime($partido->utcDate);					
					$fecha =  date("d-m-Y H:i:s", $time);
					$resultadoFin = '';
					$resultadoMedio = '';
					if($partido->status == 'FINISHED'){
						$resultadoFin = $partido->score->fullTime->homeTeam ." - ".$partido->score->fullTime->awayTeam;
					}
					if(isset($partido->score->halfTime)){
						$resultadoMedio = $partido->score->halfTime->homeTeam ." - ".$partido->score->halfTime->awayTeam;
					}
					
					echo "INSERT INTO `futboll`.`partidos` (`id`,`liga`,`estado`,`equipoLocal`, `equipoVisitante`, `nombre`, `fecha`, `resultadoFinal`, `resultadoMedio`, `canal`) 
					VALUES (
					'{$partido->id}',
					'{$partido->competition->id}',
					'{$partido->status}',
					'{$partido->homeTeam->id}',
					'{$partido->awayTeam->id}',					
					'{$partido->homeTeam->name} vs {$partido->awayTeam->name}',		
					'{$fecha}',
					'{$resultadoFinal}',
					'{$resultadoMedio}',
					''
					);<br>";
				}
				//var_dump($response);die();
            ?>
            <h3>Upcoming matches within the next 3 days</h3>
			<table class="table table-striped">
				<tr>
					<th>HomeTeam</th>
					<th></th>
					<th>AwayTeam</th>
					<th colspan="3">Result</th>
				</tr>
				<?php foreach ($response->matches as $match) { ?>
				<tr>
					<td><?php echo $match->homeTeam->name; ?></td>
					<td>-</td>
					<td><?php echo $match->awayTeam->name; ?></td>
					<td><?php echo $match->score->fullTime->homeTeam; ?></td>
					<td>:</td>
					<td><?php echo $match->score->fullTime->awayTeam; ?></td>
				</tr>
				<?php } ?>
			</table>

        </div>
    </body>
</html>
