<?php 
/*
 * Flux Flow
 * Copyright (C) 2017  Joao L. Ribeiro da Silva <joao.r.silva@gmail.com>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Fluxflow\Modules\Api\Controllers;

use Phalcon\Http\Response;
use Fluxflow\Modules\Api\Models\ZhistCntAddresses;

class ZhistcntaddressesController extends ControllerBase 
{
    /*
     * Valid url parameters for get action
     */
    private $validParams = array(
        '_url',
        'pagging',
        'filter',
        'order'
    );
    
    /*
     * Id of the user performing the operation
     */
    private $userId = 1;
    
    /**
     * Initialize the controller once
     */
    public function initialize()
    {
        parent::initialize(__CLASS__);
    }

    /**
     * After real __construct()
     */
    public function onConstruct()
    {
        $auth = $this->session->get('auth');
        if($auth && isset($auth['user']))
            $this->userId = $auth['user']->id;
    }

    /**
     * getAction() 
     * HTTP method GET 
     * Returns resources according to parameters
     */
    public function getAction($id)
    {
        $requestSetting = array();
        $data = array();
        
        if( !$this->validateParams( $this->request->getQuery(), $this->validParams ) )
             $code = 400;
        
        if($id)
        {
            //Single record
            $record = ZhistCntAddresses::findFirst($id);
            if( !$record) 
                $code = 404;
            else
            {
                $code = 200;
                $data = ["data" => $record->toArray()];
            }
        }
        else 
        {
            //Recordset to find
            $requestSetting = $this->parseSettings( $this->request, ZhistCntAddresses );
            
            $struct = ZhistCntAddresses::findStructured($requestSetting);

            if( count($struct['result']) == 0)
                $code = 404;
            else
            {
                $code = 200;
                $data = ["data" => $struct];    
            }
        }
        
        return $this->sendResponse($code,$data);        
    }
    
    /**
     * newAction()
     * HTTP method POST 
     * Creates a new resource
     */
    public function newAction()
    {
        
        $data = array();
        
        $post = $this->request->getJsonRawBody(TRUE);
        if( 
            !$post
        ) 
            $code = 400;
        
        $resource = new ZhistCntAddresses();
        $resource->setUserId($this->userId);
        if(array_key_exists('original_id',$post))
        {
            if($post['original_id'] === "NULL")
            {
                $resource->original_id = NULL;
            }
            else 
            {
                $resource->original_id = $post['original_id'];
            }
        }
        if(array_key_exists('unit_organizations_id',$post))
        {
            if($post['unit_organizations_id'] === "NULL")
            {
                $resource->unit_organizations_id = NULL;
            }
            else 
            {
                $resource->unit_organizations_id = $post['unit_organizations_id'];
            }
        }
        if(array_key_exists('cnt_contacts_id',$post))
        {
            if($post['cnt_contacts_id'] === "NULL")
            {
                $resource->cnt_contacts_id = NULL;
            }
            else 
            {
                $resource->cnt_contacts_id = $post['cnt_contacts_id'];
            }
        }
        if(array_key_exists('cnt_contact_types_id',$post))
        {
            if($post['cnt_contact_types_id'] === "NULL")
            {
                $resource->cnt_contact_types_id = NULL;
            }
            else 
            {
                $resource->cnt_contact_types_id = $post['cnt_contact_types_id'];
            }
        }
        if(array_key_exists('geo_countries_id',$post))
        {
            if($post['geo_countries_id'] === "NULL")
            {
                $resource->geo_countries_id = NULL;
            }
            else 
            {
                $resource->geo_countries_id = $post['geo_countries_id'];
            }
        }
        if(array_key_exists('geo_provinces_id',$post))
        {
            if($post['geo_provinces_id'] === "NULL")
            {
                $resource->geo_provinces_id = NULL;
            }
            else 
            {
                $resource->geo_provinces_id = $post['geo_provinces_id'];
            }
        }
        if(array_key_exists('geo_cities_id',$post))
        {
            if($post['geo_cities_id'] === "NULL")
            {
                $resource->geo_cities_id = NULL;
            }
            else 
            {
                $resource->geo_cities_id = $post['geo_cities_id'];
            }
        }
        if(array_key_exists('neigborhood',$post))
        {
            if($post['neigborhood'] === "NULL")
            {
                $resource->neigborhood = NULL;
            }
            else 
            {
                $resource->neigborhood = $post['neigborhood'];
            }
        }
        if(array_key_exists('zip_code',$post))
        {
            if($post['zip_code'] === "NULL")
            {
                $resource->zip_code = NULL;
            }
            else 
            {
                $resource->zip_code = $post['zip_code'];
            }
        }
        if(array_key_exists('street_address',$post))
        {
            if($post['street_address'] === "NULL")
            {
                $resource->street_address = NULL;
            }
            else 
            {
                $resource->street_address = $post['street_address'];
            }
        }
        if(array_key_exists('door_number',$post))
        {
            if($post['door_number'] === "NULL")
            {
                $resource->door_number = NULL;
            }
            else 
            {
                $resource->door_number = $post['door_number'];
            }
        }
        if(array_key_exists('room',$post))
        {
            if($post['room'] === "NULL")
            {
                $resource->room = NULL;
            }
            else 
            {
                $resource->room = $post['room'];
            }
        }
        $resource->active = 1;
        
        if( isset($post['active']) )
        {
            $resource->active = $post['active'];
        }
        
        if( $resource->create() === FALSE)
        {
            $code = 400;
            $data = ['messages'  => $resource->getMessages()];
        }
        else 
        {
            if( !$resource->id ) $code = 500;
            else 
            {
                $code = 201;
                $data = ['data' => $resource->toArray()];
            }
        }
        
        return $this->sendResponse($code,$data); 
    }

    /**
     * updateAction()
     * HTTP method PUT 
     * Updates a resource
     */
    public function updateAction($id)
    {
        $data = array();
        $post = $this->request->getJsonRawBody(TRUE);
        if( 
            !$post 
        )
            $code = 400;
        
        $resource = ZhistCntAddresses::findFirst($id);
        if( !$record )
            $code = 404;
        else 
        {
            $record->setUserId($this->userId);
            if(array_key_exists('original_id',$post))
            {
                if($post['original_id'] === "NULL")
                {
                    $resource->original_id = NULL;
                }
                else 
                {
                    $resource->original_id = $post['original_id'];
                }
            }
            if(array_key_exists('unit_organizations_id',$post))
            {
                if($post['unit_organizations_id'] === "NULL")
                {
                    $resource->unit_organizations_id = NULL;
                }
                else 
                {
                    $resource->unit_organizations_id = $post['unit_organizations_id'];
                }
            }
            if(array_key_exists('cnt_contacts_id',$post))
            {
                if($post['cnt_contacts_id'] === "NULL")
                {
                    $resource->cnt_contacts_id = NULL;
                }
                else 
                {
                    $resource->cnt_contacts_id = $post['cnt_contacts_id'];
                }
            }
            if(array_key_exists('cnt_contact_types_id',$post))
            {
                if($post['cnt_contact_types_id'] === "NULL")
                {
                    $resource->cnt_contact_types_id = NULL;
                }
                else 
                {
                    $resource->cnt_contact_types_id = $post['cnt_contact_types_id'];
                }
            }
            if(array_key_exists('geo_countries_id',$post))
            {
                if($post['geo_countries_id'] === "NULL")
                {
                    $resource->geo_countries_id = NULL;
                }
                else 
                {
                    $resource->geo_countries_id = $post['geo_countries_id'];
                }
            }
            if(array_key_exists('geo_provinces_id',$post))
            {
                if($post['geo_provinces_id'] === "NULL")
                {
                    $resource->geo_provinces_id = NULL;
                }
                else 
                {
                    $resource->geo_provinces_id = $post['geo_provinces_id'];
                }
            }
            if(array_key_exists('geo_cities_id',$post))
            {
                if($post['geo_cities_id'] === "NULL")
                {
                    $resource->geo_cities_id = NULL;
                }
                else 
                {
                    $resource->geo_cities_id = $post['geo_cities_id'];
                }
            }
            if(array_key_exists('neigborhood',$post))
            {
                if($post['neigborhood'] === "NULL")
                {
                    $resource->neigborhood = NULL;
                }
                else 
                {
                    $resource->neigborhood = $post['neigborhood'];
                }
            }
            if(array_key_exists('zip_code',$post))
            {
                if($post['zip_code'] === "NULL")
                {
                    $resource->zip_code = NULL;
                }
                else 
                {
                    $resource->zip_code = $post['zip_code'];
                }
            }
            if(array_key_exists('street_address',$post))
            {
                if($post['street_address'] === "NULL")
                {
                    $resource->street_address = NULL;
                }
                else 
                {
                    $resource->street_address = $post['street_address'];
                }
            }
            if(array_key_exists('door_number',$post))
            {
                if($post['door_number'] === "NULL")
                {
                    $resource->door_number = NULL;
                }
                else 
                {
                    $resource->door_number = $post['door_number'];
                }
            }
            if(array_key_exists('room',$post))
            {
                if($post['room'] === "NULL")
                {
                    $resource->room = NULL;
                }
                else 
                {
                    $resource->room = $post['room'];
                }
            }
            if( isset($post['active']) )
            {
                $resource->active = $post['active'];
            }
            
            if( $resource->update() === FALSE )
            {
                $code = 400;
                $data = ['messages' => $resource->getMessages()];         
            } 
            else 
            {
                $code = 200;
                $data = ['data' => $resource->toArray()];
            }
        }
        
        return $this->sendResponse($code,$data);         
    }


    /**
     * deleteAction()
     * HTTP method DELETE 
     * Deletes a resource
     */
    public function deleteAction($id)
    {
        $data = array();
        if( !$id )
            $code = 400;
        else 
        {
            $record = ZhistCntAddresses::findFirst($id);
            if( ! $record )
                $code = 404;
            else 
            {
                $record->setUserId($this->userId);
                $record->deleted = 1;
                if ( $record->save() == FALSE )
                    $code = 500;
                else 
                    $code = 200;
            }
        }
        
        return $this->sendResponse($code,$data); 
    }
    

    /**
     * indexAction()
     * HTTP method OPTIONS 
     * Returns the controller API documentation and HTTP Header options
     */
    public function indexAction()
    {
        $data = array();
        
        $docFile = __DIR__ . "/docs/ZhistcntaddressesController.php";
        if(file_exists($docFile)) {
            include $docFile;
        }
                $response = new Response();
        $response->setStatusCode(200);
        $response->setHeader("Allow", "GET,POST,PUT,DELETE,OPTIONS");
        $response->setJsonContent($data, JSON_FORCE_OBJECT);
        
        return $response;
    }

}
