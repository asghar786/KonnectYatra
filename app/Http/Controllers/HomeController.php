<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Gurdwara;
use App\Models\ZipCode;
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
        $data['hotels'] = Hotels::take(6)->get();
        $data['news'] = News::all();
        $data['events'] = Events::all();
        $data['locations'] = Locations::take(6)->get();
        $data['gallery'] = Gallery::orderBy("id", "DESC")->get();
        $data['heroSlides'] = \App\Models\HeroSlide::where('is_active', 1)->orderBy('sort_order')->orderBy('id')->get();
        return view('home', $data);
    }

    public function gallery_page()
    {
        $data['all_packages'] = Package::all();
        $data['gallery'] = Gallery::orderBy('id', 'DESC')->get();
        return view('gallery', $data);
    }

    public function pakistan_hotels()
    {
        $data['all_packages'] = Package::all();
        $hotels = Hotels::orderBy('name')->get();

        // City values are entered inconsistently; normalise before grouping.
        foreach ($hotels as $h) {
            $h->city = ucwords(strtolower(trim((string) $h->city)));
        }

        $cities = $hotels->pluck('city')->filter()->unique()->sort()->values();
        $grouped = [];
        foreach ($cities as $city) {
            $grouped[] = ['city' => $city, 'hotels' => $hotels->where('city', $city)->values()];
        }
        $data['hotels']      = $grouped;
        $data['totalHotels'] = $hotels->count();
        $data['totalCities'] = $cities->count();

        // Map markers for cities we have coordinates for.
        $coords = $this->pkCityCoords();
        $markers = [];
        foreach ($cities as $city) {
            $key = strtolower($city);
            if (isset($coords[$key])) {
                $markers[] = [
                    'city'  => $city,
                    'count' => $hotels->where('city', $city)->count(),
                    'lat'   => $coords[$key][0],
                    'lng'   => $coords[$key][1],
                ];
            }
        }
        $data['cityMarkers'] = $markers;

        return view('hotels', $data);
    }

    /** Lower-cased Pakistani city => [lat, lng] for map markers. */
    private function pkCityCoords(): array
    {
        return [
            'islamabad' => [33.6844, 73.0479], 'rawalpindi' => [33.5651, 73.0169],
            'lahore' => [31.5497, 74.3436], 'gujranwala' => [32.1877, 74.1945],
            'karachi' => [24.8607, 67.0011], 'multan' => [30.1575, 71.5249],
            'faisalabad' => [31.4504, 73.1350], 'peshawar' => [34.0151, 71.5805],
            'quetta' => [30.1798, 66.9750], 'murree' => [33.9070, 73.3943],
            'sialkot' => [32.4945, 74.5229], 'bahawalpur' => [29.3956, 71.6836],
            'abbottabad' => [34.1688, 73.2215], 'sargodha' => [32.0836, 72.6711],
            'sukkur' => [27.7052, 68.8574], 'hyderabad' => [25.3960, 68.3578],
        ];
    }

    public function popular_locations()
    {
        $data['all_packages'] = Package::all();
        $data['locations'] = Locations::orderBy('name')->get();
        return view('locations', $data);
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

    public function gurdwaras(Request $request)
    {
        $data['all_packages'] = Package::all();
        $gurdwaras = Gurdwara::orderBy('gurdwara_name')->get();

        // The state column is stored inconsistently (e.g. "NY" and "New York"),
        // so normalise to a canonical full name before grouping/counting.
        foreach ($gurdwaras as $g) {
            $g->state = $this->canonicalState($g->state);
        }

        $data = array_merge($data, $this->zipSearch($request->query('zip'), $gurdwaras));

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

    /**
     * ZIP search: resolve a US ZIP to its city, then rank gurdwaras by real
     * distance from it. Ranking (rather than filtering on the city name) means
     * someone in Forest Hills still finds the Queens gurdwaras a few miles away.
     */
    private function zipSearch($raw, $gurdwaras): array
    {
        $out = ['zipQuery' => trim((string) $raw), 'zipResult' => null, 'zipError' => null];
        if ($out['zipQuery'] === '') {
            return $out;
        }

        $zip = preg_replace('/\D/', '', $out['zipQuery']);
        if (strlen($zip) !== 5) {
            $out['zipError'] = 'Please enter a 5-digit US ZIP code — for example 11419.';
            return $out;
        }

        $origin = ZipCode::find($zip);
        if (!$origin) {
            $out['zipError'] = "We couldn't find the ZIP code {$zip}. Please check and try again.";
            return $out;
        }

        $coords = $this->gurdwaraCoords($gurdwaras);
        $ranked = [];
        foreach ($gurdwaras as $g) {
            if (empty($coords[$g->id])) {
                continue;   // no location we trust — can't honestly claim a distance
            }
            [$lat, $lng] = $coords[$g->id];
            $g->distance = ZipCode::miles($origin->lat, $origin->lng, $lat, $lng);
            $ranked[] = $g;
        }
        usort($ranked, fn($a, $b) => $a->distance <=> $b->distance);

        $out['zipResult'] = [
            'zip'       => $origin->zip,
            'city'      => $origin->city,
            'state'     => $this->canonicalState($origin->state),
            'gurdwaras' => array_slice($ranked, 0, 12),
            'exact'     => count(array_filter($ranked, fn($g) => strcasecmp(trim($g->city), $origin->city) === 0)),
        ];
        return $out;
    }

    /** id => [lat, lng] for each gurdwara. Shared with the admin Address Book. */
    private function gurdwaraCoords($gurdwaras): array
    {
        return \App\Support\GurdwaraGeo::coords($gurdwaras);
    }

    /** Normalise a raw state value (code or name) to a canonical full state name. */
    private function canonicalState($raw): string
    {
        return \App\Support\GurdwaraGeo::canonicalState($raw);
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
}
