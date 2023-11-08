<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title'=> $this->title,
            'description' => $this->title,
            'due_date'=> $this->due_date,
            'created_by' => $this->created_by,
            'assignee_id' => $this->assignee_id,
            'status' => $this->status,
            'creator_object' => new UserResource($this->whenLoaded('created_by_user')),
            'assignee_object' => new UserResource($this->whenLoaded('created_by_user')),
            'created_at' => $this->created_at,
        ];
    }
}
