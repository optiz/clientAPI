<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://127.0.0.1:8001/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
})->name('clientAPI');

Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://127.0.0.1:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret' => 'ob7IKwTVJPVf2xbrf1xRtXnfqE6o0YANPUrbiM4g',
            'redirect_uri' => 'http://127.0.0.1:8001/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::get('/todos', function(){
    $http = new GuzzleHttp\Client;
$response = $http->get('http://127.0.0.1:8000/api/todos', [
        'form_params' => [
            'accept'=> 'application/json',
            'authorization'=>'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ4ZDk5ODEzMTZlZmQyMWNjYWJjYTAwZGIzNmQzOGMyODIxMDM0YzhmNGMzZTM2N2YxYzgxNTEwZjU4NTQzYmRjNzU0NWFlYzRiY2RiZDgwIn0.eyJhdWQiOiIzIiwianRpIjoiZDhkOTk4MTMxNmVmZDIxY2NhYmNhMDBkYjM2ZDM4YzI4MjEwMzRjOGY0YzNlMzY3ZjFjODE1MTBmNTg1NDNiZGM3NTQ1YWVjNGJjZGJkODAiLCJpYXQiOjE1NTI0MjIyOTIsIm5iZiI6MTU1MjQyMjI5MiwiZXhwIjoxNTg0MDQ0NjkxLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.XXW_TeBJ3wM-Jt3ZJagcqk-d806ySH499070LXLbhFvgkaci5z68kT-9IVlb0PCAfz3RjwFc6uvZx4VuODgxF-_Dze9DToQ6dMTn4ejGwmYQo9WTCDWbnVC7uAjHwHxOhb-bgfW_ka8SqQlmkcLqNDxnw18XNJyerzhb8zy2isof7mZvSMipg9P9vmXK-rxnrYHjbjzCjOk7lcYbRsJEMFKcpyqSgrmGwWBH7s0EE6FklXmyiWIPqb5ZvGfY4590Yp-6Va480_VSy8qBHMNO5nnZgzd0WFealVUjAFSGqa5pPnRQaVpjQNVo0LNZdnqQlDYxEv7w6wS6V2oNDYHJpCTjm-YMWVKRQ-MGhJGFjrsP60695b1UC6RNG-lrtYHiA5mpcZGDN_tVm9FizdhhlUr03YVvRPqYDhgoOjM2VM4VqM1jmsB9cJwE423PMN9EHZSnJEW6Fpdq0tVkcywo0l8oduin7jGw4wOUn7b0pG-2P6CAcospPWE6NKLJtw5vcxcl2xp07oIOtjqP9_M7KJHjgmajyrWALJXmTgCaYU0SCozQ3YAV1aRc2lIeNon6DshUbcgARnTrCCt0gTkllICPuYObRFn6lK076km1Xm2p1wNeztnro_fZuz_haUg69ydGeIegv_GyPAU7Q-bGUYUPBItoVPgrMbABCM9GLwg'
        ],
    ]);
        
   // dd(json_decode((string) $response->getBody(), true));
     $todos=json_decode((string) $response->getBody(), true);
    return view('todos', ['todos'=>$todos]);
})->name('view.todos');