<?php

namespace App\Services\AverageMark;

use App\Models\Track;
use App\Models\Answer;

class AverageMarkTrack
{
    public static function getMark(Track $track, &$score = 0, &$countMarks = 0): array
    {

        $blocks = $track->blocks->load('exercises');

        if ($blocks->count() <= 0 ) return BaseAverageMark::getStats();

        foreach($blocks as $block) {
            $exerciseData = AverageMarkBlock::getMark($block, $score, $countMarks);
            $countMarks += $exerciseData['countMarks'];
            $score += $exerciseData['score'];
        }

        if($countMarks === 0) return BaseAverageMark::getStats();

        return BaseAverageMark::getStats(
            $countMarks,
            $score,
            round($score / $countMarks, 1),
        );
    }
}
