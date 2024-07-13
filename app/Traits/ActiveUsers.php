<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Models\User;

trait ActiveUsers
{

	public function activeUsers ()
	{
		return User::where('id','<>', 1)
					->where('role', 'pisg')
					//->orWhere('role', 'pilg')
					//->orWhere('role', 'piblg')
					->orWhere('role', 'manager')
					->get()
					->sortBy('role');
	}

}
