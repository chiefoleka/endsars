<?php

use Illuminate\Database\Seeder;
use App\Action;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $action = [
        'Collected my phone',
        'Was asked to open twitter to check for #EndSARS',
        'Was threatened',
    	'Was called all sorts of names'
    ];
    public function run()
    {
        foreach ($this->action as $action) {
        	Action::create(['name' => $action]);
    	}
    }
}
