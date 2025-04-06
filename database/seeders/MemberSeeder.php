<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = config('members');

        foreach ($members as $member) {
            Member::query()->firstOrCreate(
                [
                    'number' => $member['number'],
                    'color' => $member['color'],
                    'reaction_time' => $member['reaction_time'],
                    'boost' => $member['boost'],
                    'max_speed' => $member['max_speed'],
                    'speed_loss' => $member['speed_loss'],
                    'stability_from' => $member['stability_from'],
                    'stability_to' => $member['stability_to'],
                ],
            );
        }
    }
}
