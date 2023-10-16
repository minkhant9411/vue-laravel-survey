<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class SurveyResourceDashboard extends JsonResource {
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
            'status' => $this->status ? 'active' : 'draft',
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:m'),
            'expire_date' => $this->expire_date ? date("Y-m-d H:i:m", strtotime($this->expire_date)) : null,
            'questions' => $this->questions->count(),
            'answers' => $this->answers->count()
        ];
    }
}
