<?php

namespace App\Console\Commands\Crawler;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Repositories\ServiceRepository;
use App\Repositories\BranchSalonRepository;
use Illuminate\Support\Str;

class ISalonController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:isalon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ServiceRepository $serviceRepo, BranchSalonRepository $branchSalonRepo)
    {
        parent::__construct();
        $this->client = new Client();
        $this->serviceRepo = $serviceRepo;
        $this->branchSalonRepo = $branchSalonRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = 'https://isalon.vn/api/search/v2';
        $response = $this->client->post($url, [
            'form_params' => ['per_page' => 900]
        ]);
        $salons = $response->getBody()->getContents();
        $salons = json_decode($salons);
        foreach ($salons->items as $salon) {
            $urlDetail = 'https://isalon.vn/api/salon/' . $salon->id . '/detail';
            $response = $this->client->post($urlDetail);
            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            $workTimes = explode(' - ', $data->workTimes);
            $workTimes = [
                'start' => $workTimes[0],
                'end' => $workTimes[1],
            ];
            $arrayService = [];
            foreach($data->cats as $service)
            {
                $newService = $this->convertService($service);
                $slugs = Str::slug($newService['name']);
                $serviceCol = $this->serviceRepo->query(['slugs' => $slugs])->first();
                if (empty($serviceCol)) {
                    $serviceCol = $this->serviceRepo->create($newService);
                }
                $arrayService[] = $serviceCol->id;
            }
            $arrayService = array_unique($arrayService);
            $newSalon = [
                'name' => $data->name,
                'thumb_img' => $data->cover,
                'content' => $data->info,
                'work_time' => $workTimes,
                'admin_id' => 1,
                'address' => $data->address,
                'locations' => [
                    'latitude' => $data->map_lat,
                    'longitude' => $data->map_lng,
                ],
            ];
            $branchSalon = $this->branchSalonRepo->create($newSalon);
            $branchSalon->service()->attach($arrayService);
            $this->info($branchSalon->name);
        }
    }

    public function convertService($service, $parentId = 0)
    {
        $image = $parentId == 0 ? $service->image : $service->cover;
        return [
            'name' => $service->name,
            'price' => $service->priceNumber,
            'service_id' => $parentId,
            'estimate' => '00:00',
            'images' => [$image],
        ];
    }
}
