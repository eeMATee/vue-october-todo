<?php

use Mat\Todo\Models\Todo;
use Illuminate\Http\Request;

Route::options('/{any}', function() {
    $headers = [
        'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Headers'=> 'X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization'
    ];
    return \Response::make('You are connected to the API', 200, $headers);
})->where('any', '.*');



Route::get('api/populate', function() {
    $faker = Faker\Factory::create();

    for($i = 0; $i < 20; $i++) {
        Todo::create([
            'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            'description' => $faker->text($maxNbChars = 200),
            'status' => $faker->boolean($chanceOfGettingTrue = 50),
            'created_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
        ]);
    }

    return "Todos Created!";

});




Route::get('api/todos', function() {
    $todos = Todo::all();

    return $todos;
});




Route::post('api/add-todo', function(Request $req) {
    $data = $req->input();


    Todo::create([
        'title' => $data['title'],
        'description' => $data['description'],
        'status' => $data['status'],
    ]);
});




Route::post('api/delete-todos', function(Request $req) {
    $data = $req->input();

    Todo::destroy($data['id']);
});





Route::post('api/change-status', function(Request $req) {
    $data = $req->input();

    Todo::where('id', $data['id'])->update(['status' => $data['status']]);
});



Route::post('api/update-todos', function(Request $req) {
    $data = $req->input();

    Todo::where('id', $data['id'])
    ->update([
        'status' => $data['status'],
        'title' => $data['title'],
        'description' => $data['description'],
    ]);
});