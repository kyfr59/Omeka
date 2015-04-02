<?php
/**
 * Omeka
 * 
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * FlashMessenger action helper.
 * 
 * @package Omeka\Controller\ActionHelper
 */
class Omeka_Controller_Action_Helper_Geolocation extends Zend_Controller_Action_Helper_Abstract
{    
    public function __construct($record)
    {
    }

    public static function hasMap($item_id) {
        $dbHelper = Zend_Controller_Action_HelperBroker::getExistingHelper('Db');
        $location = $dbHelper->getTable('Location')->findBy(array('item_id' => $item_id));
        if (count($location)>0)
            return true;
        return false;
    }
  

            
}
