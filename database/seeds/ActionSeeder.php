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
    	'Was beaten',
    	'Was locked up',
    	'Was threatend to be shot',
    	'Was shot',
    	'Was killed',
    	'Was not found',
    	'Was asked to see account balance before asking to pay',
    	'Was taken to an ATM to withdraw money',
    	'Was given POS to pay money',
    	'Was asked to pay cash',
    	'Was asked to make bank transfer'
    ];
    public function run()
    {
        foreach ($this->action as $action) {
        	Action::create(['name' => $action]);
    	}
    }
}
