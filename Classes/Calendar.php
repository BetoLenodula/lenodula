<?php 
	namespace Classes;

	class Calendar{

		public function create_calendar($month,$year,$calendar){
			// Declaramos variables de dias y semanas
			// usamos mktime para crear la fecha exacta que queremos para crear valor $time 
			$running_day = date('w',mktime(0,0,0,$month,1,$year)); // w devuelve el numero del dia de la semana
			$days_in_month = date('t',mktime(0,0,0,$month,1,$year)); //t devuelve el numero de dias del mes
			$days_in_week = 0;
			$day = 1;
			$week = 0;
			
			// Mandamos datos de los dias de la semana al arreglo
			// Imprimimos dias en blanco hasta alcanzar el primero en la semana
			for ($days_in_week = 0; $days_in_week < $running_day; $days_in_week++){
				$calendar [$week][$days_in_week] = 0;
			}
			
			// Procedemos con los dias
			while ($day <= $days_in_month) {
			// Mientras no se llegue al numero de dias del mes llenamos el arreglo
				while($days_in_week < 7) { 
				// Asignamos los dias restantes mientras no lleguemos al tope de dias de semana 7.
				// Al terminar los dias del mes seguimos llenando el arreglo de vacio
					if ($day <= $days_in_month){
						$calendar [$week][$days_in_week] = $day;
					} else {
						$calendar [$week][$days_in_week] = 0;
					}

					$days_in_week++;
					$day++;
				}
				$days_in_week = 0;
				$week++;

			}
			return $calendar;
		}

		// Funcion que despliega el calendario
		public function __construct($mo, $ye, $da, $arr_events, $arr_alerts){
			$timeArray = localtime(time(),true);

			if($mo == null){
				$month = $timeArray["tm_mon"]+1;			
			}
			else{
				$month = $mo;
			}
			if($ye == null){
				$year = $timeArray["tm_year"]+1900; 	
			}
			else{
				$year = $ye;
			}
			if($da == null){
				$hoy = date('d');
			}	
			else{
				$hoy = $da;	
			}

			$calendar = array(array());
			$cal_size = 0;
			$week = 0;
			$cell = 1;
			$month_name = "";
			
			//Creamos el arreglo Calendario
			$calendar = $this->create_calendar($month,$year,$calendar);
		    // Longitud del Calendario incluyendo espacios en blanco, con llamada recursiva para que sea completo;
			// Al ser recursivo nos suma tambien los renglones que son los arrays padres de las celdas, entonces restamos
			$cal_size =	count($calendar,COUNT_RECURSIVE) - count($calendar); 
			//Imprime $month and $year
			switch ($month) {  // Obtenemos el nombre en castellano del mes
				case 1 : $month_name = "ENERO";
					break;
				case 2 : $month_name = "FEBRERO";
					break;
				case 3 : $month_name = "MARZO";
					break;
				case 4 : $month_name = "ABRIL";
					break;
				case 5 : $month_name = "MAYO";
					break;
				case 6 : $month_name = "JUNIO";
					break;
				case 7 : $month_name = "JULIO";
					break;
				case 8 : $month_name = "AGOSTO";
					break;
				case 9 : $month_name = "SEPTIEMBRE";
					break;
				case 10 : $month_name = "OCTUBRE";
					break;
				case 11 : $month_name = "NOVIEMBRE";
					break;
				case 12 : $month_name = "DICIEMBRE";
				
			}
			//Creamos las celdas de los dias de la semana
			while ($cell <= $cal_size){
				?>
				<tr>
				<?php
				for ($day=0;$day<7;$day++){

					if($month < 10){
						$mes = "0".$month;
					}
					else{
						$mes = $month;
					}
					if($calendar[$week][$day] < 10){
						$dia = "0".$calendar[$week][$day];
					}
					else{
						$dia = $calendar[$week][$day];
					}

					if ($calendar[$week][$day]!=0){
						if($hoy==$calendar[$week][$day]){
						?>
					<td class='<?= base64_encode($year.'-'.$mes.'-'.$dia) ?>'>
						<div id="hoy"><?= $calendar[$week][$day]; ?></div>
						<?php
						if(isset($_SESSION['userSesion'])){
						if($arr_alerts != null){  
							if(in_array($calendar[$week][$day], $arr_alerts)){
						?>
							<i class="material-icons ntdt">notifications_active</i>
						<?php	
							}
						}
						if($arr_events != null && isset($_SESSION['userSesion'])){  
							if(in_array($calendar[$week][$day], $arr_events)){
						?>
						<i class="material-icons pin pinn">flag</i>
						<?php	
							}
							if(in_array($calendar[$week][$day]+1, $arr_events)){
						?>
						<i class="material-icons pin pinr" title="Tienes eventos mañana">forward</i>
						<?php
							}
						}
						}
						?>
					</td>
						<?php
										
						}
						else{
						?>
					<td class="<?= base64_encode($year.'-'.$mes.'-'.$dia) ?>"><?= $calendar[$week][$day]; ?>
						<?php
						if(isset($_SESSION['userSesion'])){
						if($arr_events != null && isset($_SESSION['userSesion'])){  
							if(in_array($calendar[$week][$day], $arr_events)){
								if(date('Y-m-d', strtotime($year."-".$month."-".$calendar[$week][$day])) >= date('Y-m-d')){
						?>
								<i class="material-icons pin pinn">flag</i>
						<?php	
								}
								else{
						?>		
								<i class="material-icons pin pinp">outlined_flag</i>
						<?php			
								}
							}
						}
						}
						?>
					</td>
						<?php
						}
					} 
					else{ 
						?>
					<td class="nonetd"></td>
						<?php 
					}
					$cell++;
				}
				$week++;
				?>
				</tr>
				<?php
			}
			?>
				<tr><td colspan='7' class='year_bar'><span><?= $month_name."&nbsp;".$year; ?></span></td></tr>
			<?php
		}
	}

 ?>