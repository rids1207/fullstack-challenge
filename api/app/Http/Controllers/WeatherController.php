<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserWeather;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    /**
     * Get Users data with Weather
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers()
    {
        try {

            // Get users data with user Weather
            $users = User::with('userWeather')->get();
            
            return response()->json([
                'status' => "Success",
                'userData' => $users,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Fail",
                'message' => $th,
            ], 400);
        }
    }

    /**
     * update User Weather
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserWeather()
    {
        try {

            // Call API key
            $apiKey = env('WEATHER_API_KEY');

            // Check API is exist.
            if (empty($apiKey)) {
                return response()->json([
                    'status' => "Fail",
                    'message' => 'Missing API key.',
                ], 400);
            }

            // Get all users
            $users = User::get();

            foreach ($users as $user) {
                $url = "https://api.openweathermap.org/data/2.5/weather?lat=$user->latitude&lon=$user->longitude&appid=$apiKey&units=metric";

                // Call Weather API
                $client = new Client();
                $response = $client->get($url);
                $data = $response->getBody();

                $userWeather = UserWeather::find($user->id);
                if (!$userWeather) {
                    $userWeather = new UserWeather;
                }
                $userWeather->user_id = $user->id;
                $userWeather->weather_data = $data;
                $userWeather->save();
            }
            
            Log::info('User Weather updated successfully');

            return response()->json([
                'status' => "Success",
                'message' => 'User Weather updated successfully!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "Fail",
                'message' => $th,
            ], 400);
        }
    }
}
