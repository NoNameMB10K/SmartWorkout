<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\ExerciseLog;
use App\Form\Type\ExerciseLogType;
use App\Repository\ExerciseLogRepository;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseLogController extends AbstractController
{
    #[Route('/{workoutId}/exercise/log', name: 'show_workout_exerciseLog',
        requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function showWorkout(int $workoutId, ExerciseLogRepository $exerciseLogRepository,
                                WorkoutRepository $workoutRepository): Response
    {
        $currentWorkout = $workoutRepository->findOneById($workoutId);
        $exerciseLogs =  $exerciseLogRepository->findByWorkoutId($workoutId);

        $exercises = array();
        foreach ($exerciseLogs as $exerciseLog) {
            $exercise = new Exercise();
            $exercise->setName($exerciseLog->getExercise()->getName());
            $exercise->setId($exerciseLog->getExercise()->getId());
            $exercise->setLinkToVideo($exerciseLog->getExercise()->getLinkToVideo());
            $exercise->setType($exerciseLog->getExercise()->getType());

            $exercises[] = $exercise;
        }

        return $this->render('exercise_log/showWorkout.html.twig', [
            'workout' => $currentWorkout,
            'exercises' => $exercises,
        ]);
    }

    #[Route('/{workoutId}/exercise/log/edit', name: 'edit_workout_exerciseLog',
        requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function editWorkout(int $workoutId, ExerciseLogRepository $exerciseLogRepository,
                                WorkoutRepository $workoutRepository): Response
    {
        $currentWorkout = $workoutRepository->findOneById($workoutId);
        $exerciseLogs =  $exerciseLogRepository->findByWorkoutId($workoutId);

        $exercises = array();
        foreach ($exerciseLogs as $exerciseLog) {
            $exercise = new Exercise();
            $exercise->setName($exerciseLog->getExercise()->getName());
            $exercise->setId($exerciseLog->getExercise()->getId());
            $exercise->setLinkToVideo($exerciseLog->getExercise()->getLinkToVideo());
            $exercise->setType($exerciseLog->getExercise()->getType());

            $exercises[] = $exercise;
        }

        return $this->render('exercise_log/editWorkout.html.twig', [
            'workout' => $currentWorkout,
            'exercises' => $exercises,
            'workoutId' => $workoutId
        ]);
    }

    #[Route('/{workoutId}/exercise/log/new_set', name: 'new_set_workout_exerciseLog',
        requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function newSetWorkout(int $workoutId, ExerciseLogRepository $exerciseLogRepository,
                                  WorkoutRepository $workoutRepository, Request $request): Response
    {
        $currentWorkout = $workoutRepository->findOneById($workoutId);

        $exerciseLog = new ExerciseLog();
        $formExerciseLog = $this->createForm(ExerciseLogType::class, $exerciseLog);

        return $this->render('exercise_log/newSetWorkout.html.twig', [
            'workout' => $currentWorkout,
            'formExerciseLog' => $formExerciseLog,
            'workoutId' => $workoutId,
        ]);
    }


}