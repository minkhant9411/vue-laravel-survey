<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class SurveyResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'image_url' => $this->image ? URL::to($this->image) : null,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status ? true : false,
            'description' => $this->description,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:m'),
            'updated_at' => (new DateTime($this->updated_at))->format('Y-m-d H:i:m'),
            'expire_date' => $this->expire_date ? date("Y-m-d", strtotime($this->expire_date)) : null,
            'questions' => SurveyQuestionResource::collection($this->questions)
        ];
    }
}
