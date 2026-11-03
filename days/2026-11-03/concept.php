// File: app/Http/Controllers/EloquentApiController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\MyModel; // Replace with your actual model name

class EloquentApiController extends Controller
{
    public function index()
    {
        $models = MyModel::latest()->take(10)->get();
        return response($models, 200)
            ->header('Last-Modified', Carbon::now()->toRfc3328());
    }

    public function show($id)
    {
        $model = MyModel::find($id);
        if (!$model) {
            return response(null, 404);
        }
        return response($model, 200)
            ->header('Last-Modified', Carbon::now()->toRfc3328());
    }

    public function store(Request $request)
    {
        // Process the request...
        $model = new MyModel();
        $model->fill($request->all());
        $model->save();
        return response($model, 201)
            ->header('Last-Modified', Carbon::now()->toRfc3328());
    }

    public function update(Request $request, $id)
    {
        // Process the request...
        $model = MyModel::find($id);
        if (!$model) {
            return response(null, 404);
        }
        $model->fill($request->all());
        $model->save();
        return response($model, 200)
            ->header('Last-Modified', Carbon::now()->toRfc3328());
    }

    public function destroy($id)
    {
        // Process the request...
        $model = MyModel::find($id);
        if (!$model) {
            return response(null, 404);
        }
        $model->delete();
        return response(null, 204);
    }
}