<?php

use Illuminate\Database\Seeder;

class DutySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$driverarray = [9, 10, 103, 137, 140, 163, 164, 165, 166, 167, 196, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 210, 211, 257, 261, 322, 778, 779, 787, 788, 828, 844, 845, 846, 1578, 1605];
		$driversUpdate = App\User::whereIn('id', $driverarray)->update(['duty' => 'Driver']);

		$frmearray = [109, 276, 277, 278, 301, 309, 363, 401, 429, 430, 433, 478, 556, 603, 638, 640, 659, 661, 719, 723, 790, 791, 813, 830, 855, 894, 915, 994, 1065, 1196, 1235, 1501, 1502, 1509, 1510, 1533, 1534, 1554];
		$FRMEUpdate = App\User::whereIn('id', $frmearray)->update(['duty' => 'FRME']);

		$zonalarray = [300, 311, 342, 551, 602, 848, 942, 1023, 1254, 1498];
		$ZonalUpdate = App\User::whereIn('id', $zonalarray)->update(['duty' => 'Zonal']);
    }
}
