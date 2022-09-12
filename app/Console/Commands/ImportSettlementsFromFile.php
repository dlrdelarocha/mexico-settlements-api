<?php

namespace App\Console\Commands;

use App\Models\Settlement;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportSettlementsFromFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settlements:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import from a txt all the Mexico settlements!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '1024M');
        $fp = fopen(storage_path('settlements/CPdescarga.txt'), 'r') or die('Cannot open');

        $result = array();
        while ($row = utf8_encode(fgets($fp))) {
            if (!Str::contains($row, '|') || Str::contains($row, 'd_codigo')) {
                continue;
            }
            $values = explode('|', $row);

            $result[] = $this->newSettlement($values);
        }

        Settlement::query()->insert($result);

        $this->info("saved");
    }

    private function newSettlement($values)
    {
        list(
            $zipcode,
            $settlementName,
            $settlementType,
            $locality,
            $region,
            $city,
            $managementOffice,
            $regionKey,
            $emptyField,
            $managementOffice,
            $settlementTypeKey2,
            $localityKey,
            $settlementKey,
            $zoneType,
            $cityKey
            ) = $values;

        return [
            'zip_code' => $zipcode,
            'locality' => Str::upper($city),
            'federal_entity_key' => (int)$regionKey,
            'federal_entity_name' => Str::upper($region),
            'federal_entity_code' => null,
            'settlement_key' => (int)$settlementKey,
            'settlement_name' => Str::upper($settlementName),
            'settlement_zone_type' => Str::upper($zoneType),
            'settlement_type' => ['name' => $settlementType],
            'municipality_key' => (int)$localityKey,
            'municipality_name' => Str::upper($locality),
        ];
    }
}
