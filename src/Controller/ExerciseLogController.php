<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\ExerciseLog;
use App\Form\Type\ExerciseLogType;
use App\Repository\ExerciseLogRepository;
use App\Repository\WorkoutRepository;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseLogController extends AbstractController
{
    #[Route('/{workoutId}/exercise/log', name: 'showWorkout_exerciseLog',
        requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function showWorkout(int $workoutId, ExerciseLogRepository $exerciseLogRepository, WorkoutRepository $workoutRepository): Response
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

            $element = array('exerciseLogId' => $exerciseLog->getId(), 'data' => $exercise);
            $exercises[] = $element;
        }


        return $this->render('exercise_log/showWorkout.html.twig', [
            'workout' => $currentWorkout,
            'exercises' => $exercises,
            'workoutId' => $workoutId
        ]);
    }

    #[Route('/{workoutId}/exercise/log/new_exercise', name: 'newExerciseWorkout_exerciseLog',
        requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function newExerciseWorkout(int $workoutId, WorkoutRepository $workoutRepository): Response
    {
        $currentWorkout = $workoutRepository->findOneById($workoutId);
        ////say workout is currenty empty add exercse/ add another exercise ca text
        $exerciseLog = new ExerciseLog();
        $formExerciseLog = $this->createForm(ExerciseLogType::class, $exerciseLog, [
            'action' => $this->generateUrl('addExerciseWorkout_exerciseLog', ['workoutId' => $workoutId]),
            'method' => 'POST',
        ]);

        return $this->render('exercise_log/newExerciseWorkout.html.twig', [
            'workout' => $currentWorkout,
            'formExerciseLog' => $formExerciseLog,
            'workoutId' => $workoutId,
        ]);
    }

    #[Route('/{workoutId}/exercise/log/new_exercise', name: 'addExerciseWorkout_exerciseLog',
        requirements: ['id' => '^\d+$'], methods: ['POST'])]
    public function addExerciseWorkout(int $workoutId, ExerciseLogRepository $exerciseLogRepository,
                                  WorkoutRepository $workoutRepository, Request $request): Response
    {
        $currentWorkout = $workoutRepository->findOneById($workoutId);
        $exerciseLog = new ExerciseLog();
        $formExerciseLog = $this->createForm(ExerciseLogType::class, $exerciseLog);

        $formExerciseLog->handleRequest($request);
        if ($formExerciseLog->isSubmitted() && $formExerciseLog->isValid()) {
            $exerciseLog->setWorkout($currentWorkout);
            $exerciseLogRepository->saveOne($exerciseLog);
            return $this->redirectToRoute('showWorkout_exerciseLog', ['workoutId' => $workoutId]);
        }

        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Error-ExerciseLog',
            'action' => 'created',
            'success' => true,
        ]);
    }

    #[Route('/{exerciseLogId}/exercise/log/set', name: 'deleteExerciseWorkout_exerciseLog',
        requirements: ['id' => '^\d+$'], methods: ['DELETE'])]
    public function deleteExerciseWorkout(int $exerciseLogId, ExerciseLogRepository $exerciseLogRepository): Response
    {
        $exerciseLog = $exerciseLogRepository->findOneById($exerciseLogId);
        $id = $exerciseLog->getWorkout()->getId();
        $exerciseLogRepository->deleteOneById($exerciseLogId);
        return $this->redirectToRoute('showWorkout_exerciseLog', ['workoutId' => $id]);
    }





}