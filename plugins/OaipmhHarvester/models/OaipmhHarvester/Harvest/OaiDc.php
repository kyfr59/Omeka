<?php
/**
 * @package OaipmhHarvester
 * @subpackage Models
 * @copyright Copyright (c) 2009-2011 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Metadata format map for the required oai_dc Dublin Core format
 *
 * @package OaipmhHarvester
 * @subpackage Models
 */
class OaipmhHarvester_Harvest_OaiDc extends OaipmhHarvester_Harvest_Abstract
{
    /*  XML schema and OAI prefix for the format represented by this class.
        These constants are required for all maps. */
    const METADATA_SCHEMA = 'http://www.openarchives.org/OAI/2.0/oai_dc.xsd';
    const METADATA_PREFIX = 'oai_dc';

    const OAI_DC_NAMESPACE = 'http://www.openarchives.org/OAI/2.0/oai_dc/';
    const DUBLIN_CORE_NAMESPACE = 'http://purl.org/dc/elements/1.1/';

    const FONDS_ITEM_TYPE = 18; // ID of the 'fonds' item type, created with the interface (table omeka_items_type)

    /**
     * Collection to insert items into.
     * @var Collection
     */
    protected $_collection;
    
    /**
     * Actions to be carried out before the harvest of any items begins.
     */
     protected function _beforeHarvest()
    {
        /*
        $harvest = $this->_getHarvest();

        $collectionMetadata = array(
            'metadata' => array(
                'public' => $this->getOption('public'),
                'featured' => $this->getOption('featured'),
            ),);
        $collectionMetadata['elementTexts']['Dublin Core']['Title'][]
            = array('text' => (string) "set_Title", 'html' => false); 
        $collectionMetadata['elementTexts']['Dublin Core']['Description'][]
            = array('text' => (string) "set_Description", 'html' => false); 
        
        $this->_collection = $this->_insertCollection($collectionMetadata);
        */
    }

    /**
     * Actions to be carried out after the harvest of items ends.
     * Here we rebuild the initial hierarchy of ATOM elements in OMEKA (with the ITEMS-RELATION plugin)
     */
    protected function _afterHarvest()
    {
        $insertedItems = $this->_parentCorrespondance;

        if (count($insertedItems) == 0)
            return;

        // $this->_addStatusMessage( print_r($insertedItems, 1) ); // Debug

        foreach ($insertedItems as $atomId => $tab) {
            
            // Mapping of fields
            $atomId             = $atomId;
            $atomTopParentId    = $tab['atomTopParentId'];
            $atomTopParentUrl   = $tab['atomTopParentUrl'];
            $omekaId            = $tab['newId'];
            $omekaTopParentId   = $insertedItems[$atomTopParentId]['newId'];
            if (strlen(trim($omekaTopParentId)) == 0 && strlen(trim($atomTopParentUrl)) > 0)  {
                
                $e = get_db()->getTable('ElementText')->findBy(array('text' => $atomTopParentUrl));
                $omekaTopParentId = $e[0]->record_id;
            }
            if ($omekaId > 0 && $omekaTopParentId > 0)
            {   
                $existingRelation = get_db()->getTable('ItemRelationsRelation')->findBy( array('object_item_id' => $omekaTopParentId, 'subject_item_id' => $omekaId) );
                
                if (count($existingRelation) == 0) {
                    ItemRelationsPlugin::insertItemRelation($omekaId, 7, $omekaTopParentId);
                    // $val .= "L'archive ATOM ".$atomId." a été insérée sous OMEKA ".$omekaId." et à comme parent : ".$atomTopParentId." (soit ".$omekaTopParentId." OMEKA)\r\n"; // Debug
                    // $this->_addStatusMessage( count($existingRelation) ); // Debug
                }    
            } 
        }
        
    }

    
    /**
     * Harvest one record.
     *
     * @param SimpleXMLIterator $record XML metadata record
     * @return array Array of item-level, element texts and file metadata.
     */
    protected function _harvestRecord($record)
    {
        $itemMetadata = array(
            'collection_id' => $this->_collection->id, 
            'public'        => $this->getOption('public'), 
            'featured'      => $this->getOption('featured'),
            'item_type_id'  => null,
        );

        $dcMetadata = $record
                    ->metadata
                    ->children(self::OAI_DC_NAMESPACE)
                    ->children(self::DUBLIN_CORE_NAMESPACE);

        $elementTexts = array();
        $elements = array('contributor', 'coverage', 'creator', 
                          'date', 'description', 'format', 
                          'identifier', 'language', 'publisher', 
                          'relation', 'rights', 'source', 
                          'subject', 'title', 'type');

        foreach ($elements as $element) {
            if (isset($dcMetadata->$element)) {
                foreach ($dcMetadata->$element as $rawText) {
                    $text = trim($rawText);
                    $elementTexts['Dublin Core'][ucwords($element)][] 
                        = array('text' => (string) $text, 'html' => false);
                }
            }
        }

        /* ISAD/AV Importation BEGIN */

        // Import ATOM 'itemTypeMetadata' field to OMEKA 'itemTypeMetadata' field (with a correspondance)
        if (isset($dcMetadata->itemTypeMetadata) && !empty($dcMetadata->itemTypeMetadata)) {

            $itemTypeMetadataChoices =  array(  'INTERACTIVE_RESOURCE'  => 13,
                                                'MOVING_IMAGE'          => 3,
                                                'STILL_IMAGE'           => 6,
                                                'TEXT'                  => 1,
                                                'SOUND'                 => 5,
                                                'ORAL_HISTORY'          => 4);

            if (array_key_exists((string)$dcMetadata->itemTypeMetadata, $itemTypeMetadataChoices)) {
                $itemMetadata['item_type_id'] = $itemTypeMetadataChoices[(string)$dcMetadata->itemTypeMetadata];

            }      
        }   

        // If 'levelOfDescription' = 'fonds' on ATOM, put 'fonds' for 'itemTypeMetadata' OMEKA field
        if ( !empty($dcMetadata->levelOfDescription) && $dcMetadata->levelOfDescription == 'fonds') {
            $itemMetadata['item_type_id'] = self::FONDS_ITEM_TYPE;
            $elementTexts['Item Type Metadata']['Type de fonds'][] = array('text' => 'Fonds', 'html' => false); 
        } else if ( !empty($dcMetadata->levelOfDescription) && $dcMetadata->levelOfDescription == 'collection') {
            $itemMetadata['item_type_id'] = self::FONDS_ITEM_TYPE;
            $elementTexts['Item Type Metadata']['Type de fonds'][] = array('text' => 'Collection archivistique', 'html' => false); 
        }

        // Clean the 'Identifier' field in OMEKA (to remove the 'identifier' value of ATOM DC)
        unset($elementTexts['Dublin Core']['Identifier']);

        // Import ATOM 'identifierName' field to OMEKA 'identifier' field
        if(isset($dcMetadata->identifierName) && !empty($dcMetadata->identifierName))
            $elementTexts['Dublin Core']['Identifier'][] 
                = array('text' => (string) trim($dcMetadata->identifierName), 'html' => false); 


        // Import ATOM 'identifierUrl' field to OMEKA 'relation' field
        unset($elementTexts['Dublin Core']['Relation']);
        if(isset($dcMetadata->identifierUrl) && !empty($dcMetadata->identifierUrl))
            $elementTexts['Dublin Core']['Relation'][] 
                = array('text' => (string) trim($dcMetadata->identifierUrl), 'html' => false); 


        // Import ATOM 'descriptionIdentifier' field to OMEKA 'source' field
        unset($elementTexts['Dublin Core']['Source']);
        if(isset($dcMetadata->descriptionIdentifier) && !empty($dcMetadata->descriptionIdentifier))
            $elementTexts['Dublin Core']['Source'][] 
                = array('text' => (string) trim($dcMetadata->descriptionIdentifier), 'html' => false); 



        // Clean the 'Format' field in OMEKA (to remove the 'format' value of ATOM DC)
        unset($elementTexts['Dublin Core']['Format']);

        // Import ATOM 'physicalFormat' field to OMEKA 'format' field
        if (isset($dcMetadata->physicalFormat)) {
            foreach($dcMetadata->physicalFormat as $physicalFormat) {
                if (strlen(trim($physicalFormat)) > 0) {
                    $elementTexts['Dublin Core']['Format'][] 
                        = array('text' => (string) trim($physicalFormat->item), 'html' => false);
                }
            }
        }

        // Import ATOM 'digitalFormat' field to OMEKA 'format' field
        if (isset($dcMetadata->digitalFormat)) {
            foreach($dcMetadata->digitalFormat as $digitalFormat) {
                if (strlen(trim($digitalFormat)) > 0) {
                    $elementTexts['Dublin Core']['Format'][] 
                        = array('text' => (string) trim($digitalFormat->item), 'html' => false);
                }
            }
        }   

        // Import ATOM 'creators & roles' fields to OMEKA 'creators' field
        if (isset($dcMetadata->creators) && count($dcMetadata->creators->creator) > 0) {
            foreach($dcMetadata->creators->creator as $creator) {
                $elementTexts['Dublin Core']['Creator'][] 
                    = array('text' => (string) trim($creator->name. ' ('.$creator->role.')'), 'html' => false);
            }
        }    


        // MAPPING FOR MOVING_IMAGE

        if (isset($dcMetadata->itemTypeMetadata) && $dcMetadata->itemTypeMetadata == MOVING_IMAGE) {

            // Import ATOM 'contributors & roles' fields to OMEKA 'producer' and 'director' or 'contributor' fields
            if (isset($dcMetadata->contributors) && count($dcMetadata->contributors->contributor) > 0) {
                foreach($dcMetadata->contributors->contributor as $contributor) {
                    if (strtolower($contributor->role) == 'director') {
                        $elementTexts['Item Type Metadata']['Director'][] 
                            = array('text' => (string) trim($contributor->name), 'html' => false);
                    } else if (strtolower($contributor->role) == 'producer') {
                        $elementTexts['Item Type Metadata']['Producer'][] 
                            = array('text' => (string) trim($contributor->name), 'html' => false);
                    } else  {
                        $elementTexts['Dublin Core']['Contributor'][] 
                            = array('text' => (string) trim($contributor->name. ' ('.$contributor->role.')'), 'html' => false);    
                    } 
                }
            }    

            // Import ATOM 'duration' field to OMEKA 'duration' field
            if(isset($dcMetadata->duration) && !empty($dcMetadata->duration))
                $elementTexts['Item Type Metadata']['Duration'][] 
                    = array('text' => (string) trim($dcMetadata->duration), 'html' => false); 

            // Import ATOM 'data rate' field to OMEKA 'compression' field
            if(isset($dcMetadata->dataRate) && !empty($dcMetadata->dataRate))
                $elementTexts['Item Type Metadata']['Compression'][] 
                    = array('text' => (string) trim($dcMetadata->dataRate), 'html' => false);           


            // Import ATOM 'extent & medium' field (aka format) to OMEKA 'compression' field
            if(isset($dcMetadata->format) && !empty($dcMetadata->format))
                $elementTexts['Item Type Metadata']['Original Format'][] 
                    = array('text' => (string) trim($dcMetadata->format), 'html' => false); 
        }

        // MAPPING FOR STILL_IMAGE

        if (isset($dcMetadata->itemTypeMetadata) && $dcMetadata->itemTypeMetadata == STILL_IMAGE) {

            // On ATOM DC, 'format' field is 'extent & medium', it's automaticaly insert into 'format' on OMEKA

        }


        // MAPPING FOR SOUND

        if (isset($dcMetadata->itemTypeMetadata) && $dcMetadata->itemTypeMetadata == SOUND) {

            // Import ATOM 'extent & medium' field (aka format) to OMEKA 'format' field
            if(isset($dcMetadata->format) && !empty($dcMetadata->format))
                $elementTexts['Item Type Metadata']['Original Format'][] 
                    = array('text' => (string) trim($dcMetadata->format), 'html' => false); 

            // Import ATOM 'duration' field to OMEKA 'duration' field
            if(isset($dcMetadata->duration) && !empty($dcMetadata->duration))
                $elementTexts['Item Type Metadata']['Duration'][] 
                    = array('text' => (string) trim($dcMetadata->duration), 'html' => false); 

            // Import ATOM 'data rate' field to OMEKA 'compression' field
            if(isset($dcMetadata->dataRate) && !empty($dcMetadata->dataRate))
                $elementTexts['Item Type Metadata']['Bit Rate/Frequency'][] 
                    = array('text' => (string) trim($dcMetadata->dataRate), 'html' => false);           


        }

        // Add the repository name in the item tags & 'Publisher' on OMEKA
        if(isset($dcMetadata->repositoryName) && !empty($dcMetadata->repositoryName)) {
            $tags[] = "Institution : ".$dcMetadata->repositoryName;
            $elementTexts['Dublin Core']['Publisher'][] = array('text' => (string) $dcMetadata->repositoryName, 'html' => false);    

        }

        // Add the name of the parent's collection as tag
        if(isset($dcMetadata->collectionName) && !empty($dcMetadata->collectionName))
            $tags[] = "Collection : ".$dcMetadata->collectionName;

        // Add the subjects as tag
        if (isset($dcMetadata->subjects) && count($dcMetadata->subjects->subject) > 0) {
            foreach($dcMetadata->subjects->subject as $subject) {
                $tags[] = "Sujet : ".$subject;
            }
        }    
       
        $itemMetadata['tags'] = $tags;


        /* ISAD/AV Importation END */

        return array('itemMetadata'     => $itemMetadata,
                     'elementTexts'     => $elementTexts,
                     'fileMetadata'     => array(),
                     'atomId'           => $dcMetadata->atomId,                 // Pass the atomId field to the abstract _harvestLoop() function
                     'atomParentId'     => $dcMetadata->atomParentId,           // Pass the atomParentId field to the abstract _harvestLoop() function
                     'atomTopParentId'  => $dcMetadata->atomTopParentId,        // Pass the atomTopParentId field to the abstract _harvestLoop() function
                     'atomTopParentUrl' => $dcMetadata->atomTopParentUrl);      // Pass the atomTopParentUrl field to the abstract _harvestLoop() function


    }
}
