<?php

namespace Asad\Vend\Command;

use Illuminate\Console\Command;

use Asad\Vend\Models\VendOauthSetting;
use Asad\Vend\Controllers\VendController;

class VendAuthentication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vend:authentication';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $client_id = $this->ask('Input VEND client id');
        $vend_setting = VendOauthSetting::where('client_id', $client_id)->first();

        if (!is_null($vend_setting) && $vend_setting->access_token != null) {
            if (!$this->confirm('Access token already exist. Do you want to continue?')) {
                exit;
            }
        }

        $client_secret  = $this->ask('Input VEND client secret');
        $client_domain  = $this->ask('Input client domain (ex: example.com)');
        $protocol       = $this->choice('Select your protocol.', ['http', 'https'], 0);
        $redirect_route =  $protocol .'://'. rtrim($client_domain, '/') . '/vendOauth2back';

        
        $redirect_url = 'https://secure.vendhq.com/connect?response_type=code&client_id='.$client_id.'&redirect_uri='.$redirect_route.'&state=au';

        $flight = VendOauthSetting::updateOrCreate(
            ['client_id' => $client_id],
            [
                'client_id'         => $client_id, 
                'client_secret'     => $client_secret,
                'client_domain'     => $client_domain,
                'protocol'          => $protocol,
            ]
        );

        $this->info('Copy the following url, past on browser and hit return.');
        $this->line($redirect_url);
    }
}
