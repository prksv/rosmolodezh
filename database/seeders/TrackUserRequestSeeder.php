<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Track;
use Illuminate\Database\Seeder;
use App\Models\TrackUserRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrackUserRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $tracks = Track::all();
        $tracks_ids = [];
        foreach ($tracks as $track) {
            $tracks_ids[] = $track->id;
        }

        foreach ($users as $user) {
            if ($user->id > 6) {
                TrackUserRequest::create([
                    'user_id_sender'=>$user->id,
                    'track_id'=>$tracks_ids[array_rand($tracks_ids)],
                    'joining'=>true,
                    'refused'=>false,
                    'action'=>'send',
                ]);
            } elseif ($user->role->name != 'admin') {
                $user->tracksWhereTeacher()->toggle(Track::find(1));
                $user->tracksWhereTeacher()->toggle(Track::find(2));
                $user->tracksWhereTeacher()->toggle(Track::find(3));
            }
        }

    }
}
