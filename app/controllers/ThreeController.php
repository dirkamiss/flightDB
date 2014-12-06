<?php
namespace flightDB\Controllers;

/**
 * Display the default index page.
 */
class ThreeController extends ControllerBase
{

	public function initialize()
	{
		$this->view->setTemplateBefore('public');
	}

	/**
	 * Default action. Set the public layout (layouts/public.volt)
	 */
	public function indexAction()
	{
		$depart_cities = $this->modelsManager->executeQuery('SELECT DISTINCT departure_city FROM flightDB\Models\Flight ORDER BY 1')->toArray();
		$dest_cities = $this->modelsManager->executeQuery('SELECT DISTINCT destination_city FROM flightDB\Models\Flight ORDER BY 1')->toArray();



		$this->view->depart_cities = $depart_cities;
		$this->view->dest_cities = $dest_cities;
	}
}
