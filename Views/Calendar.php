<?php 
	namespace Views;

	use Classes\Calendar as objCalendar;

	class Calendar{

		private $month;
		private $year;
		private $day;
		private $style;
		private $notif;
		private $arr_events;
		private $arr_alerts;


		public function __construct($m, $y, $d, $style, $notif, $array_events, $array_alerts){
			$this->month = $m;
			$this->year = $y;
			$this->day = $d;
			$this->style = $style;
			$this->notif = $notif;
			$this->arr_events = $array_events;
			$this->arr_alerts = $array_alerts;
?>
				<div class='calendar'>
					<table width='100%' cellspacing='0' class="<?= $this->style ?>">
						<thead>
							<tr class="th">
								<td colspan="7" align="left">
									<i class="material-icons ih">event</i>
									<?php 
										if($this->notif != null && $this->notif == 1):
									?>
									<i class="material-icons nd" title="Eventos próximos">notifications_active</i>
									<?php		
										endif;
									 ?>
								</td>
							</tr>
							<tr class="tr_days">
								<td>Dom</td>
								<td>Lun</td>
								<td>Mar</td>
								<td>Mié</td>
								<td>Jue</td>
								<td>Vie</td>
								<td>Sab</td>
							</tr>
						</thead>
						<tbody>
							<?php
								new objCalendar($this->month, $this->year, $this->day, $this->arr_events, $this->arr_alerts);
							?>
						</tbody>
					</table>
				</div>
<?php
		}

	}


 ?>