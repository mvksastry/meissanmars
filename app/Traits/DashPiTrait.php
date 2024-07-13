<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Slot;
use App\Models\Rack;
use App\Models\Usage;
use App\Models\Strain;
use App\Models\Iaecproject;
use App\Models\Tempproject;


use DateTime;

trait DashPiTrait
{

    public function approvedProjects(){
        return count(Iaecproject::where('pi_id',Auth::id() )->where('status', 'active')->get());
    }

    public function submittedProjects() {
        return count(Tempproject::where('pi_id',Auth::id() )->where('status', 'submitted')->get());

    }

    public function amendProjects() {
        return count(Tempproject::where('pi_id',Auth::id() )->where('status', 'amend')->get());
    }

    public function expiredProjects() {
        return count(Iaecproject::where('pi_id',Auth::id() )->where('status', 'expired')->get());
    }

    public function piOwnedStrains()
    {
        return Strain::where('pi_id',Auth::id() )->where('distributable', 'no')->count();
    }

    public function piSubmittedIssues()
    {
        return Usage::where('pi_id',Auth::id() )->where('issue_status', 'submitted')->count();
    }

    public function piConfirmedIssues()
    {
        return Usage::where('pi_id',Auth::id() )->where('issue_status', 'confirmed')->count();
    }

    public function piApprovedIssues()
    {
        return Usage::where('pi_id',Auth::id() )->where('issue_status', 'approved')->count();
    }

    public function piIssuedIssues()
    {
        return Usage::where('pi_id',Auth::id() )->where('issue_status', 'issued')->count();
    }

    public function waitingIssues()
    {
        return Usage::where('pi_id',Auth::id() )->where('issue_status', 'confirmed')->count();
    }

    public function piCages()
    {
        return Usage::where('pi_id',Auth::id() )->where('issue_status', 'approved')->count();
    }


}
