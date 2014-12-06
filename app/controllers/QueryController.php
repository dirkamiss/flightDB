<?php
namespace flightDB\Controllers;
use flightDB\Models\Flight;
use Phalcon\Mvc\Model\Query as Query;
use Phalcon\Db as PhalconDb;

/**
 * Display the default index page.
 */
class QueryController extends ControllerBase
{
	public function invalidAction() {

	}
	/**
	 * Default action. Set the public layout (layouts/public.volt)
	 */
	public function OneaAction()
	{
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');
			$stops = $this->request->getPost('stops');
			$stops++;

			if( $depart_city !== "" && $dest_city !== "" && $stops !== "" && $stops > 0 && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,airfare,depth) AS (
							SELECT flight_number,departure_city,destination_city,airfare, 1::INT AS depth, 
							NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.airfare+r.airfare, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT flight_number, departure_city, destination_city, departure_time, arrival_time, airfare
						FROM flight
						WHERE flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE depth = '.$stops.'
							AND airfare = ( 
								SELECT MIN(airfare) FROM reaches
								WHERE depth = r1.depth
								AND destination_city = \''.$dest_city.'\'
							)
							
						)::INT[]);';

				$query = $this->db->query($sql);
				$results = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $result = $query->fetchArray()){
					array_push($results, $result);
				}


				$sql2 = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,airfare,depth) AS (
							SELECT flight_number,departure_city,destination_city,airfare, 1::INT AS depth, 
							NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.airfare+r.airfare, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT MIN(airfare) FROM reaches
							WHERE depth = '.$stops.'
							AND destination_city = \''.$dest_city.'\'';

				$query = $this->db->query($sql2);
				$total = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($total, $t);
				}


				if( empty($results) ){
					$columns = [];
				} else {
					$first = $results[0];
					$columns = array_keys($first);
				}
			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}


		$this->view->results = $results;
		$this->view->columns = $columns;
		$this->view->total = $total;
	}

//////////////////////////////////////////////////////////////////////////////////////////////////

	public function OnebAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');
			$stops = $this->request->getPost('stops');
			$stops++;

			if( $depart_city !== "" && $dest_city !== "" && $stops !== "" && $stops > 0 && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,airfare,depth) AS (
							SELECT flight_number,departure_city,destination_city,airfare, 1::INT AS depth, 
							NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.airfare+r.airfare, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT flight_number, departure_city, destination_city, departure_time, arrival_time, airfare
						FROM flight
						WHERE flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE depth <= '.$stops.'
							AND airfare = ( 
								SELECT MIN(airfare) FROM reaches
								WHERE depth <= '.$stops.'
								AND destination_city = \''.$dest_city.'\'
							)
							AND destination_city = \''.$dest_city.'\'
							
						)::INT[]);';

				$query = $this->db->query($sql);
				$results = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $result = $query->fetchArray()){
					array_push($results, $result);
				}


				$sql2 = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,airfare,depth) AS (
							SELECT flight_number,departure_city,destination_city,airfare, 1::INT AS depth, 
							NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.airfare+r.airfare, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT MIN(airfare) FROM reaches
							WHERE depth <= '.$stops.'
							AND destination_city = \''.$dest_city.'\'';

				$query = $this->db->query($sql2);
				$total = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($total, $t);
				}


				if( empty($results) ){
					$columns = [];
				} else {
					$first = $results[0];
					$columns = array_keys($first);
				}
			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Onea");
		$this->view->results = $results;
		$this->view->columns = $columns;
		$this->view->total = $total;
	}


//////////////////////////////////////////////////////////////////////////////////////////////////

	public function OnecAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');
			$stopover = $this->request->getPost('stopover') * 60;

			if( $depart_city !== "" && $dest_city !== "" && $stopover !== "" && $stopover > 0 && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,airfare,departure_time,arrival_time, stopover, depth) AS (
							SELECT flight_number,departure_city,destination_city,airfare,departure_time,arrival_time
							, 0::INT AS stopover
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.airfare+r.airfare
							,f.departure_time,f.arrival_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT f1.flight_number, f1.departure_city, f1.destination_city, f1.departure_time, f1.arrival_time, f1.airfare
						,
						CASE WHEN f2.departure_time > f1.arrival_time 
						THEN ((f2.departure_time/100 - f1.arrival_time/100) * 60) + (f2.departure_time%100 - f1.arrival_time%100)
						ELSE ((23 - @(f2.departure_time/100 - f1.arrival_time/100)) * 60) + @(f2.departure_time%100 - f1.arrival_time%100)
						END AS stopover_minutes
						FROM flight f1
						LEFT JOIN flight f2 ON f1.destination_city = f2.departure_city
						WHERE f1.flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE airfare = ( 
								SELECT MIN(airfare) FROM reaches
								WHERE destination_city = \''.$dest_city.'\'
								AND stopover <= '.$stopover.'
							)
							AND destination_city = \''.$dest_city.'\'
							AND stopover <= '.$stopover.'
							LIMIT 1
							
						)::INT[])
						AND (f2.flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE airfare = ( 
								SELECT MIN(airfare) FROM reaches
								WHERE destination_city = \''.$dest_city.'\'
								AND stopover <= '.$stopover.'
							)
							AND destination_city = \''.$dest_city.'\'
							AND stopover <= '.$stopover.'
							LIMIT 1
							
						)::INT[]) OR f2.flight_number IS NULL);';

				$query = $this->db->query($sql);
				$results = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $result = $query->fetchArray()){
					array_push($results, $result);
				}


				$sql2 = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,airfare,departure_time,arrival_time, stopover, depth) AS (
							SELECT flight_number,departure_city,destination_city,airfare,departure_time,arrival_time
							, 0::INT AS stopover
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.airfare+r.airfare
							,f.departure_time,f.arrival_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT MIN(airfare) FROM reaches
						WHERE destination_city = \''.$dest_city.'\'
						AND stopover <= '.$stopover;

				$query = $this->db->query($sql2);
				$total = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($total, $t);
				}

				$sql3 = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,airfare,departure_time,arrival_time, stopover, depth) AS (
							SELECT flight_number,departure_city,destination_city,airfare,departure_time,arrival_time
							, 0::INT AS stopover
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.airfare+r.airfare
							,f.departure_time,f.arrival_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT stopover FROM reaches
						WHERE destination_city = \''.$dest_city.'\'
						AND stopover <= '.$stopover.'
						AND airfare = ( 
							SELECT MIN(airfare) FROM reaches
							WHERE destination_city = \''.$dest_city.'\'
							AND stopover <= '.$stopover.'
						)
						GROUP BY stopover
						LIMIT 1';

				$query = $this->db->query($sql3);
				$totalStop = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $ts = $query->fetchArray()){
					array_push($totalStop, $ts);
				}





				if( empty($results) ){
					$columns = [];
				} else {
					$first = $results[0];
					$columns = array_keys($first);
				}
			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Onea");
		$this->view->results = $results;
		$this->view->columns = $columns;
		$this->view->total = $total;
		$this->view->totalStop = $totalStop;
	}

//////////////////////////////////////////////////////////////////////////////////////////////////


	public function OnedAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');
			$stop_city = $this->request->getPost('stop_city');

			if( $depart_city !== "" && $dest_city !== "" && $stop_city !== "" && $stop_city !== $depart_city && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,airfare,depth) AS (
							SELECT flight_number,departure_city,destination_city,airfare, 1::INT AS depth, 
							NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.airfare+r.airfare, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
							WHERE f.departure_city <> \''.$stop_city.'\'
						)
						SELECT flight_number, departure_city, destination_city, departure_time, arrival_time, airfare
						FROM flight
						WHERE flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE airfare = ( 
								SELECT MIN(airfare) FROM reaches
								WHERE destination_city = \''.$dest_city.'\'
							)
							AND destination_city = \''.$dest_city.'\'
							
						)::INT[]);';

				$query = $this->db->query($sql);
				$results = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $result = $query->fetchArray()){
					array_push($results, $result);
				}


				$sql2 = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,airfare,depth) AS (
							SELECT flight_number,departure_city,destination_city,airfare, 1::INT AS depth, 
							NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.airfare+r.airfare, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
							WHERE f.departure_city <> \''.$stop_city.'\'
						)
						SELECT MIN(airfare) FROM reaches
						WHERE destination_city = \''.$dest_city.'\'';

				$query = $this->db->query($sql2);
				$total = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($total, $t);
				}


				if( empty($results) ){
					$columns = [];
				} else {
					$first = $results[0];
					$columns = array_keys($first);
				}
			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Onea");
		$this->view->results = $results;
		$this->view->columns = $columns;
		$this->view->total = $total;
	}


//////////////////////////////////////////////////////////////////////////////////////////////////


	public function twoaAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');

			if( $depart_city !== "" && $dest_city !== "" && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,departure_time,arrival_time, stopover, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,departure_time,arrival_time
							, 0::INT AS stopover
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage
							,f.departure_time,f.arrival_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT flight_number, departure_city, destination_city, departure_time, arrival_time, mileage
						FROM flight
						WHERE flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE mileage = ( 
								SELECT MIN(mileage) FROM reaches
								WHERE destination_city = \''.$dest_city.'\'
							)
							
						)::INT[]);';

				$query = $this->db->query($sql);
				$results = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $result = $query->fetchArray()){
					array_push($results, $result);
				}


				$sql2 = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,departure_time,arrival_time, stopover, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,departure_time,arrival_time
							, 0::INT AS stopover
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage
							,f.departure_time,f.arrival_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT MIN(mileage) FROM reaches
						WHERE destination_city = \''.$dest_city.'\'';

				$query = $this->db->query($sql2);
				$total = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($total, $t);
				}


				if( empty($results) ){
					$columns = [];
				} else {
					$first = $results[0];
					$columns = array_keys($first);
				}
			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Twoa");
		$this->view->results = $results;
		$this->view->columns = $columns;
		$this->view->total = $total;
	}


//////////////////////////////////////////////////////////////////////////////////////////////////


	public function twobAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');

			if( $depart_city !== "" && $dest_city !== "" && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,departure_time,arrival_time, stopover, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,departure_time,arrival_time
							, 0::INT AS stopover
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage
							,f.departure_time,f.arrival_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT flight_number, departure_city, destination_city, departure_time, arrival_time, mileage
						FROM flight
						WHERE flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE depth = ( 
								SELECT MIN(depth) FROM reaches
								WHERE destination_city = \''.$dest_city.'\'
							)
							AND destination_city = \''.$dest_city.'\'
							LIMIT 1
							
						)::INT[]);';

				$query = $this->db->query($sql);
				$results = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $result = $query->fetchArray()){
					array_push($results, $result);
				}


				$sql2 = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,departure_time,arrival_time, stopover, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,departure_time,arrival_time
							, 0::INT AS stopover
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage
							,f.departure_time,f.arrival_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT MIN(mileage) FROM reaches
						WHERE destination_city = \''.$dest_city.'\'';

				$query = $this->db->query($sql2);
				$total = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($total, $t);
				}


				if( empty($results) ){
					$columns = [];
				} else {
					$first = $results[0];
					$columns = array_keys($first);
				}
			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Twoa");
		$this->view->results = $results;
		$this->view->columns = $columns;
		$this->view->total = $total;
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////


	public function twocAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');

			if( $depart_city !== "" && $dest_city !== "" && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,departure_time,arrival_time,flight_time,stopover, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,departure_time,arrival_time
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS flight_time
							, 0::INT AS stopover
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage
							,f.departure_time,f.arrival_time
							, r.flight_time + 
							((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) AS flight_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT flight_number, departure_city, destination_city, departure_time, arrival_time
						,((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS flight_minutes
						FROM flight
						WHERE flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE flight_time = ( 
								SELECT MIN(flight_time) FROM reaches
								WHERE destination_city = \''.$dest_city.'\'
							)
							AND destination_city = \''.$dest_city.'\'
							
						)::INT[]);';

				$query = $this->db->query($sql);
				$results = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $result = $query->fetchArray()){
					array_push($results, $result);
				}


				$sql2 = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,departure_time,arrival_time,flight_time,stopover, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,departure_time,arrival_time
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS flight_time
							, 0::INT AS stopover
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage
							,f.departure_time,f.arrival_time
							, r.flight_time + 
							((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) AS flight_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT MIN(flight_time) FROM reaches
						WHERE destination_city = \''.$dest_city.'\'';

				$query = $this->db->query($sql2);
				$total = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($total, $t);
				}


				if( empty($results) ){
					$columns = [];
				} else {
					$first = $results[0];
					$columns = array_keys($first);
				}
			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Twoc");
		$this->view->results = $results;
		$this->view->columns = $columns;
		$this->view->total = $total;
		$this->view->disclaim = '(Does not include layover time)';
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////


	public function twodAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');

			if( $depart_city !== "" && $dest_city !== "" && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,departure_time,arrival_time,flight_time,stopover,total_time, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,departure_time,arrival_time
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS flight_time
							, 0::INT AS stopover
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS total_time
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage
							,f.departure_time,f.arrival_time
							, r.flight_time + 
							((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) AS flight_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.flight_time + ((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) 
							+ r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS total_time
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT f1.flight_number, f1.departure_city, f1.destination_city, f1.departure_time, f1.arrival_time, f1.airfare
						,((f1.arrival_time/100 - f1.departure_time/100) * 60) + (f1.arrival_time%100 - f1.departure_time%100) AS flight_minutes
						,
						CASE WHEN f1.destination_city = \''.$dest_city.'\' THEN NULL
						WHEN f2.departure_time > f1.arrival_time 
						THEN ((f2.departure_time/100 - f1.arrival_time/100) * 60) + (f2.departure_time%100 - f1.arrival_time%100)
						ELSE ((23 - @(f2.departure_time/100 - f1.arrival_time/100)) * 60) + @(f2.departure_time%100 - f1.arrival_time%100)
						END AS stopover_minutes
						FROM flight f1
						LEFT JOIN flight f2 ON f1.destination_city = f2.departure_city
						WHERE f1.flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE total_time = ( 
								SELECT MIN(total_time) FROM reaches
								WHERE destination_city = \''.$dest_city.'\'
							)
							AND destination_city = \''.$dest_city.'\'
							LIMIT 1
							
						)::INT[])
						AND (f2.flight_number = ANY ((
							SELECT DISTINCT previous_flight
							FROM reaches r1
							WHERE total_time = ( 
								SELECT MIN(total_time) FROM reaches
								WHERE destination_city = \''.$dest_city.'\'
							)
							AND destination_city = \''.$dest_city.'\'
							LIMIT 1
							
						)::INT[]) OR f2.flight_number IS NULL
						OR f2.flight_number IN (
							SELECT flight_number FROM flight
							WHERE departure_city = \''.$dest_city.'\'
						)
						);';

				$query = $this->db->query($sql);
				$results = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $result = $query->fetchArray()){
					array_push($results, $result);
				}


				$sql2 = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,departure_time,arrival_time,flight_time,stopover,total_time, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,departure_time,arrival_time
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS flight_time
							, 0::INT AS stopover
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS total_time
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage
							,f.departure_time,f.arrival_time
							, r.flight_time + 
							((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) AS flight_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.flight_time + ((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) 
							+ r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS total_time
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)
						SELECT MIN(total_time) FROM reaches
						WHERE destination_city = \''.$dest_city.'\'';

				$query = $this->db->query($sql2);
				$total = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($total, $t);
				}


				if( empty($results) ){
					$columns = [];
				} else {
					$first = $results[0];
					$columns = array_keys($first);
				}
			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Twoc");
		$this->view->results = $results;
		$this->view->columns = $columns;
		$this->view->total = $total;
		$this->view->disclaim = '(Includes layover time)';
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////


	public function threeaAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');
			$miles = $this->request->getPost('miles');
			$stops = $this->request->getPost('stops');
			$stops++;

			if( $depart_city !== "" && $dest_city !== "" && $stops !== "" && $stops > 0 && $miles !== "" && $miles > 0 && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,departure_time,arrival_time,flight_time,stopover,total_time, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,departure_time,arrival_time
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS flight_time
							, 0::INT AS stopover
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS total_time
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage
							,f.departure_time,f.arrival_time
							, r.flight_time + 
							((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) AS flight_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.flight_time + ((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) 
							+ r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS total_time
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)

						SELECT DISTINCT previous_flight, depth, mileage
						FROM reaches r1
						WHERE depth <= '.$stops.'
						AND mileage <= '.$miles.'
						AND destination_city = \''.$dest_city.'\'
						ORDER BY mileage, depth';

				$query = $this->db->query($sql);
				$paths = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $path = $query->fetchArray()){
					array_push($paths, $path);
				}
				print_r($paths);
				$results = [];
				foreach( $paths as $key => $value ) {
					$nums = trim($value['previous_flight'], "{}");
					$nums = explode(',', $nums);
					$flights = '';
					for($i = 0; $i < count($nums); $i++) {
						$flights .= 'SELECT '.($i+1).'::INT AS "#", flight_number, departure_city, destination_city, departure_time, arrival_time, mileage FROM flight
									WHERE flight_number = '.$nums[$i];
						if( $i < count($nums)-1 ) {
							$flights .= ' UNION ';
						} else {
							$flights .= ' ORDER BY "#";';
						}
					}
					$query = $this->db->query($flights);
					$temp = [];
					$query->setFetchMode(PhalconDb::FETCH_ASSOC);
					while( $t = $query->fetchArray()){
						array_push($temp, $t);
					}
					array_push($results, $temp);
				}

			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Threea");
		$this->view->results = $results;
	}


//////////////////////////////////////////////////////////////////////////////////////////////////


	public function threebAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');
			$airfare = $this->request->getPost('airfare');

			if( $depart_city !== "" && $dest_city !== "" && $airfare !== "" && $airfare > 0  && $airfare < 10000 && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,airfare,departure_time,arrival_time,flight_time,stopover,total_time, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,airfare,departure_time,arrival_time
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS flight_time
							, 0::INT AS stopover
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS total_time
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage,f.airfare+r.airfare
							,f.departure_time,f.arrival_time
							, r.flight_time + 
							((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) AS flight_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.flight_time + ((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) 
							+ r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS total_time
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)

						SELECT DISTINCT previous_flight, depth, airfare
						FROM reaches r1
						WHERE airfare <= '.$airfare.'
						AND destination_city = \''.$dest_city.'\'
						ORDER BY airfare, depth';

				$query = $this->db->query($sql);
				$paths = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $path = $query->fetchArray()){
					array_push($paths, $path);
				}
				print_r($paths);
				$results = [];
				foreach( $paths as $key => $value ) {
					$nums = trim($value['previous_flight'], "{}");
					$nums = explode(',', $nums);
					$flights = '';
					for($i = 0; $i < count($nums); $i++) {
						$flights .= 'SELECT '.($i+1).'::INT AS "#", flight_number, departure_city, destination_city, departure_time, arrival_time, airfare FROM flight
									WHERE flight_number = '.$nums[$i];
						if( $i < count($nums)-1 ) {
							$flights .= ' UNION ';
						} else {
							$flights .= ' ORDER BY "#";';
						}
					}
					$query = $this->db->query($flights);
					$temp = [];
					$query->setFetchMode(PhalconDb::FETCH_ASSOC);
					while( $t = $query->fetchArray()){
						array_push($temp, $t);
					}
					array_push($results, $temp);
				}

			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Threeb");
		$this->view->results = $results;
	}


//////////////////////////////////////////////////////////////////////////////////////////////////


	public function threecAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');
			$early_hour = $this->request->getPost('early_hour');
			$early_min = $this->request->getPost('early_min');
			$late_hour = $this->request->getPost('late_hour');
			$late_min = $this->request->getPost('late_min');

			if( $depart_city !== "" && $dest_city !== "" 
				&& $early_hour !== "" && $early_hour >= 0  && $early_hour <= 23
				&& $late_hour !== "" && $late_hour >= 0  && $late_hour <= 23
				&& $early_min !== "" && $early_min >= 0  && $early_min <= 59
				&& $late_min !== "" && $late_min >= 0  && $late_min <= 59
				&& $depart_city !== $dest_city) {
				
				$early_min = str_pad($early_min,2,"0",STR_PAD_LEFT);
				$late_min = str_pad($late_min,2,"0",STR_PAD_LEFT); 
				$early_time = $early_hour . $early_min;
				$late_time = $late_hour . $late_min;

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,airfare,departure_time,arrival_time,flight_time,stopover,total_time, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,airfare,departure_time,arrival_time
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS flight_time
							, 0::INT AS stopover
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS total_time
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							AND departure_time >= '.$early_time.'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage,f.airfare+r.airfare
							,r.departure_time,f.arrival_time
							, r.flight_time + 
							((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) AS flight_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.flight_time + ((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) 
							+ r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS total_time
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)

						SELECT DISTINCT previous_flight, depth, departure_time
						FROM reaches r1
						WHERE arrival_time <= '.$late_time.'
						AND destination_city = \''.$dest_city.'\'
						ORDER BY departure_time ASC, depth';

				$query = $this->db->query($sql);
				$paths = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $path = $query->fetchArray()){
					array_push($paths, $path);
				}

				$results = [];
				foreach( $paths as $key => $value ) {
					$nums = trim($value['previous_flight'], "{}");
					$nums = explode(',', $nums);
					$flights = '';
					for($i = 0; $i < count($nums); $i++) {
						$flights .= 'SELECT '.($i+1).'::INT AS "#", flight_number, departure_city, destination_city, departure_time, arrival_time FROM flight
									WHERE flight_number = '.$nums[$i];
						if( $i < count($nums)-1 ) {
							$flights .= ' UNION ';
						} else {
							$flights .= ' ORDER BY "#";';
						}
					}

					$query = $this->db->query($flights);
					$temp = [];
					$query->setFetchMode(PhalconDb::FETCH_ASSOC);
					while( $t = $query->fetchArray()){
						array_push($temp, $t);
					}
					array_push($results, $temp);
				}

			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Threec");
		$this->view->results = $results;
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////


	public function threedAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$depart_city = $this->request->getPost('depart_city');
			$dest_city = $this->request->getPost('dest_city');
			$via_city = $this->request->getPost('via_city');


			if( $depart_city !== "" && $dest_city !== "" && $via_city !== "" && $depart_city !== $dest_city) {

				$sql = 'WITH RECURSIVE reaches(flight_number,departure_city,destination_city,mileage,airfare,departure_time,arrival_time,flight_time,stopover,total_time, depth) AS (
							SELECT flight_number,departure_city,destination_city,mileage,airfare,departure_time,arrival_time
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS flight_time
							, 0::INT AS stopover
							, ((arrival_time/100 - departure_time/100) * 60) + (arrival_time%100 - departure_time%100) AS total_time
							, 1::INT AS depth
							,NULL::INT[] || flight_number AS previous_flight FROM flight 
							WHERE departure_city = \''.$depart_city.'\'
							UNION ALL
							SELECT f.flight_number,f.departure_city, f.destination_city,f.mileage+r.mileage,f.airfare+r.airfare
							,r.departure_time,f.arrival_time
							, r.flight_time + 
							((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) AS flight_time
							, r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS stopover
							, r.flight_time + ((f.arrival_time/100 - f.departure_time/100) * 60) + (f.arrival_time%100 - f.departure_time%100) 
							+ r.stopover +
							CASE WHEN f.departure_time > r.arrival_time 
							THEN ((f.departure_time/100 - r.arrival_time/100) * 60) + (f.departure_time%100 - r.arrival_time%100)
							ELSE ((23 - @(f.departure_time/100 - r.arrival_time/100)) * 60) + @(f.departure_time%100 - r.arrival_time%100)
							END AS total_time
							, r.depth+1 AS depth, 
							r.previous_flight || f.flight_number AS previous_flight FROM flight f
							JOIN reaches r ON f.departure_city = r.destination_city
						)

						SELECT DISTINCT previous_flight, depth, departure_time
						FROM reaches r1
						WHERE destination_city = \''.$dest_city.'\'
						ORDER BY departure_time ASC, depth';

				$query = $this->db->query($sql);
				$paths = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $path = $query->fetchArray()){
					array_push($paths, $path);
				}

				$cityFlights = [];
				$allNums = [];
				foreach( $paths as $key => $value ) {
					$nums = trim($value['previous_flight'], "{}");
					$allNums = array_merge($allNums, explode(',', $nums) );
				}
				array_unique($allNums);

				$flights = '';
				$flights .= 'SELECT DISTINCT flight_number FROM (';
				for($i = 0; $i < count($allNums); $i++) {
				
					$flights .= 'SELECT '.($i+1).'::INT AS "#", flight_number, departure_city, destination_city, departure_time, arrival_time FROM flight
								WHERE flight_number = '.$allNums[$i].'
								AND destination_city = \''.$via_city.'\'';
					if( $i < count($allNums)-1 ) {
						$flights .= ' UNION ';
					}
				}
				$flights .= ') AS FOO';

				$query = $this->db->query($flights);
				$temp = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($temp, $t);
				}
				foreach($temp as $key => $value){
					array_push($cityFlights, $value['flight_number']);
				}


				$results = [];
				$passengers = '';
				for($i = 0; $i < count($cityFlights); $i++) {
					$passengers .= 'SELECT "name", booked_flight AS booked_flights FROM passenger
									WHERE booked_flight @> \'{'.$cityFlights[$i].'}\'';
					if( $i < count($cityFlights)-1 ) {
						$passengers .= ' UNION ';
					}
				}

				$query = $this->db->query($passengers);
				$temp = [];
				$query->setFetchMode(PhalconDb::FETCH_ASSOC);
				while( $t = $query->fetchArray()){
					array_push($temp, $t);
				}
				array_push($results, $temp);

			} else {
				$bad = true;
			}

		} else {
			$bad = true;
		}

		if($bad){
			return $this->dispatcher->forward(array(
				'controller' => 'query',
				'action' => 'invalid'
			));
		}

		$this->view->pick("query/Threed");
		$this->view->results = $results;
	}

}






