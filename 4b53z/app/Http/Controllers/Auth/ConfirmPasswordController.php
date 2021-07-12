<?php
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Akun;
use Auth;
  
class LoginController extends Controller
{    
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(Request $request)
    {   
        $input = $request->all();
        $key = 'fresto6';
        $password = $input['password'];
            $user = Akun::where([
                'username' => $input['email'], 
                'password' => md5($password.$key).md5($password)
            ])->first();
        if($user != null)
        {
            Auth::login($user);
            return redirect('/home');
        }
        return redirect('/');
        
          
    }
    public function logout()
    {
      if (Auth::guard('akun')->check()) {
        Auth::guard('akun')->logout();
        return redirect('/');
      }
      
    }
    public function showLoginForm(){
        return redirect('/');
    }
}