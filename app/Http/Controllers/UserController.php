<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\UserModel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function login()
    {
        return view('login');
    }
    public function loginPost(Request $request)
    {       
        $request->validate([
            'username' => 'required | min: 3',
            'password' => 'required | min: 3'
        ]);
        $username = $request->username;
        $password = $request->password;
        $remember = $request->remember;

        $user = UserModel::where('username', $username)->first();
        if($user != null)
        {
            if($password == $user->password)
            {
                Session::put('userid', $user->id);
                Session::put('nama', $user->nama);
                Session::put('username', $user->username);
                Session::put('role', $user->role);
                Session::put('login', TRUE);
                return redirect()->route('user.index');
            }
            else
                return redirect()->route('login')->with('alert', 'Password salah !');
        }
        else
            return redirect()->route('login')->with('alert', 'Username salah !');
    }
    public function logout()
    {
        //Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('alert-success', 'Berhasil logout');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik'))
        {
            $datas = UserModel::where('aktif', 1)->get();
            return view('admin/user/user', compact('datas'));
        }
        else
            return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/user/userCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:20',
            'username' => 'required|unique:users|max:20',
            'password' => 'required|max:20',
            'role' => 'required'
        ]);
        $data = new UserModel();
        $data->nama = $request->nama;
        $data->username = $request->username;
        $data->password = bcrypt($request->password);
        $data->role = $request->role;
        $data->nohp = $request->nohp;
        $data->alamat = $request->alamat;
        $data->creator = Auth::user()->id;
        $data->aktif = 1;
        $data->save();
        return redirect()->route('user.index')->with('alert-success', 'Berhasil menambahkan data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = decrypt($id);
        $data = UserModel::find($id);
        return view('admin/user/userShow', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $data = UserModel::findOrFail($id);
        return view('admin/user/userEdit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:20',
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'role' => 'required'
        ]);
        $data = UserModel::find($id);
        $data->nama = $request->nama;
        $data->username = $request->username;
        $data->password = bcrypt($request->password);
        $data->role = $request->role;
        $data->nohp = $request->nohp;
        $data->alamat = $request->alamat;
        $data->modifier = Auth::user()->id;
        $data->aktif = 1;
        $data->save();
        return redirect()->route('user.index')->with('alert-success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = UserModel::find($id);
        $data->aktif = 0;
        $data->modifier = Session::get('userid');
        $data->save();
        return redirect()->route('user.index')->with('alert-success', 'Data berhasil dihapus!');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:10|min:3',
            'password' => 'required|string|max:10|min:3'
        ]);
    }
}
