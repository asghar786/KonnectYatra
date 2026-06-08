<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Gurdwara;
use App\Models\News;
use App\Models\Events;
use App\Models\User;
use App\Models\Hotels;
use App\Models\Locations;
use App\Models\Gallery;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['all_packages'] = Package::all();
        $data['gurdwaras'] = Gurdwara::take(8)->get();
        $data['hotels'] = Hotels::all();
        $data['news'] = News::all();
        $data['events'] = Events::all();
        $data['locations'] = Locations::all();
        $data['gallery'] = Gallery::orderBy("id", "DESC")->get();
        return view('home', $data);
    }

    public function our_info()
    {
        $data['all_packages'] = Package::all();
        $data['gurdwaras'] = Gurdwara::all();
        $data['events'] = Events::all();
        $data['gallery'] = Gallery::all();
        return view('our-info', $data);
    }

    public function showLoginForm(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
       
            $credentials = $request->only('email', 'password');
            if (\Auth::attempt($credentials)) {
                return redirect(url("user/user_dashboard"))->withSuccess('You have Successfully loggedin');
            }
      
            return redirect("login")->withError('Oppes! You have entered invalid credentials');
        }
        return view('auth.login');
    }

    public function showRegisterForm(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
               
            $data = $request->all();
            $check = $this->create($data);
             
            return redirect(url("user/user_dashboard"))->withSuccess('Great! You have Successfully loggedin');
        }
        return view('auth.register');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Hash::make($data['password']),
            'role' => $data['role']
        ]);
    }

    public function visa_form()
    {
        $data['all_packages'] = Package::all();
        return view('visa-form', $data);
    }

    public function gurdwaras()
    {
        $data['all_packages'] = Package::all();
        $gurdwaras = Gurdwara::orderBy('state')->orderBy('gurdwara_name')->get();

        // Group by state (sorted) for the listing.
        $all_data = [];
        $all_state = [];
        foreach ($gurdwaras as $value) {
            if (!empty($value->state)) {
                $all_state[] = $value->state;
            }
        }
        $all_state = array_values(array_unique($all_state));
        sort($all_state);
        foreach ($all_state as $value) {
            $all_data[] = [
                'state'     => $value,
                'gurdwaras' => $gurdwaras->where('state', $value)->values(),
            ];
        }
        $data['gurdwaras'] = $all_data;

        // Geo data for the "Sikh Communities" map (jsvectormap US choropleth).
        $codes = $this->usStateCodes();
        $stateCounts = [];
        foreach ($gurdwaras as $g) {
            $name = trim((string) $g->state);
            if ($name === '') continue;
            $code = $codes[strtolower($name)] ?? null;
            if ($code) {
                $key = 'US-' . $code;
                $stateCounts[$key] = ($stateCounts[$key] ?? 0) + 1;
            }
        }
        $data['stateCounts']     = $stateCounts;
        $data['totalGurdwaras']  = $gurdwaras->count();
        $data['totalStates']     = count($all_state);

        return view('gurdwaras', $data);
    }

    public function gurdwara_detail($id)
    {
        $data['all_packages'] = Package::all();
        $data['gurdwara'] = Gurdwara::findOrFail($id);
        // A few nearby gurdwaras in the same state for cross-linking.
        $data['related'] = Gurdwara::where('state', $data['gurdwara']->state)
            ->where('id', '!=', $data['gurdwara']->id)
            ->take(3)->get();
        return view('gurdwara-detail', $data);
    }

    /**
     * Lower-cased US state/territory name => 2-letter postal code.
     */
    private function usStateCodes(): array
    {
        return [
            'alabama' => 'AL', 'alaska' => 'AK', 'arizona' => 'AZ', 'arkansas' => 'AR',
            'california' => 'CA', 'colorado' => 'CO', 'connecticut' => 'CT', 'delaware' => 'DE',
            'florida' => 'FL', 'georgia' => 'GA', 'hawaii' => 'HI', 'idaho' => 'ID',
            'illinois' => 'IL', 'indiana' => 'IN', 'iowa' => 'IA', 'kansas' => 'KS',
            'kentucky' => 'KY', 'louisiana' => 'LA', 'maine' => 'ME', 'maryland' => 'MD',
            'massachusetts' => 'MA', 'michigan' => 'MI', 'minnesota' => 'MN', 'mississippi' => 'MS',
            'missouri' => 'MO', 'montana' => 'MT', 'nebraska' => 'NE', 'nevada' => 'NV',
            'new hampshire' => 'NH', 'new jersey' => 'NJ', 'new mexico' => 'NM', 'new york' => 'NY',
            'north carolina' => 'NC', 'north dakota' => 'ND', 'ohio' => 'OH', 'oklahoma' => 'OK',
            'oregon' => 'OR', 'pennsylvania' => 'PA', 'rhode island' => 'RI', 'south carolina' => 'SC',
            'south dakota' => 'SD', 'tennessee' => 'TN', 'texas' => 'TX', 'utah' => 'UT',
            'vermont' => 'VT', 'virginia' => 'VA', 'washington' => 'WA', 'west virginia' => 'WV',
            'wisconsin' => 'WI', 'wyoming' => 'WY', 'district of columbia' => 'DC',
        ];
    }
}
