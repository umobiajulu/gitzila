<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\User;
use Socialite;

class UserController extends Controller
{
    //
    public function __construct()
    {

    }

    //
    public function index()
    {
    	return view('index');
    }

    //
    public function login(Request $request)
    {
        if(!$request->provider)
        {
            return redirect()->route('index');
        }

    	return Socialite::driver($request->provider)->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $user = Socialite::driver($request->provider)->user();
        } catch (\Throwable $e) {
            return redirect()->route('index');
        }

        $auth_user = User::where('host', $request->provider)->where('email', $user->email)->first();

        if(!$auth_user){
            $auth_user = User::create([
                'email' => $user->email,
                'host' => $request->provider,
                'unique_id' => generate_random_string(20),
                'name' => $user->name,
                'nickname' => $user->nickname,
                'avatar' => $user->avatar,
            ]);
        }

        session()->flush();
        session()->regenerate();

        \Auth::guard('web')->login($auth_user);
        return redirect()->route('dashboard');
    }

    //
    public function logout(Request $request)
    {
        \Auth::guard('web')->logout();
        return redirect()->route('index');
    }

    //
    public function dashboard()
    {
        return view('dashboard');
    }

    //
    public function hook(Request $request)
    {    
        $user = User::where("host", $request->host)->where("unique_id", $request->unique_id)->first();
        
        if($user){ 
            try{
                $host = $user->host;
                $name = $user->name;
                $email = $user->email;
                $unique_id = $user->unique_id;
                $nickname = $user->nickname;
                $repo_name = $request->repo_name;
                $server_connection = $request->server_connection;
                $server_root = $request->server_root;
                $server_address = $request->server_address;
                $server_username = $request->server_username;
                $server_password = decrypt($request->server_password);
                $server_port = $request->server_port;
                $deployment_commands = $request->deployment_commands;

                if($host == 'bitbucket'){
                    $git_url = 'git@bitbucket.org:' . $nickname . '/' . $repo_name . '.git';
                }

                if($host == 'github'){
                    $git_url = 'git@github.com:' . $nickname . '/' . $repo_name . '.git';
                }

                if($host == 'gitlab'){
                    $git_url = 'git@gitlab.com:' . $nickname . '/' . $repo_name . '.git';
                }

                Http::get(env("APP_IP").':3000', [
                    'check' => 'deploy',
                    'host' => $host,
                    'name' => $name,
                    'email' => $email,
                    'unique_id' => $unique_id,
                    'git_url' => $git_url,
                    'nickname' => $nickname,
                    'repo_name' => $repo_name,
                    'server_connection' => $server_connection,
                    'server_root' => $server_root,
                    'server_address' => $server_address,
                    'server_username' => $server_username,
                    'server_password' => $server_password,
                    'server_port' => $server_port,
                    'deployment_commands' => $deployment_commands
                ]);
            }
            catch(\Throwable $e){
                return response()->json(array(
                    'type' => 'error',
                    'message' => 'unknown error',
                ), 200);
            }

            return response()->json(array(
                'type' => 'success',
                'message' => 'App deployed successfully',
            ), 200);
        }

        return response()->json(array(
            'message' => 'Success!',
        ), 200);
    }

    //
    public function configure(Request $request)
    {    
        try{
            $host = user()->host;
            $name = user()->name;
            $email = user()->email;
            $unique_id = user()->unique_id;
            $nickname = user()->nickname;
            $repo_name = $request->repo_name;
            $server_connection = $request->server_connection;
            $server_root = $request->server_root;
            $server_address = $request->server_address;
            $server_username = $request->server_username;
            $server_password = decrypt($request->server_password);
            $server_port = $request->server_port;
            $configuration_commands = $request->configuration_commands;

            if($host == 'bitbucket'){
                $git_url = 'git@bitbucket.org:' . $nickname . '/' . $repo_name . '.git';
            }

            if($host == 'github'){
                $git_url = 'git@github.com:' . $nickname . '/' . $repo_name . '.git';
            }

            if($host == 'gitlab'){
                $git_url = 'git@gitlab.com:' . $nickname . '/' . $repo_name . '.git';
            }

            Http::get(env("APP_IP").':3000', [
                'check' => 'configure',
                'host' => $host,
                'name' => $name,
                'email' => $email,
                'unique_id' => $unique_id,
                'git_url' => $git_url,
                'nickname' => $nickname,
                'repo_name' => $repo_name,
                'server_connection' => $server_connection,
                'server_root' => $server_root,
                'server_address' => $server_address,
                'server_username' => $server_username,
                'server_password' => $server_password,
                'server_port' => $server_port,
                'configuration_commands' => $configuration_commands
            ]);
        }
        catch(\Throwable $e){
            return response()->json(array(
                'type' => 'error',
                'message' => 'unknown error',
            ), 200);
        }

        return response()->json(array(
            'type' => 'success',
            'message' => 'Server configured successfully',
        ), 200);
    }

    //
    public function ssh(Request $request)
    {    
        try{
            Http::get(env("APP_IP").':3000', [
                'host' => user()->host,
                'check' => 'ssh',
                'server_root' => str_replace(" ", "\ ", storage_path()),
                'unique_id' => user()->unique_id,
            ]);
        }
        catch(\Throwable $e){
            return response()->json(array(
                'type' => 'error',
                'message' => 'unknown error',
            ), 200);
        }

        return response()->json(array(
            'type' => 'success',
            'message' => 'Ssh generated successfully',
        ), 200);
    }

    //
    public function download(Request $request)
    {    
        try{
            $path = storage_path().'/users/'. user()->unique_id .'/ssh/'. user()->host .'_keys.zip';

            return response()->download($path);
        }
        catch(\Throwable $e){
            return redirect()->back();
        }
    }

    //
    public function password(Request $request)
    {    
        try{
            $password = encrypt($request->password);

            return response()->json(array(
                'password' => $password
            ), 200);
        }
        catch(\Throwable $e){
            return response()->json(array(
                'password' => NULL
            ), 200);
        }
    }
}
