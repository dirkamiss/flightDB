<?php
namespace flightDB\Controllers;
use flightDB\Models\Crew;
use flightDB\Models\Flight;
use flightDB\Models\Maintenance;


/**
 * Display the default index page.
 */
class FourController extends ControllerBase
{

	public function initialize()
	{
		$this->view->setTemplateBefore('public');
	}

	public function indexAction()
	{
		return $this->dispatcher->forward(array(
			'controller' => 'four',
			'action' => 'a'
		));
	}

	public function assignAction($id, $fnum) {
		if( is_null($id) && is_null($fnum) ) {
			return;
		}

		$flight = Flight::findFirst($fnum);
		$crew = Crew::findFirst($id);

		if( $crew->position === 'Pilot'){
			$flight->pilot = $id;
		} else if ($crew->position === 'Co-pilot') {
			$flight->copilot = $id;
		}

		try {
			if ($flight->update()) {

				$this->flash->success('Saved Flight Record');
				
			} else {
				$this->flash->error($crew->getMessages());
				return $this->dispatcher->forward(array(
					'controller' => 'four',
					'action' => 'a'
				));
			}
		} catch(\Exception $e) {
			return;
		}
	}

	public function deleteAction($fnum) {
		if( is_null($fnum) ) {
			return;
		}

		$flight = Flight::findFirst($fnum);
		if ($flight != false) {
			if ($flight->delete() == false) {
				echo "Error: Flight wasn't deleted";
			} else {
				echo "Deleted";
			}
		}

		$this->view->disable();
	}

	public function aAction()
	{

		if ($this->request->isPost()) {

			$id = $this->request->getPost('id');
			$name = $this->request->getPost('name');
			$salary = $this->request->getPost('salary');
			$position = $this->request->getPost('position');
			$seniority = $this->request->getPost('seniority');
			$hours = $this->request->getPost('hours');
			if( "" !== $this->request->getPost('supervisor') ){
				$supervisor = $this->request->getPost('supervisor');
			} else {
				$supervisor = NULL;
			}
			$certified = $this->request->getPost('certified');
			$certified = '{'.preg_replace('/\s+/', '', $certified).'}';

			$crew = new Crew();
			$crew->crew_id = $id;
			$crew->name = $name;
			$crew->salary = $salary;
			$crew->position = $position;
			$crew->seniority = $seniority;
			$crew->flying_hours = $hours;
			$crew->supervisor = $supervisor;
			$crew->aircrafts_certified_to_fly = $certified;

			try {
				if ($crew->save()) {

					$this->flash->success('Saved Crew Member Record');
					
				} else {
					$this->flash->error($crew->getMessages());
				}
			} catch(\Exception $e) {
				$this->flash->error('Invalid Parameters');
			}
			
		}


		$crew = $this->modelsManager->executeQuery('SELECT * FROM flightDB\Models\Crew ORDER BY 1')->toArray();
		$this->view->crew = $crew;
	}


	public function bAction()
	{

		if ($this->request->isPost()) {

			$flightNumber = $this->request->getPost('flightNumber');
			$aircraft = $this->request->getPost('aircraft');
			$departCity = $this->request->getPost('departCity');
			$destCity = $this->request->getPost('destCity');
			$departHour = $this->request->getPost('departHour');
			$departMin = $this->request->getPost('departMin');
			$arriveHour = $this->request->getPost('arriveHour');
			$arriveMin = $this->request->getPost('arriveMin');

			$departMin = str_pad($departMin,2,"0",STR_PAD_LEFT);
			$arriveMin = str_pad($arriveMin,2,"0",STR_PAD_LEFT); 
			$departTime = $departHour . $departMin;
			$arriveTime = $arriveHour . $arriveMin;

			$airfare = $this->request->getPost('airfare');
			$mileage = $this->request->getPost('mileage');
			$bookedPassengers = $this->request->getPost('bookedPassengers');
			$pilotId = $this->request->getPost('pilotId');
			$coPilotId = $this->request->getPost('coPilotId');

			$flight = new Flight();
			$flight->flight_number = $flightNumber;
			$flight->aircraft_used = $aircraft;
			$flight->departure_city = $departCity;
			$flight->destination_city = $destCity;
			$flight->departure_time = $departTime;
			$flight->arrival_time = $arriveTime;
			$flight->airfare = $airfare;
			$flight->mileage = $mileage;
			$flight->number_of_booked_passengers = $bookedPassengers;
			$flight->pilot = $pilotId;
			$flight->copilot = $coPilotId;

			try {
				if ($flight->save()) {

					$this->flash->success('Saved Crew Member Record');
					
				} else {
					$this->flash->error($flight->getMessages());

				}
			} catch(\Exception $e) {
				$this->flash->error('Invalid Parameters');
			}
			
		}


		$flights = $this->modelsManager->executeQuery('SELECT * FROM flightDB\Models\Flight ORDER BY 1')->toArray();
		$this->view->flights = $flights;
	}


	public function cAction()
	{

		if ($this->request->isPost()) {

			$id = $this->request->getPost('id');
			$name = $this->request->getPost('name');
			$salary = $this->request->getPost('salary');
			$position = $this->request->getPost('position');
			$seniority = $this->request->getPost('seniority');
			$hours = $this->request->getPost('hours');
			if( "" !== $this->request->getPost('supervisor') ){
				$supervisor = $this->request->getPost('supervisor');
			} else {
				$supervisor = NULL;
			}
			$certified = $this->request->getPost('certified');
			$certified = '{'.preg_replace('/\s+/', '', $certified).'}';

			$crew = Crew::findFirst($id);
			$crew->name = $name;
			$crew->salary = $salary;
			$crew->position = $position;
			$crew->seniority = $seniority;
			$crew->flying_hours = $hours;
			$crew->supervisor = $supervisor;
			$crew->aircrafts_certified_to_fly = $certified;

			try {
				if ($crew->save()) {

					$this->flash->success('Saved Crew Member Record');
					
				} else {
					$this->flash->error($crew->getMessages());
					return $this->dispatcher->forward(array(
						'controller' => 'four',
						'action' => 'a'
					));
				}
			} catch(\Exception $e) {
				$this->flash->error('Invalid Parameters');
			}
			
		}


		$crew = $this->modelsManager->executeQuery('SELECT * FROM flightDB\Models\Crew ORDER BY 1')->toArray();
		$this->view->crew = $crew;
	}

	public function dAction()
	{

		if ($this->request->isPost()) {

			$flightNumber = $this->request->getPost('flightNumber');
			$aircraft = $this->request->getPost('aircraft');
			$departCity = $this->request->getPost('departCity');
			$destCity = $this->request->getPost('destCity');
			$departHour = $this->request->getPost('departHour');
			$departMin = $this->request->getPost('departMin');
			$arriveHour = $this->request->getPost('arriveHour');
			$arriveMin = $this->request->getPost('arriveMin');

			$departMin = str_pad($departMin,2,"0",STR_PAD_LEFT);
			$arriveMin = str_pad($arriveMin,2,"0",STR_PAD_LEFT); 
			$departTime = $departHour . $departMin;
			$arriveTime = $arriveHour . $arriveMin;

			$airfare = $this->request->getPost('airfare');
			$mileage = $this->request->getPost('mileage');
			$bookedPassengers = $this->request->getPost('bookedPassengers');
			$pilotId = $this->request->getPost('pilotId');
			$coPilotId = $this->request->getPost('coPilotId');

			$flight = Flight::findFirst($flightNumber);
			$flight->aircraft_used = $aircraft;
			$flight->departure_city = $departCity;
			$flight->destination_city = $destCity;
			$flight->departure_time = $departTime;
			$flight->arrival_time = $arriveTime;
			$flight->airfare = $airfare;
			$flight->mileage = $mileage;
			$flight->number_of_booked_passengers = $bookedPassengers;
			$flight->pilot = $pilotId;
			$flight->copilot = $coPilotId;

			try {
				if ($flight->save()) {

					$this->flash->success('Saved Flight Record');
					
				} else {
					$this->flash->error($flight->getMessages());

				}
			} catch(\Exception $e) {
				$this->flash->error('Invalid Parameters');
			}
			
		}


		$flights = $this->modelsManager->executeQuery('SELECT * FROM flightDB\Models\Flight ORDER BY 1')->toArray();
		$this->view->flights = $flights;
	}



	public function eAction()
	{

		if ($this->request->isPost()) {

			$logNumber = $this->request->getPost('logNumber');
			$aircraft = $this->request->getPost('aircraft');
			$date = $this->request->getPost('date');
			$job = $this->request->getPost('job');
			$job = '{'.preg_replace('/\s+/', '', $job).'}';
			$next = $this->request->getPost('next');
			
			$record = new Maintenance();
			$record->log_number = $logNumber;
			$record->aircraft = $aircraft;
			$record->date = $date;
			$record->job = $job;
			$record->next = $next;

			try {
				if ($record->save()) {

					$this->flash->success('Saved Flight Record');
					
				} else {
					$this->flash->error($record->getMessages());

				}
			} catch(\Exception $e) {
				$this->flash->error('Invalid Parameters');
			}
			
		}


		$records = $this->modelsManager->executeQuery('SELECT * FROM flightDB\Models\Maintenance ORDER BY 1')->toArray();
		$this->view->records = $records;
	}


	public function fAction()
	{

		if ($this->request->isPost()) {

			$flightNumber = $this->request->getPost('flightNumber');
			$aircraft = $this->request->getPost('aircraft');
			$departCity = $this->request->getPost('departCity');
			$destCity = $this->request->getPost('destCity');
			$departHour = $this->request->getPost('departHour');
			$departMin = $this->request->getPost('departMin');
			$arriveHour = $this->request->getPost('arriveHour');
			$arriveMin = $this->request->getPost('arriveMin');

			$departMin = str_pad($departMin,2,"0",STR_PAD_LEFT);
			$arriveMin = str_pad($arriveMin,2,"0",STR_PAD_LEFT); 
			$departTime = $departHour . $departMin;
			$arriveTime = $arriveHour . $arriveMin;

			$airfare = $this->request->getPost('airfare');
			$mileage = $this->request->getPost('mileage');
			$bookedPassengers = $this->request->getPost('bookedPassengers');
			$pilotId = $this->request->getPost('pilotId');
			$coPilotId = $this->request->getPost('coPilotId');

			$flight = Flight::findFirst($flightNumber);
			$flight->aircraft_used = $aircraft;
			$flight->departure_city = $departCity;
			$flight->destination_city = $destCity;
			$flight->departure_time = $departTime;
			$flight->arrival_time = $arriveTime;
			$flight->airfare = $airfare;
			$flight->mileage = $mileage;
			$flight->number_of_booked_passengers = $bookedPassengers;
			$flight->pilot = $pilotId;
			$flight->copilot = $coPilotId;

			try {
				if ($flight->save()) {

					$this->flash->success('Saved Flight Record');
					
				} else {
					$this->flash->error($flight->getMessages());

				}
			} catch(\Exception $e) {
				$this->flash->error('Invalid Parameters');
			}
			
		}


		$flights = $this->modelsManager->executeQuery('SELECT * FROM flightDB\Models\Flight ORDER BY 1')->toArray();
		$this->view->flights = $flights;
	}

}
