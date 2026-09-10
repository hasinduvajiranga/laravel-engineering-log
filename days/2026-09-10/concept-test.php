// File: app/Transformers/UserCollectionTransformer.php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class UserCollectionTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function transform($request)
    {
        return UserTransformer::collection($this);
    }
}