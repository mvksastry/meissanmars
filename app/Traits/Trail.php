<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Hop;
use App\Models\Path;
use App\Models\User;

trait Trail
{
    /**
     * Get all the users associated with roles 
     *
     * @param  none
     * @return \App\User with roles
     */
	public function usersByRoles()
	{
		$roles = Role::select('id','name')->get();
		
		foreach($roles as $val) 
		{
			$uwr[$val->name] = User::role($val->name)->select('name','id')->get();
		}
		
		return $uwr;
		
	}
		
	public function employeeGroup()
	{
		$roles = Role::select('id','name')->get();
		
		foreach($roles as $val) 
		{
				$uwr[$val->name] = User::role($val->name)->select('name','id')->get();
		}
		return $uwr;			
	}
		
	public function employeeByRoleName()
	{
		$roles = Role::select('id','name')->get();
		
		foreach($roles as $val) 
		{
			if( $val->name != 'researcher' || $val->name != 'user')
			{
				$uwr[$val->name] = User::role($val->name)->select('name','id')->get();
			}
			unset($uwr['researcher']);
		}
		unset($uwr['researcher']);
		unset($uwr['user']);
		unset($uwr['employee']);
		$gp = array();
		$gp1 = array();
		foreach($uwr as $key => $row)
		{
			foreach($row as $val)
			{
				$gp['id'] = $val->id;
				$gp['name'] = ucfirst($key)." - ".ucfirst($val->name);
				array_push($gp1, $gp);
				unset($gp);
			}
		}
		return $gp1;
	}
		
	public function allPathBreadCrumbArray()
	{
		$tf = array();
		$string = "";
		$temp = array();
		$paths = Path::with('roleName')->get(); 
		foreach($paths as $row)
		{
			$path = json_decode($row, true);
			$xc = json_decode($path['path']);
			$temp['path_id'] = $path['path_id'];
			$temp['role_name'] = ucfirst(($row->roleName)->name);	
			
			$temp['created_at'] = $path['created_at'];							
			$controller = $path['controller'];
			$temp['controller'] = ucfirst($controller);	
			foreach($xc as $key => $val)
			{
				$string = $string.">>".$key;
			}
			
			$temp['path'] = $string;
			array_push($tf, $temp);
			$string = "";
			unset($temp);
		}			
		return $tf;
	}
		
	public function breadCrumbArray($id)
	{
		$path = json_decode($this->currentPath($id), true);
													
		$temp = array();
		
		foreach($path as $key => $val)
		{
			$temp[$key] = $val['status'];
		}
					
		return $temp;
	}
		
	public function pathBreadCrumb($id)
	{
		$path = json_decode($this->currentPath($id), true);
		
		$keys = $this->arrayKeys($path);
					
		$string = "";
		
		$arrows = " >> ";
		
		foreach($keys as $val)
		{
			$string = $string.$arrows.$val;
		}	
		
		return $string;		
	}
		
	public function arrayKeys($array)
	{
		return array_keys($array);
	}
		
	public function defaultNextStepKey($path)
	{
		$keys = $this->arrayKeys($path);
		
		foreach($path as $key => $val)
		{
			$searchKey = array_search("incomplete", array_column($path, 'status'), true);
		}
		
		return $keys[$searchKey];
		
	}
		
	public function makeNewPath($group)
	{
		$temp = array();
		foreach($group as $key => $val)
		{
			if(!is_null($val[0]))
			{
				$temp[$key] = $this->stepArray($val);
			}
		}
		asort($temp);
		return $temp;
	}
		
	private function stepArray($array)
	{
		$xrt = array();
		$xrt['step_id'] = $array[0];
		$xrt['id'] = $array[1];
		if( !empty($array[2]))
		{
			$xrt['notes'] = $array[2];
		}
		else {
			$xrt['notes'] = "no";
		}
		$xrt['status'] = 'incomplete';
		return $xrt;
	}
		
	public function makeNewDefaultPath($group)
	{
		
		$temp = array();
		
		foreach($group as $key => $val)
		{
			if(!is_null($val[0]))
			{
				$temp[$key] = $this->defaultStepArray($val);
			}
		}
		
		asort($temp);
		
		return $temp;
		
	}
		
	private function defaultStepArray($array)
	{
		
		$xrt = array();
		
		$xrt['step_id'] = $array[0];
		
		if($array[1] == null)
		{
			$array[1] = "0";
		}
		
		$xrt['id'] = $array[1];
		
		if( !empty($array[2]))
		{
			$xrt['notes'] = $array[2];
		}
		else {
			$xrt['notes'] = "no";
		}
		
		$xrt['status'] = 'incomplete';
		
		return $xrt;
		
	}
}