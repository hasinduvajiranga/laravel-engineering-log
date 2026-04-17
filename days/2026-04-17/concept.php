// File: App/Macros/Validator.php

namespace App\Macros;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

macro "validate($attribute, $rules = [])"
{
    return function (array $data) use ($attribute, $rules)
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // You can also return the validated data here
        // return $validatedData;
    };
}