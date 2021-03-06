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

namespace Fluxflow\Modules\Api\Models;

use Fluxflow\Modules\Api\Models\UnitOrganizations;
use Fluxflow\Modules\Api\Models\UserPositionTypes;
use Fluxflow\Modules\Api\Models\BaseModel;

class UserUsers extends BaseModel
{
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $id;
    
    /**
     *
     * @var integer 
     * @Column(type="integer", length=10, nullable=true)
     */
    public $unit_organizations_id;
    
    /**
     *
     * @var integer 
     * @Column(type="integer", length=10, nullable=true)
     */
    public $user_position_types_id;
    
    /**
     *
     * @var string 
     * @Column(type="string", length=64, nullable=false)
     */
    public $first_name;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=128, nullable=false)
     */
    public $surename;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=255, nullable=false)
     */
    public $email;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=255, nullable=false)
     */
    public $password;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=, nullable=false)
     */
    public $last_login;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=, nullable=false)
     */
    public $last_operation;
    
    /**
     *
     * @var string 
     * @Column(type="string", length=255, nullable=false)
     */
    public $photo;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $active;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $created_by;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $created_date;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $updated_by;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $updated_date;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    public $deleted_by;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $deleted_date;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $deleted;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("fluxflow");
        
        $this->belongsTo('unit_organizations_id', '\UnitOrganizations', 'id', ['alias' => 'UnitOrganizations']);
        $this->hasMany('id', 'FluxFluxes', 'owner_id', ['alias' => 'FluxFluxes']);
        $this->hasMany('id', 'UserAssignedOrganizations', 'user_users_id', ['alias' => 'UserAssignedOrganizations']);
        $this->hasMany('id', 'UserAssingnedRoles', 'user_users_id', ['alias' => 'UserAssingnedRoles']);
        
    }
    
    public function getSource()
    {
        return 'user_users';
    }

    public static function findLogin($email,$password)
    {
        return parent::findFirst([
                "conditions"    => "email = ?1 AND password =?2",
                "bind"          => [
                    1   => $email,
                    2   => $password
                    ]
                ]);
    }
        
    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'unit_organizations_id' => 'unit_organizations_id',
            'user_position_types_id' => 'user_position_types_id',
            'first_name' => 'first_name',
            'surename' => 'surename',
            'email' => 'email',
            'password' => 'password',
            'last_login' => 'last_login',
            'last_operation' => 'last_operation',
            'photo' => 'photo',
            'active' => 'active',
            'created_by' => 'created_by',
            'created_date' => 'created_date',
            'updated_by' => 'updated_by',
            'updated_date' => 'updated_date',
            'deleted_by' => 'deleted_by',
            'deleted_date' => 'deleted_date',
            'deleted' => 'deleted'
        ];
    }
    
    public function findRelated($row)
    {
        if($row->unit_organizations_id) 
        {
            $row->unit_organizations_id = UnitOrganizations::findFirst($row->unit_organizations_id);
        }

        if($row->user_position_types_id)
        {
            $row->user_position_types_id = UserPositionTypes::findFirst($row->user_position_types_id);
        }
        
        return $row;
    }    
}
