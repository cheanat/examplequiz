<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'category' => $this->category,
            'difficulty' => $this->difficulty,
            'question' => $this->question,
            'correct_answer' => $this->correct_answer,
            'incorrect_answers' => $this->incorrect_answers,
            'category_id' => $this->category_id,
        ];
    }
}

