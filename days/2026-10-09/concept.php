namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\ModelsExporter;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function toExcel($name = 'users.xlsx')
    {
        $exporter = new Exporter(new self);
        $exporter->columns(['id', 'name', 'email'])->sheet($name)->toFile(public_path('exports/'.$name));
    }
}

class Order extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    public function toExcel($name = 'orders.xlsx')
    {
        $exporter = new Exporter(new self);
        $exporter->columns(['id', 'user_id', 'product_id', 'quantity'])->sheet('Orders')->toFile(public_path('exports/'.$name));
    }
}