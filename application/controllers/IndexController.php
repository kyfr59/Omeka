<?php
/**
 * Omeka
 * 
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * @package Omeka\Controller
 */
class IndexController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
    	// Retrieve slider images
		$collectionImageHelper = new $this->_helper->collectionImage();
		$this->view->sliderImages = $collectionImageHelper::getSliderImages();

		// Set default model name
		$this->_helper->db->setDefaultModelName('Collection');

		// Retrieve slider collection's infos in database
		foreach($this->view->sliderImages as $collectionId) {
			$record = $this->_helper->db->find($collectionId);
			if(count($record) > 0)	{
				$record['image_url'] = WEB_ROOT . '/files/collections/originals/'.$record->id.'.jpg'; // Adding the path of image
				$collections[] = $record;
			}
		}

		$this->view->collections = $collections;

		$this->_helper->viewRenderer->renderScript('index.php');
    }
}
