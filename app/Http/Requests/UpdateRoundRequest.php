<?php

namespace App\Http\Requests;

class UpdateRoundRequest extends RoundRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->checkRoundBelongsToUser();
    }
}
