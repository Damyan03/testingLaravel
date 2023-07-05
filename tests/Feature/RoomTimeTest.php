<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Testing\File;

test('can add entries to database from csv file', function () {
    $csvContent = "Timestamp,Gew.ruimtetemperatuur,Luchtkwaliteit (meting),Ruimtetemperatuur (meting),SP luchtkwaliteit
    ,°C,ppm,°C,ppm
    2023-04-17T00:00:00.0000000,,415.0,20.5,800.0
    2023-04-17T00:05:00.0000000,,415.0,20.5,800.0
    2023-04-17T00:10:00.0000000,,415.0,20.5,800.0
    2023-04-17T00:15:00.0000000,,415.0,20.5,800.0
    2023-04-17T00:20:00.0000000,,415.0,20.5,800.0
    2023-04-17T00:25:00.0000000,,415.0,20.5,800.0
    2023-04-17T00:30:00.0000000,,415.0,20.5,800.0
    2023-04-17T00:35:00.0000000,,416.0,20.5,800.0
    2023-04-17T00:40:00.0000000,,415.0,20.5,800.0
    2023-04-17T00:45:00.0000000,,415.0,20.5,800.0";

    Storage::fake('local');
    $this->seed();

    Storage::disk('local')->put('app/temp.csv', $csvContent);
    $path = Storage::disk('local')->path('app/temp.csv');
    $file = new UploadedFile(
        $path,
        'temp.csv',
        'text/csv',
        null,
        true
    );

    $this->post('/rooms/import', [
        'room_times' => $file,
        'set_room' => 1
    ]);

    $count = DB::table('room_times')->where('room_id', 1)->count();
    expect($count)->toBe(10);

    Storage::disk('local')->delete('temp.csv');
})->uses(RefreshDatabase::class);


test('throws an error when invalid file submitted', function () {
    $csvContent = "Timestamp,Gew.ruimtetemperatuur,Luchtkwaliteit (meting),Ruimtetemperatuur (meting),SP luchtkwaliteit
    ,°C,ppm,°C,ppm
    2023-04-17T00:00:00.0000000,12,,20.5,800.0
    2023-04-17T00:05:00.0000000,12,,20.5,800.0
    2023-04-17T00:10:00.0000000,12,,20.5,800.0
    2023-04-17T00:15:00.0000000,12,,20.5,800.0
    2023-04-17T00:20:00.0000000,12,,20.5,800.0
    2023-04-17T00:25:00.0000000,12,,20.5,800.0
    2023-04-17T00:30:00.0000000,12,,20.5,800.0
    2023-04-17T00:35:00.0000000,12,,20.5,800.0
    2023-04-17T00:40:00.0000000,12,,20.5,800.0
    2023-04-17T00:45:00.0000000,12,,20.5,800.0";

    Storage::fake('local');
    $this->seed();

    Storage::disk('local')->put('app/temp.csv', $csvContent);
    $path = Storage::disk('local')->path('app/temp.csv');
    $file = new UploadedFile(
        $path,
        'temp.csv',
        'text/csv',
        null,
        true
    );

    $response = $this->post('/rooms/import', [
        'room_times' => $file,
        'set_room' => 1
    ]);

    $response->assertSessionHasErrors(['errorTime' => "* File has invalid columns. Make sure the file is the correct format. (Column 1: Time, Column 3: CO2, Column 4: Temperature)"]);

    Storage::disk('local')->delete('temp.csv');
})->uses(RefreshDatabase::class);

test('ajax call for chart data returns information', function () {
    DB::table('rooms')->insert([
        'id' => 1,
        'name' => 'RC011',
        'floor' => 0,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    \Database\Factories\RoomTimeFactory::new()->create([
        'room_id' => 1,
        'time' => '2023-04-17T00:05:00.0000000',
        'co2' => 415,
        'temperature' => 20.5,
    ]);

    $response = $this->get('/model-data/RC011');
    expect(count($response->original))->toBe(1);
})->uses(RefreshDatabase::class);

test('ajax call does not recieve anything when empty data', function () {
    DB::table('rooms')->insert([
        'id' => 1,
        'name' => 'RC011',
        'floor' => 0,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    $response = $this->get('/model-data/RC011');
    expect(count($response->original))->toBe(0);
})->uses(RefreshDatabase::class);
