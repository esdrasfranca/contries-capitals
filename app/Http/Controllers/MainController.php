<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class MainController extends Controller
{
    private array $appData;

    public function __construct()
    {
        $this->appData = require(app_path('appData.php'));
    }

    public function startGame(): View
    {
        return view('home');
    }

    public function prepareGame(Request $request)
    {
        // Valida formulário
        $request->validate([
            'total_questions' => 'required|integer|min:3|max:30'
        ], [
            'total_questions.required' => 'O número de questões é obrigatório',
            'total_questions.integer' => 'O número de questões deve ser um número inteiro',
            'total_questions.min' => 'O número de questões deve ser no mínimo :min',
            'total_questions.max' => 'O número de questões deve ser no máximo :max'
        ]);

        // Pega número de questões
        $totalQuestions = intval($request->input('total_questions'));

        // Prepara o quiz
        $quiz = $this->prepareQuiz($totalQuestions);

        // Salva o quiz na sessão do usuário
        session()->put([
            "quiz" => $quiz,
            "total_questions" => $totalQuestions,
            "current_question" => 1,
            "correct_answers" => 0,
            "wrong_answers" => 0
        ]);

        return redirect()->route('game');
    }

    public function game()
    {
        $quiz = session()->get('quiz');
        $totalQuestions = session()->get('total_questions');
        $currentQuestion = session()->get('current_question') - 1;

        $quiz[$currentQuestion]['alternatives'][] = $quiz[$currentQuestion]['correct_answer'];
        shuffle($quiz[$currentQuestion]['alternatives']);

        return view('game')->with([
            'country' => $quiz[$currentQuestion]['country'],
            'alternatives' => $quiz[$currentQuestion]['alternatives'],
            'total_questions' => $totalQuestions,
            'current_question' => $currentQuestion + 1
        ]);
    }

    public function answer(string $encryptAnswer)
    {
        try {
            $answer = Crypt::decryptString($encryptAnswer);
        } catch (\Throwable $th) {
            return redirect()->route('game');
        }

        $data = $this->gameLogic($answer);

        return view('answer_result', $data);
    }

    public function nextQuestion()
    {
        $currentQuestion = session()->get('current_question');
        $totalQuestions = session()->get('total_questions');

        if ($currentQuestion < $totalQuestions) {
            $currentQuestion++;
            session()->put('current_question', $currentQuestion);
            return redirect()->route('game');
        } else {
            return redirect()->route('result');
        }
    }

    public function showResults()
    {
        $totalQuestions = session()->get('total_questions');
        $correctQuestions = session()->get('correct_answers');

        $score = ($correctQuestions * 100) / $totalQuestions;

        return view('final_result', ['score' => intval($score)]);
    }

    private function gameLogic(string $answer)
    {
        $quiz = session()->get('quiz');

        $currentQuestion = session()->get('current_question') - 1;
        $correctAnswer = $quiz[$currentQuestion]['correct_answer'];
        $correctAnswers = session()->get('correct_answers');
        $wrongAnswers = session()->get('wrong_answers');

        if ($answer == $correctAnswer) {
            $correctAnswers++;
            $quiz[$currentQuestion]['correct'] = true;
        } else {
            $wrongAnswers++;
            $quiz[$currentQuestion]['correct'] = false;
        }

        session()->put([
            'quiz' => $quiz,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers
        ]);

        $data = [
            'country' => $quiz[$currentQuestion]['country'],
            'correct_answer' => $correctAnswer,
            'choice_answer' => $answer,
            'current_question' => $currentQuestion + 1,
            'total_questions' => session()->get('total_questions')
        ];

        return $data;
    }

    private function prepareQuiz($totalQuestions)
    {
        $questions = [];
        $totalCountries = count($this->appData);

        $indexes = range(0, $totalCountries - 1);
        shuffle($indexes);

        $indexes = array_slice($indexes, 0, $totalQuestions);

        $questionNumber = 1;
        foreach ($indexes as $index) {
            $question['question_number'] = $questionNumber;
            $question['country'] = $this->appData[$index]['country'];
            $question['correct_answer'] = $this->appData[$index]['capital'];

            $otherCaptals = array_column($this->appData, 'capital');
            $otherCaptals = array_diff($otherCaptals, [$question['correct_answer']]);
            shuffle($otherCaptals);

            $question['alternatives'] = array_slice($otherCaptals, 0, 3);

            $question['correct'] = null;

            $questions[] = $question;
            $questionNumber++;
        }

        return $questions;
    }
}
