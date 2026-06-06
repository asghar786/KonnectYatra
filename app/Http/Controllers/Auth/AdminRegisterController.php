// <?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;

// class AdminRegisterController extends Controller
// {
//     public function index()
//     {
//         return view('adminauth.admin_register');
//     }

//     public function store(Request $request)
//     {
//         // dd($request);
//         $this->validate($request,[
//             'name' => ['required','string','max:255'],
//             'email' => ['required','string','email','max:255','unique:users'],
//             'password' => ['required', 'string','min:8','max:20','confirmed'],

//         ]);


//         User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make ($request->password),
//             'role' => 'admin',
//         ]);

//         return redirect()->route('dashboard');
//     }
// }
