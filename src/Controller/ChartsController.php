<?php

namespace App\Controller;

use App\Repository\ExerciseLogRepository;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChartsController extends AbstractController
{
    #[Route('/{workoutId}/charts', name: 'app_charts',requirements: ['workoutId' => '^\d+$'], methods: ['GET'])]
    public function index(int $workoutId, WorkoutRepository $workoutRepository, ExerciseLogRepository $exerciseLogRepository,
                          ExerciseRepository $exerciseRepository): Response
    {
        $currentWorkout = $workoutRepository->findOneById($workoutId);
        $exerciseLogs =  $exerciseLogRepository->findByWorkoutId($workoutId);

        $do_weight = true;
        foreach ($exerciseLogs as $exerciseLog) {
            if($exerciseLog->getWeight() == 0)
                $do_weight = false;
        }

        $data = array();
        $total = 0;
        if($do_weight){
            foreach ($exerciseLogs as $exerciseLog) {
                $exerciseType = $exerciseLog->getExercise()->getType()->getName();
                $value = $exerciseLog->getNrReps() * $exerciseLog->getWeight();
                if (isset($data[$exerciseType])) {
                    $data[$exerciseType] += $value;
                } else {
                    $data[$exerciseType] = $value;
                }
                $total += $value;
            }

            return $this->render('charts/index.html.twig', [
                'data' => $data,
                'workout' => $currentWorkout,
                'total' =>  $total,
                'unit' => "kg",
            ]);
        }

        foreach ($exerciseLogs as $exerciseLog) {
            $exerciseType = $exerciseLog->getExercise()->getType()->getName();
            $value = $exerciseLog->getDuration();

            if($value == null)
            {
                return $this->render('charts/index.html.twig', [
                    'workout' => $currentWorkout,
                    'data' => $data,
                    'total' =>  $total,
                    'noData' => true,
                ]);
            }

            $hours = (int)$value->format('H');
            $minutes = (int)$value->format('i');
            $totalMinutesPastMidnight = $hours * 60 + $minutes;

            if (isset($data[$exerciseType])) {
                $data[$exerciseType] += $totalMinutesPastMidnight;
            } else {
                $data[$exerciseType] = $totalMinutesPastMidnight;
            }
            $total += $totalMinutesPastMidnight;
        }
        return $this->render('charts/index.html.twig', [
            'data' => $data,
            'workout' => $currentWorkout,
            'total' =>  $total,
            'unit' => "minutes",
        ]);

    }
}
