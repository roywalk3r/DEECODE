<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'shop_order_items';
    // In ShopOrderItem observer or model events
    public function Order()
    {
        return $this->belongsTo(Order::class, 'shop_order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'shop_product_id');
    }

    public static function boot()
    {
        parent::boot();

        // Update total price after creation or deletion
        static::created(function ($item) {
            $item->order->updateTotalPrice();
            $item->adjustProductQuantity();
        });

        static::deleted(function ($item) {
            $item->order->updateTotalPrice();
            $item->adjustProductQuantity(true); // Revert the quantity if item is deleted
        });

        // Handle quantity adjustments on update
        static::updated(function ($item) {
            $item->order->updateTotalPrice();
            $item->adjustProductQuantity();
        });
    }

    /**
     * Adjust the product quantity based on the item quantity change.
     */
    public function adjustProductQuantity($isDeleted = false): void
    {
        $product = $this->product;
        if ($product) {
            $originalQty = $this->getOriginal('qty');
            $currentQty = $isDeleted ? 0 : $this->qty; // Treat qty as 0 if item is deleted
            $difference = $originalQty - $currentQty;

            // Update product inventory
            $product->qty += $difference;
            $product->save();
        }
    }


}
