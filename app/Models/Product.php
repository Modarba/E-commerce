<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'quantity', 'image', 'category_id'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public static function searchByName(string $name)
    {
        return self::where('name', 'like', $name . '%')->get();
    }
    public function updatePrice(float $price)
    {
        $this->update(['price' => $price]);
        return $this;
    }
    public static function deleteProduct(int $id)
    {
        $product = self::findOrFail($id);
        $product->delete();
        return ['message' => 'success'];
    }
    public static function showAll()
    {
        return self::all();
    }
}
