// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\View\Composers\PrecioComposer;

class HomeController extends Controller
{
    public function index(PrecioComposer $precio)
    {
        // Composer is passed to the view as a parameter, not as an instance of the class.
        return view('home', ['precio' => $precio->getValor()]);
    }
}

// app/View/Composers/PrecioComposer.php

namespace App\View\Composers;

use Illuminate\View\Component;
use App\Models\Precio;

class PrecioComposer extends Component
{
    public function __construct()
    {
        // Retrieve all prices from the database.
        $this->precio = Precio::all();
    }

    public function getValor()
    {
        // Return the value of the price for display in the view.
        return $this->precio[0]->valor;
    }
}