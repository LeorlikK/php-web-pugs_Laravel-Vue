<?php

namespace App\Service;

use App\Models\Audio;
use App\Models\News;
use App\Models\Photo;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class StatisticsService
{
    public function usersStatistics(): array
    {
        $users = User::selectRaw('COUNT(*) as all_count, SUM(banned) as banned_count')->first();
        $usersAllCount = (int) $users->all_count;
        $usersBannedCount = (int) $users->banned_count;
        $usersFromLastTwoWeeks = User::where('created_at', '>', now()->subWeeks(2))->get(['id' , 'created_at']);
        $newUsersLastWeek = $usersFromLastTwoWeeks->where('created_at', '>', now()->subWeek())->count();
        $newUsersTwoWeekAgo = $usersFromLastTwoWeeks->where('created_at', '<', now()->subWeek())->count();

        if ($newUsersTwoWeekAgo == 0) {
            $usersDifferencePercentWeeks = (int) ($newUsersLastWeek . 0);
        } else {
            $usersDifferencePercentWeeks = (float) bcdiv((($newUsersLastWeek - $newUsersTwoWeekAgo) /
                    $newUsersTwoWeekAgo) * 100, 1, 2);
        }

        return [
            'usersAllCount' => $usersAllCount,
            'usersBannedCount' => $usersBannedCount,
            'newUsersLastWeek' => $newUsersLastWeek,
            'newUsersTwoWeekAgo' => $newUsersTwoWeekAgo,
            'usersDifferencePercentWeeks' => $usersDifferencePercentWeeks,
        ];
    }

    public function mediaStatistics(): array
    {
        $photo = Photo::selectRaw('COUNT(*) as photo_count, SUM(size) as photo_sum')->first();
        $video = Video::selectRaw('COUNT(*) as video_count, SUM(size) as video_sum')->first();
        $audio = Audio::selectRaw('COUNT(*) as audio_count, SUM(size) as audio_sum')->first();

        return [
            'photoCount' => $photo->photo_count,
            'photoSizeSum' => (int) $photo->photo_sum,
            'videoCount' => $video->video_count,
            'videoSizeSum' => (int) $video->video_sum,
            'audioCount' => $audio->audio_count,
            'audioSizeSum' => (int) $audio->audio_sum,
            'allMediaSize' => (int) ($photo->photo_sum + $video->video_sum + $audio->audio_sum)
        ];
    }

    public function newsStatistics(): array
    {
        return News::select('users.login', DB::raw('COUNT(*) as news_count'))
            ->where('news.created_at', '>', now()->subWeek())
            ->join('users', 'news.user_id', '=', 'users.id')
            ->groupBy('users.login')
            ->pluck('news_count', 'login')
            ->toArray();
    }

    public function commentsStatistics()
    {

    }

    public function fullStatistics(): array
    {
        $users = $this->usersStatistics();
        $media = $this->mediaStatistics();
        $news = $this->newsStatistics();
        return [
            'users' => $users,
            'media' => $media,
            'news' => $news
        ];
    }
}
