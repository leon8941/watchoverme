<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CheckStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:streams';

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
        //
        $this->checkStreams();
    }

    public function checkStreams()
    {

        $users = User::select('id','twitch')
            ->whereNotNull('twitch')
            ->where('twitch','!=','')
            ->get();


        //
        foreach ($users as $user) {

            $info = $this->getTwitchChannelInfo($user->twitch);

            User::where('id',$user->id)->update([
                'twitch_status' => $info['mature'],
                'twitch_followers' => $info['followers'],
                'twitch_views' => $info['views'],
                'twitch_logo' => $info['logo'],
                'twitch_banner' => $info['banner'],
                'twitch_title' => $info['status'],
            ]);

            $this->info('channel ' . $user->twitch . ' updated');

            sleep(1);
        }

    }

    public function getTwitchChannelInfo($channelName)
    {

        $channelsApi = 'https://api.twitch.tv/kraken/channels/';

        $clientId = 'h6b0lkg3c14e4h068thlrzy4sgp7t4';
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                'Client-ID: ' . $clientId
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $channelsApi . $channelName
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, TRUE);

    }
}
