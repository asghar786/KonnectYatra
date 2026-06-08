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
        $data['gurdwaras'] = Gurdwara::take(6)->get();
        $data['hotels'] = Hotels::all();
        $data['news'] = News::all();
        $data['events'] = Events::all();
        $data['locations'] = Locations::all();
        $data['gallery'] = Gallery::orderBy("id", "DESC")->get();
        $data['heroSlides'] = \App\Models\HeroSlide::where('is_active', 1)->orderBy('sort_order')->orderBy('id')->get();
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
        $gurdwaras = Gurdwara::orderBy('gurdwara_name')->get();

        // The state column is stored inconsistently (e.g. "NY" and "New York"),
        // so normalise to a canonical full name before grouping/counting.
        foreach ($gurdwaras as $g) {
            $g->state = $this->canonicalState($g->state);
        }

        // Group by canonical state (sorted).
        $all_state = $gurdwaras->pluck('state')->filter()->unique()->sort()->values();
        $all_data = [];
        foreach ($all_state as $value) {
            $all_data[] = [
                'state'     => $value,
                'gurdwaras' => $gurdwaras->where('state', $value)->values(),
            ];
        }
        $data['gurdwaras']      = $all_data;
        $data['totalGurdwaras'] = $gurdwaras->count();
        $data['totalStates']    = $all_state->count();

        return view('gurdwaras', $data);
    }

    /** Normalise a raw state value (code or name) to a canonical full state name. */
    private function canonicalState($raw): string
    {
        $raw = trim((string) $raw);
        if ($raw === '') return '';
        $states = $this->usStates();              // CODE => Full Name
        $upper = strtoupper($raw);
        if (isset($states[$upper])) return $states[$upper];        // "NY" -> "New York"
        $lowerToProper = array_change_key_case(array_flip($states), CASE_LOWER); // "new york" => "NY"
        $lower = strtolower($raw);
        if (isset($lowerToProper[$lower])) return $states[$lowerToProper[$lower]]; // proper-case it
        return $raw;                              // unknown — keep as entered
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

    /** 2-letter postal code => full US state/territory name. */
    private function usStates(): array
    {
        return [
            'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas',
            'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware',
            'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
            'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
            'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
            'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi',
            'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
            'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
            'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
            'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
            'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah',
            'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia',
            'WI' => 'Wisconsin', 'WY' => 'Wyoming', 'DC' => 'District of Columbia',
        ];
    }
}
