<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $location = [
    	'Abia',
    	'Adamawa',
    	'Akwa Ibom',
    	'Anambra',
    	'Bauchi',
    	'Bayelsa',
    	'Benue',
    	'Borno',
    	'Cross River',
    	'Delta',
    	'Ebonyi',
    	'Edo',
    	'Ekiti',
    	'Enugu',
    	'Gombe',
    	'Imo',
    	'Jigawa',
    	'Kaduna',
    	'Kano',
    	'Katsina',
    	'Kebbi',
    	'Kogi',
    	'Kwara',
    	'Lagos',
    	'Nasarawa',
    	'Niger',
    	'Ogun',
    	'Ondo',
    	'Osun',
    	'Oyo',
    	'Plateau',
    	'Rivers',
    	'Sokoto',
    	'Taraba',
    	'Yobe',
    	'Zamfara',
    	'FCT',
    	'Unknown'
    ];
    public function run()
    {	foreach ($this->location as $state) {
        	Location::create(['name'=>$state]);
    	}
    }
}








