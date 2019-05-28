<?php

use Illuminate\Database\Seeder;
use Imageplus\Geocoder\Geocode;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $geocode = new Geocode();
        foreach ($this->makeCSV(Storage::disk('local')->path('location_data.csv')) as $entry) {
            DB::table('locations')->insert(array_merge($entry, $geocode->geocode($entry['postcode'], 'opencage'))) ;
        }
    }

    //thanks stackoverflow
    private function makeCSV($file)
    {
        $delimiter = ',';
        $header = null;
        $data = [];

        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}
