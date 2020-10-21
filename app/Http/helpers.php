<?php

/**
 * This is my custom helper function
 * Laravel keeps resetting it's global helper file
 * So I opened a new file of my own, damn you Laravel!
 */

use App\Models\Control\GeneralSetting;
use App\Utilities\RandomGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

if (! function_exists('generate_random_string')) {
    /**
     * @param $length
     * @return string
     */
    function generate_random_string($length)
    {
        return RandomGenerator::generate_random_string($length);
    }
}

if (! function_exists('generate_random_numbers')) {
    /**
     * @param $length
     * @return string
     */
    function generate_random_numbers($length)
    {
        return RandomGenerator::generate_random_numbers($length);
    }
}

if(! function_exists('toast')) {
    /**
     * @param $title
     * @param $type
     * @param $body
     */
    function toast($type, $body)
    {
        session()->flash('message', [
            'type' => $type,
            'body' => $body
        ]);
    }
}

if (! function_exists('user')) {
    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user()
    {
        return \Auth::user();
    }
}

if(! function_exists('current_route')) {
    /**
     * @param $title
     * @param $type
     * @param $body
     */
    function current_route()
    {
        return \Request::route()->getName();
    }
}

if(! function_exists('apps')) {
    /**
     * @param $title
     * @param $type
     * @param $body
     */
    function apps($filter = NULL)
    {
        $response = NULL;

        if(!$filter)
        {
            if(session()->has('apps'))
            {
                $response = session('apps');
            }
            else
            {
                if(user()->host_id == 'github')
                {
                    $response = (Http::withHeaders([
                        'Authorization' => 'token '.user()->token
                    ])->get('https://api.github.com/users/'. user()->nickname .'/repos?sort=pushed_at&order=desc'))->json();
                }

                if(user()->host_id == 'gitlab')
                {
                    $response = (Http::get('https://gitlab.com/api/v4/users/'. user()->nickname .'/projects?access_token='. user()->token))->json();
                }

                if(user()->host_id == 'bitbucket')
                {
                    $response = ((Http::get('https://api.bitbucket.org/2.0/repositories/'. user()->nickname . '?access_token='. user()->token. '&pagelen=10&sort=-updated_on'))->json())['values'];
                }


                session(['apps' => $response]);
            }
        }
        else
        {
            if(user()->host_id == 'github')
            {
                $response = ((Http::withHeaders([
                    'Authorization' => 'token '.user()->token
                ])->get('https://api.github.com/search/repositories?q='. $filter .'+in:name+user:' . user()->nickname. '&sort=pushed_at&order=desc'))->json())['items'];
            }

            if(user()->host_id == 'gitlab')
            {
                $response = collect(session('apps'))->filter(function ($value, $key) {
                    return preg_match('/^.*('.$filter.').*/i', $value['name']);
                })->all();
            }

            if(user()->host_id == 'bitbucket')
            {
                $response = ((Http::get('https://api.bitbucket.org/2.0/repositories/'. user()->nickname . '?access_token='. user()->token .'&pagelen=10&sort=-updated_on&q=name~"'. $filter .'"'))->json())['values'];
            } 
        }

        return $response != NULL ? $response : NULL;
    }
}