<?php
/**
 * Omeka
 * 
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * View Helper that returns the icon name for given file (based on mime_type)
 * 
 * 
 * @package Omeka\View\Helper
 */
class Omeka_View_Helper_FileIcon extends Zend_View_Helper_Abstract
{   

    static protected $_icons = array(
        'audio'         => 'audio.png',
        'video'         => 'video.png',
        'image'         => 'image.png',
        'text'          => 'text.png',
        'msword'        => 'msword.png',
        'zip'           => 'zip.png',
        'pdf'           => 'pdf.png',
        'msoffice'      => 'msoffice.png',
        'openoffice'    => 'openoffice.png',
        'file'          => 'file.png'
    );

    /**
     * Return the icon name (like 'image.png' or 'pdf.png') for a given mime type
     * For example : if mime_type = 'application/pdf', the function returns 'pdf.png'
     *
     * @param String $mimeType The mime type
     * @param String $returnGeneric Wheter or not return a generic file (if false, the function returns false, else the function return a generic icon name)
     * @return String the name of the icon
     */        
    static function getIcon($mimeType, $returnGeneric = false) {
        
        $valid = self::_getValidIconType($mimeType);

        if (!$valid) {
            return $valid;
        } elseif($returnGeneric) {
            return self::_getGenericIcon();
        } else {
            return false;
        }
    }


    /**
     * Return the icon type (like 'pdf' or 'image') for a given mime type
     *
     * @param String $mimeType The mime type
     * @return String|false the name of the icon
     */    
    private function _getValidIconType($mimeType) {

        $type = explode('/', $mimeType);
        $category = $type[0];
        $details = $type[1];

        switch ($category) {
            case 'audio':
            case 'video':
            case 'image':
            case 'text':
                return $category;
                break;

            case 'application':
                switch ($details) {
                    case 'msword':
                        return 'word';
                        break;
                    case 'zip':
                    case 'x-tar':
                    case 'x-gzip':
                        return 'zip';
                        break;
                    case 'rtf':
                        return 'text';
                        break;                                                
                    case 'pdf':
                        return 'pdf';
                        break;   
                    default:
                        if(substr($details,0,7) == 'vnd.ms-')
                            return 'msoffice';
                        elseif(substr($details,0,10) == 'vnd.oasis.')
                            return 'openoffice';
                        else 
                            return false;
                        break;
                }
                break;
            
            default:
                return false;
                break;
        }
        return false;
    }


    /**
     * Return the icon type (like 'pdf' or 'image') for a given mime type
     *
     * @param String $mimeType The mime type
     * @return String|false the name of the icon
     */    
    private function _getGenericIcon() {
        return 'file.png';
    }


}
