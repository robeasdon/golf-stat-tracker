<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Repositories\Contracts\RoundRepositoryInterface;
use Illuminate\Contracts\Auth\Guard;

class RoundRequest extends Request
{
    /**
     * @var RoundRepositoryInterface
     */
    private $round;

    /**
     *
     *
     * @param RoundRepositoryInterface $round
     */
    public function __construct(RoundRepositoryInterface $round)
    {
        $this->round = $round;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'course' => 'required|exists:courses,id',
            'teeType' => 'required|exists:tee_types,id'
        ];

        for ($i = 1; $i <= 18; $i++) {
            $rules["scores.{$i}"] = 'required|integer|between:1,99';
            $rules["putts.{$i}"] = 'required|integer|between:0,99|max:' . ($this->request->get('scores')[$i] - 1);
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];

        for ($i = 1; $i <= 18; $i++) {
            $messages["scores.{$i}.required"] = "A score on hole {$i} is required.";
            $messages["scores.{$i}.integer"] = "The score on hole {$i} must be an integer.";
            $messages["scores.{$i}.between"] = "The score on hole {$i} must be between :min and :max.";

            $messages["putts.{$i}.required"] = "Putts on hole {$i} is required.";
            $messages["putts.{$i}.integer"] = "The putts on hole {$i} must be an integer.";
            $messages["putts.{$i}.between"] = "The putts on hole {$i} must be between :min and :max.";
            $messages["putts.{$i}.max"] = "The putts on hole {$i} must be less than the score.";
        }

        return $messages;
    }

    protected function checkRoundBelongsToUser()
    {
        $userId = $this->user()->id;
        $roundId = $this->route('rounds');

        return $this->round->checkRoundBelongsToUser($userId, $roundId);
    }
}
