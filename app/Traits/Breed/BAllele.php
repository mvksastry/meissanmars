<?php

namespace App\Traits\Breed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;

trait BAllele
{
  
	public function home()
	{
		return "Breeding Home";
	}
	
	public function findAll()
	{
		return Allele::all();
	}
	
	public function findAllByOwner($owner)
	{
		return DB::table('allele a')
								->join('Gene g', 'Genotype gt', 'mouse m')
								->where('a.alleleKey' , 'a.geneKey')
								->where('g.geneKey' , 'gt.geneKey')
								->where('gt.mouseKey' , 'm.mouseKey')
								->where('m.owner' , $owner)
								->orderBy('a.allele');
	}
		
		public function findAllByOwners($owners)
		{
			return DB::table('allele a')
								->join('Gene g', 'Genotype gt', 'mouse m')
								->where('a.alleleKey' , 'a.geneKey')
								->where('g.geneKey' , 'gt.geneKey')
								->where('gt.mouseKey' , 'm.mouseKey')
								->where('m.owner' , $owners)
								->orderBy('a.allele');			
		}
		
		public function findByKey($alleleKey)
		{
			 return Allele::where('alleleKey', $alleleKey)->get();
			
		}
		
		public function findByAllele($allele)
		{
			return Allele::where('allele', $allele)->get();
		}
		
		
}