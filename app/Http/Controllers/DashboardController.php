<?php

namespace App\Http\Controllers;

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\YatriVisa;
use App\Models\Gurdwara;
use App\Models\YatriIds;
use App\Models\Hotels;
use App\Models\Season;
use Session;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminauthenticate');
    }
    public function index(Request $request)
    {
    	if (!empty($request->season)) {
    		Session::put('season', $request->season);
    	}
    	$active_season = Session::get('season');
        if (empty($active_season)) {
            $season = Season::orderBy('id', 'DESC')->first();
            Session::put('season', $season->id);
            $active_season = $season->id;
        }
    	$data = [
    		"total_users" => User::where("role", "!=", "admin")->count(),
    		"total_yatri" => YatriVisa::where("season_id", $active_season)->count(),
    		"total_gurdwaras" => Gurdwara::all()->count(),
    		"total_ids" => YatriIds::where("season_id", $active_season)->count(),
    		"total_hotels" => Hotels::all()->count(),
    		"season" => Season::orderBy('id', 'DESC')->get(),
    		"current_season" => Season::where('id', $active_season)->first()
    	];
        return view('admin.dashboard', $data);
    }
    
}
