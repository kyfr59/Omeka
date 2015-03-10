<?php
/**
 * Omeka
 * 
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * Set up the default database connection for Omeka.
 * 
 * @package Omeka\Application\Resource
 */


class Omeka_Application_Resource_AtomDb
{
    
    private $_atomDb;

    const PHANTOMJS_DIR = '/usr/bin'; // PhantomJS exec path

    /**
     * @return Omeka_Db
     */
    public function __construct()
    {
        $dbFile = BASE_DIR . '/db.ini';
                
        if (!file_exists($dbFile)) {
            throw new Zend_Config_Exception('Your Omeka database configuration file is missing.');
        }
        
        if (!is_readable($dbFile)) {
            throw new Zend_Config_Exception('Your Omeka database configuration file cannot be read by the application.');
        }
        
        $dbIni = new Zend_Config_Ini($dbFile, 'atom');
        
        // Fail on improperly configured db.ini file
        if (!isset($dbIni->host) || ($dbIni->host == 'XXXXXXX')) {
            throw new Zend_Config_Exception('Your Omeka database configuration file has not been set up properly.  Please edit the configuration and reload this page.');
        }
        
        $connectionParams = $dbIni->toArray();
        // dbname aliased to 'name' for backwards-compatibility.
        if (array_key_exists('name', $connectionParams)) {
            $connectionParams['dbname'] = $connectionParams['name'];
        }

        $parameters = array(
                    'host'     => $dbIni->host,
                    'username' => $dbIni->username,
                    'password' => $dbIni->password,
                    'dbname'   => $dbIni->dbname
                   );
       
        try {
            $atomDb = Zend_Db::factory('Pdo_Mysql', $parameters);
            $atomDb->getConnection();
        } catch (Zend_Db_Adapter_Exception $e) {
            echo $e->getMessage();
            die('Could not connect to database.');
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
            die('Could not connect to database.');
        }
        Zend_Registry::set('atomDb', $atomDb);
        $this->_atomDb = Zend_Registry::get('atomDb');
    }


    public function updateRecord($filename, $item) {
        
        $addDigitalObjectUrl = $this->_getAddDigitalObjectUrl($item);

        if (isset($filename) && isset($addDigitalObjectUrl)) 
        {
            // var $doc = WEB_FILES . '/original/' . $filename;
            var $doc = 'http://documents.studens.info/files/original/246d72de5069928d68812556e8ce7e24.pdf';

            $cmd = self::PHANTOMJS_DIR.'/phantomjs '.BASE_DIR.'/updateAtom.js '.$addDigitalObjectUrl. ' '.$doc;
            $output = shell_exec($cmd);
            
            $query = "UPDATE  information_object SET  description_identifier =  '".$url."' WHERE id = 445";
            $this->_atomDb->getConnection()->exec($query);

            return $output;
        }    
    }    

    public function _getAddDigitalObjectUrl($item) {

        $itemInfos = $item->getElementTexts('Dublin Core','Relation');
        $url = $itemInfos[0]['text'];
        if( isset($url) && strlen(trim($url))>0 )
            return $url.'/addDigitalObject';
        return false;
    }
    
    
}
