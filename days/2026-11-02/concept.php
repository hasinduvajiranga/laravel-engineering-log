// File: app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    /**
     * Get the ETag for the model.
     *
     * @return string
     */
    public function getEtag(Request $request)
    {
        $this->touches = true; // This will force ETags to be generated for this model

        $etag = parent::getEtag($request);
        return $etag;
    }
}