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
class Omeka_Controller_Action_Helper_CollectionImage extends Zend_Controller_Action_Helper_Abstract
{    
    private $_originalsPath;    // Path to originals images
    private $_thumbmailsPath;   // Path to thumbmails images
    private $_slidersPath;      // Path to thumbmails images

    private $_originalsUrl;     // Url of originals images folder
    private $_thumbmailsUrl;    // Url of thumbmails images folder
    private $_sliderssUrl;      // Url of thumbmails images folder
    
    private $_record; // The record pass to the helper


    public function __construct($record)
    {
        $this->originalsPath    = FILES_DIR . '/collections/originals/';
        $this->thumbmailsPath   = FILES_DIR . '/collections/thumbmails/';
        $this->slidersPath      = FILES_DIR . '/collections/sliders/';

        $this->originalsUrl     = WEB_ROOT . '/files/collections/originals/';
        $this->thumbmailsUrl    = WEB_ROOT . '/files/collections/thumbmails/';
        $this->slidersUrl       = WEB_ROOT . '/files/collections/sliders/';

        $this->record = $record;
    }

    /**
     * getThumbmail() - Get the URL of the thumbmail's image
     *
     * @return string The full URL of the image (/thumbmail)
     */
    public function getThumbmail() {

        $thumbmail = $this->thumbmailsPath.$this->record->id.'.jpg';

        if (file_exists($thumbmail)) {
            return $this->thumbmailsUrl.$this->record->id.'.jpg';
        }
        return false;
    }

    /**
     * getOriginal() - Get the URL of the original's image
     *
     * @return string The full URL of the image (/originals)
     */
    public function getOriginal() {

        $original = $this->originalsPath.$this->record->id.'.jpg';

        if (file_exists($original)) {
            return $this->originalsUrl.$this->record->id.'.jpg';
        }
        return false;
    }


    /**
     * getSlider() - Get the URL of the slider's image
     *
     * @return string The full URL of the image (/sliders)
     */
    public function getSlider() {

        $slider = $this->slidersPath.$this->record->id.'.jpg';

        if (file_exists($slider)) {
            return $this->slidersUrl.$this->record->id.'.jpg';
        }
        return false;
        
    }

    /**
     * addImage() - Attach an image to a collection
     *
     * @param  array $files The POST $_FILES array retrieve from the form
     * @return string The full path of the image (originals)
     */
    public function addImage($files) {

        $flashMessenger = new Omeka_Controller_Action_Helper_FlashMessenger();

        if (strlen(trim($files['collection-thumbmail']['tmp_name'])) > 0 ) 
        {
            // Validate image format
            $type = $files['collection-thumbmail']['type'];
            $size = $files['collection-thumbmail']['size'];
            $error = 0;
    
            if ($type != 'image/jpg' && $type != 'image/jpeg') {
                $flashMessenger->addMessage("L'image doit avoir l'extension .jpg ou .jpeg", 'error');
                $error++;
            } else if ($size >= 1000000) {
                $flashMessenger->addMessage("L'image doit faire moins de 1Mo", 'error');
                $error++;
            } else {
                $image_info = getimagesize($files['collection-thumbmail']["tmp_name"]);
                if( $image_info[0] != 750 && $image_info[1] != 500) {  
                    $flashMessenger->addMessage("La taille de l'image doit être de 750x500 pixels.", 'error');
                    $error++;
                }
            }

            // Store the uploaded file on server
            if ($error == 0) {
                $filesPath = BASE_DIR . '/files/collections'; 
                $fileName  = $this->record->id . '.jpg';
                $fullPath = $filesPath . '/originals/'.$fileName;
                $stored  = move_uploaded_file($files['collection-thumbmail']['tmp_name'], $fullPath);
                if ($stored != 1) {
                    $flashMessenger->addMessage("Erreur lors du stockage de l'image sur le serveur.", 'error');
                } else {
                    
                    // Generate the thumbmail
                    $convertPath = Omeka_File_Derivative_Strategy_ExternalImageMagick::getDefaultImageMagickDir();
                    $convertCommand = Omeka_File_Derivative_Strategy_ExternalImageMagick::IMAGEMAGICK_CONVERT_COMMAND;
                    $cmd = $convertPath .'/'. $convertCommand .' '.  $fullPath .' -resize 100 '. $filesPath . '/thumbmails/' . $fileName. ' &';
                    exec($cmd);
                }
                return $fullPath;
            }
        }    
    }


    /**
     * addToSlider() - Attach an image to the homepage's slider (create it in the /slider folder)
     *
     * @param  string $add (yes|null) Whether or not add the image to the homepage slider (from the checkbox of the edit form)
     * @param  string $imageAdded If filled, an image
     * @return true|false
     */
    public function addToSlider($add = null) 
    {
        if($add == 'yes' && $this->getOriginal()) {
            echo $cmd = "cp ".$this->originalsPath.$this->record->id.'.jpg '. $this->slidersPath.$this->record->id.'.jpg';
            exec($cmd);
            return true;
        } else if ($this->getSlider()) {
            echo $cmd = "rm ".$this->slidersPath.$this->record->id.'.jpg';
            exec($cmd);
            return true;
        }
        return false;
    }
    
    /**
     * deleteImage() - Delete an image (from the 3 directories)
     */
    public function deleteImage() 
    {
        if ($this->getOriginal())
            exec("rm ".$this->originalsPath.$this->record->id.'.jpg');
        if ($this->getThumbmail())
            exec("rm ".$this->thumbmailsPath.$this->record->id.'.jpg');
        if ($this->getSlider())
            exec("rm ".$this->slidersPath.$this->record->id.'.jpg');
    }    

    /**
     * getSliderImages() - Retrieve an array of collection IDs appearing on homepage slider
     *
     * @return array List of collection's IDs
     */
    public static function getSliderImages() 
    {
        $folder = FILES_DIR . '/collections/sliders/';
        $array = array_diff(scandir($folder), array('..', '.'));

        foreach($array as $a)
            $res[] = rtrim($a, '.jpg');
        
        return $res;
    }

            
}
