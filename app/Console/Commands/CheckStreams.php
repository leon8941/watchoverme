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

        $users = User::select('twitch')
            ->whereNotNull('twitch')
            ->where('twitch','!=','')
            ->get();

        /*
        $total = $users->count();
        $channels = '';
        $i = 1;
*/
        //
        foreach ($users as $user) {
/*
            if ($user->twitch && !empty($user->twitch))
                $channels .= $user->twitch;

            if ($i < $total)
                $channels .= ',';

            $i++;*/
            $info = $this->getTwitchChannelInfo($user->twitch);

            print_r($info);
            User::where('id',$user->id)->update([
                'twitch_status' => $info['mature'],
                'twitch_followers' => $info['followers'],
                'twitch_views' => $info['views'],
                'twitch_logo' => $info['logo'],
                'twitch_banner' => $info['banner'],
            ]);

            $this->info('channel ' . $user->twitch . ' updated');
        }

    }

    public function getTwitchChannelInfo($channelName)
    {

        $channelsApi = 'https://api.twitch.tv/kraken/channels/';
        //$channelName = $channel? $channel : 'wraxu';
        //$channelName = $channel;
        //$channelName = 'wraxu';
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
