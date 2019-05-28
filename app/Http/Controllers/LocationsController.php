<?php

namespace App\Http\Controllers;

use App\Locations;
use App\Logs;
use Illuminate\Http\Request;
use Imageplus\Geocoder\Geocode;
use App\Http\Resources\Locations as LocationsResource;
use App\Http\Resources\Logs as LogsResource;

class LocationsController extends Controller
{
    protected $geocode;
    protected $locations;
    protected $logs;
    public function __construct(Geocode $geocode, Locations $locations, Logs $logs)
    {
        $this->logs = $logs;
        $this->locations = $locations;
        $this->geocode = $geocode;
    }

    /**
     * find nearest location between two postcodes
     *
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Location
     */
    public function GetNearestLocation(Request $request)
    {
        $theOne = false;
        try {
            $searchGPS = $this->geocode->geocode($request->postcode, 'postcodeio');
        } catch (\Exception $e) {
            $this->CreateNewLog($request->all(), __('coffeeDrop.error_postcode'), true);
            return __('coffeeDrop.error_postcode');
        }

        $query = $this->GetNearestLocationQuery($searchGPS);

        foreach ($query->get() as $location) {
            $distiance = $this->haversineGreatCircleDistance($searchGPS['lat'], $searchGPS['lng'], $location->lat, $location->lng);
            if (!isset($shortest) || $shortest > $distiance) {
                $shortest = $distiance;
                $theOne = $location->first();
                if ($distiance == 0) {
                    break;
                }
            }
        }
        $theOne['distance'] = $shortest;
        $theOne['start'] = $searchGPS;
        
        $returned = new LocationsResource($theOne);
        $this->CreateNewLog($request->all(), $returned);
        return $returned;
    }

    /**
     * cash back calculator
     *
     * @param $latitudeFrom
     * @return int $total
     */
    public function CalculateCashback(Request $request)
    {
        $total = 0;
        foreach ($request->all() as $key => $value) {
            if ($value <= (int)config('coffeeDrop.limits.low')) {
                $total += $value * config('coffeeDrop.prices.low.'.$key);
            } elseif ($value <= config('coffeeDrop.limits.mid')) {
                $total += $value * config('coffeeDrop.prices.mid.'.$key);
            } else {
                $total += $value * config('coffeeDrop.prices.high.'.$key);
            }
        }
        $this->CreateNewLog($request->all(), $total);
        return $total;
    }

    /**
     * get logs
     *
     * @param App\Http\Resources\Location $request
     * @param App\Logs $logs
     * @return App\Http\Resources\Location
     */
    public function GetLogs(Request $request)
    {
        if (!isset($request->limit)) {
            $request->limit = config('coffeeDrop.log_return_default');
        }
        return LogsResource::collection($this->GetLogsQuery($request->limit));
    }

    /**
     * create a new location
     *
     * @param Illuminate\Http\Request $request
     * @return App\locations
     */
    public function CreateNewLocation(Request $request)
    {
        try {
            $this->locations->create($request->all());
            $this->CreateNewLog($request->all(), __('coffeeDrop.success_create'));
            return __('coffeeDrop.success_create');
        } catch (\Exception $e) {
            $this->CreateNewLog($request->all(), __('coffeeDrop.error_create'), true);
            return __('coffeeDrop.error_create');
        }
    }

    /**
     * Haversine Great Circle thanks stackoverflow
     *
     * @param float $latitudeFrom
     * @param float $longitudeFrom
     * @param float $latitudeTo
     * @param float $longitudeTo
     * @return float $distance
     */
    private function haversineGreatCircleDistance(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * config('coffeeDrop.earth_radius');
    }

    /**
     * create logs
     *
     * @param  $request
     * @param  $result
     * @param  $error
     */
    private function CreateNewLog($request, $result, $error = null)
    {
        $logs = new Logs();
        $foo = $logs->create([
            'path'  => $_SERVER['PATH_INFO'],
            'ip'  => $_SERVER['REMOTE_ADDR'],
            'request'  => json_encode($request),
            'result'  => json_encode($result),
            'error'    => $error,
        ]);
    }


    //-------------------------------------------------------------------------------------------------------[database query]

    /**
     * get location query
     *
     * @param  array $gps
     * @return  App\Locations
     */
    private function GetNearestLocationQuery(array $gps)
    {
        return $this->locations->where('lat', 'like', substr($gps['lat'], 0, config('coffeeDrop.search_accuracy_lat')).'%')
            ->where('lng', 'like', substr($gps['lng'], 0, config('coffeeDrop.search_accuracy_lng')).'%');
    }

    /**
     * get location query
     *
     * @param  int $limit
     * @return  App\Logs
     */
    private function GetLogsQuery( int $limit)
    {
        return $this->logs->limit($limit)->orderBy('updated_at', 'DESC')->get();
    }
}
