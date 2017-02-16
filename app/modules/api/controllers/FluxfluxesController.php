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
use Fluxflow\Modules\Api\Models\FluxFluxes;

class FluxfluxesController extends ControllerBase 
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
            $record = FluxFluxes::findFirst($id);
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
            $requestSetting = $this->parseSettings( $this->request, FluxFluxes );
            
            $struct = FluxFluxes::findStructured($requestSetting);

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
            || !isset($post['unit_organizations_id'])
            || !isset($post['flux_origins_id'])
            || !isset($post['flux_status_id'])
            || !isset($post['flux_subjects_id'])
            || !isset($post['flux_boards_id'])
            || !isset($post['flux_steps_id'])
            || !isset($post['flux_priorities_id'])
        ) 
            $code = 400;
        
        $resource = new FluxFluxes();
        $resource->setUserId($this->userId);
        $resource->unit_organizations_id = $post['unit_organizations_id'];
        $resource->flux_origins_id = $post['flux_origins_id'];
        $resource->flux_status_id = $post['flux_status_id'];
        $resource->flux_subjects_id = $post['flux_subjects_id'];
        $resource->flux_boards_id = $post['flux_boards_id'];
        $resource->flux_steps_id = $post['flux_steps_id'];
        if(array_key_exists('owner_id',$post))
        {
            if($post['owner_id'] === "NULL")
            {
                $resource->owner_id = NULL;
            }
            else 
            {
                $resource->owner_id = $post['owner_id'];
            }
        }
        $resource->flux_priorities_id = $post['flux_priorities_id'];
        if(array_key_exists('cnt_contact_id',$post))
        {
            if($post['cnt_contact_id'] === "NULL")
            {
                $resource->cnt_contact_id = NULL;
            }
            else 
            {
                $resource->cnt_contact_id = $post['cnt_contact_id'];
            }
        }
        if(array_key_exists('email',$post))
        {
            if($post['email'] === "NULL")
            {
                $resource->email = NULL;
            }
            else 
            {
                $resource->email = $post['email'];
            }
        }
        if(array_key_exists('phone',$post))
        {
            if($post['phone'] === "NULL")
            {
                $resource->phone = NULL;
            }
            else 
            {
                $resource->phone = $post['phone'];
            }
        }
        if(array_key_exists('other',$post))
        {
            if($post['other'] === "NULL")
            {
                $resource->other = NULL;
            }
            else 
            {
                $resource->other = $post['other'];
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
            || !isset($post['unit_organizations_id'])
            || !isset($post['flux_origins_id'])
            || !isset($post['flux_status_id'])
            || !isset($post['flux_subjects_id'])
            || !isset($post['flux_boards_id'])
            || !isset($post['flux_steps_id'])
            || !isset($post['flux_priorities_id'])
        )
            $code = 400;
        
        $resource = FluxFluxes::findFirst($id);
        if( !$record )
            $code = 404;
        else 
        {
            $record->setUserId($this->userId);
            $resource->unit_organizations_id = $post['unit_organizations_id'];
            $resource->flux_origins_id = $post['flux_origins_id'];
            $resource->flux_status_id = $post['flux_status_id'];
            $resource->flux_subjects_id = $post['flux_subjects_id'];
            $resource->flux_boards_id = $post['flux_boards_id'];
            $resource->flux_steps_id = $post['flux_steps_id'];
            if(array_key_exists('owner_id',$post))
            {
                if($post['owner_id'] === "NULL")
                {
                    $resource->owner_id = NULL;
                }
                else 
                {
                    $resource->owner_id = $post['owner_id'];
                }
            }
            $resource->flux_priorities_id = $post['flux_priorities_id'];
            if(array_key_exists('cnt_contact_id',$post))
            {
                if($post['cnt_contact_id'] === "NULL")
                {
                    $resource->cnt_contact_id = NULL;
                }
                else 
                {
                    $resource->cnt_contact_id = $post['cnt_contact_id'];
                }
            }
            if(array_key_exists('email',$post))
            {
                if($post['email'] === "NULL")
                {
                    $resource->email = NULL;
                }
                else 
                {
                    $resource->email = $post['email'];
                }
            }
            if(array_key_exists('phone',$post))
            {
                if($post['phone'] === "NULL")
                {
                    $resource->phone = NULL;
                }
                else 
                {
                    $resource->phone = $post['phone'];
                }
            }
            if(array_key_exists('other',$post))
            {
                if($post['other'] === "NULL")
                {
                    $resource->other = NULL;
                }
                else 
                {
                    $resource->other = $post['other'];
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
            $record = FluxFluxes::findFirst($id);
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
        
        $docFile = __DIR__ . "/docs/FluxfluxesController.php";
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
