<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Group;
use App\Models\Setting;
use App\Models\Streaming;
use Willywes\AgoraSDK\RtcTokenBuilder;
use phpDocumentor\Reflection\Types\Boolean;
//obtenir jeton d'authentification dans laravel
class Helper
{
    public static function GetAgoraToken($user_id, $ch) {
    
        $appID = "0ec8c79b7d384bdf834b597a8c130267";
        $appCertificate = "dea158406ec34037bf85a15af1beb776";
        $channelName = $ch;
        $uid = $user_id;
        $uidStr = ($user_id) . '';
        $role = RtcTokenBuilder::RolePublisher;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new \DateTime("now", new \DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
    
        return RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
    
    }


    public static function nextGroupSession($groupId) {
        
        $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $group_days = array(); // Monday(1), Tuesday(2) , Wednesday(3), Thursday(4)
        $today = Carbon::now()->dayOfWeek; // Monday(1)  
        $group = Group::find($groupId);
  
        foreach ($group->days as $day) {
            array_push($group_days, array_search($day->day, $days));
            
        }

        if($today - max($group_days) >= 0) {
            $next_session = min($group_days);

        } else {
            $i = 0;
            foreach($group_days as $day) {
                if($today - $day >= 0 ) {
                    unset($group_days[$i]);  
                }
                $i++;
            }
            $next_session = min($group_days);

        }

        $dateOfNextSession = Carbon::now()->next($days[$next_session]);

        return $dateOfNextSession;
    
    }

    public static function settings() {
        return Setting::find(1);
    }

    public static function lastStream($group_id) {
        
        return Streaming::where('expired', 1)
            ->where('group_id', $group_id)
            ->orderBy("id", "desc")
            ->first();
    }

    public static function streamInProgress($group_id) {
        return Streaming::where('expired', 0)
            ->where('group_id', $group_id)
            ->orderBy("id", "desc")
            ->first();
    }

}

?>