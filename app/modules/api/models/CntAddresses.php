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

use Fluxflow\Modules\Api\Library\ApiParamQuery;
use Fluxflow\Modules\Api\Models\BaseModel;

class CntAddresses extends BaseModel
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
     * @Column(type="integer", length=10, nullable=false)
     */
    public $unit_organizations_id;
    
    
    /**
     *
     * @var integer 
     * @Column(type="integer", length=10, nullable=false)
     */
    public $cnt_contacts_id;
    
    
    /**
     *
     * @var integer 
     * @Column(type="integer", length=10, nullable=false)
     */
    public $cnt_contact_types_id;
    
    
    /**
     *
     * @var integer 
     * @Column(type="integer", length=10, nullable=false)
     */
    public $geo_countries_id;
    
    
    /**
     *
     * @var integer 
     * @Column(type="integer", length=10, nullable=true)
     */
    public $geo_provinces_id;
    
    
    /**
     *
     * @var integer 
     * @Column(type="integer", length=10, nullable=false)
     */
    public $geo_cities_id;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=128, nullable=true)
     */
    public $neigborhood;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=45, nullable=true)
     */
    public $zip_code;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=255, nullable=false)
     */
    public $street_address;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=12, nullable=true)
     */
    public $door_number;
    
    
    /**
     *
     * @var string 
     * @Column(type="string", length=45, nullable=true)
     */
    public $room;
    
    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $primary;

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
        
        $this->belongsTo('geo_cities_id', '\GeoCities', 'id', ['alias' => 'GeoCities']);
        $this->belongsTo('cnt_contact_types_id', '\CntContactTypes', 'id', ['alias' => 'CntContactTypes']);
        $this->belongsTo('cnt_contacts_id', '\CntContacts', 'id', ['alias' => 'CntContacts']);
        $this->belongsTo('geo_countries_id', '\GeoCountries', 'id', ['alias' => 'GeoCountries']);
        $this->belongsTo('geo_provinces_id', '\GeoProvinces', 'id', ['alias' => 'GeoProvinces']);
        $this->belongsTo('unit_organizations_id', '\UnitOrganizations', 'id', ['alias' => 'UnitOrganizations']);
    }

    public function getSource()
    {
        return 'cnt_addresses';
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
            'cnt_contacts_id' => 'cnt_contacts_id',
            'cnt_contact_types_id' => 'cnt_contact_types_id',
            'geo_countries_id' => 'geo_countries_id',
            'geo_provinces_id' => 'geo_provinces_id',
            'geo_cities_id' => 'geo_cities_id',
            'neigborhood' => 'neigborhood',
            'zip_code' => 'zip_code',
            'street_address' => 'street_address',
            'door_number' => 'door_number',
            'room' => 'room',
            'primary' => 'primary',
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
            $row->unit_organizations_id = UnitOrganizations::findFirst($row->unit_organizations_id);

        if($row->cnt_contacts_id)
            $row->cnt_contacts_id = CntContacts::findFirst($row->cnt_contacts_id);
        
        if($row->cnt_contact_types_id)
            $row->cnt_contact_types_id = CntContactTypes::findFirst($row->cnt_contact_types_id);

        if($row->geo_countries_id)
            $row->geo_countries_id = GeoCountries::findFirst($row->geo_countries_id);

        if($row->geo_provinces_id)
            $row->geo_provinces_id = GeoProvinces::findFirst($row->geo_provinces_id);
        
        if($row->geo_cities_id)
            $row->geo_cities_id = GeoCities::findFirst($row->geo_cities_id);
        
        return $row;
    }    
}
