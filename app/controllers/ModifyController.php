<?php
namespace flightDB\Controllers;
use flightDB\Models\Crew;

/**
 * Display the default index page.
 */
class ModifyController extends ControllerBase
{

	public function initialize()
	{
		$this->view->setTemplateBefore('public');
	}

	/**
	 * Default action. Set the public layout (layouts/public.volt)
	 */
	public function aAction()
	{
		$bad = false;
		if ($this->request->isPost()) {

			$id = $this->request->getPost('id');
			$name = $this->request->getPost('name');
			$salary = $this->request->getPost('salary');
			$position = $this->request->getPost('position');
			$seniority = $this->request->getPost('seniority');
			$hours = $this->request->getPost('hours');
			$supervisor = $this->request->getPost('supervisor');
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

			if (!$crew->save()) {

				$this->flash->error($crew->getMessages());
				return $this->dispatcher->forward(array(
					'controller' => 'four',
					'action' => 'a'
				));
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

		//$this->view->results = $results;
	}
}
