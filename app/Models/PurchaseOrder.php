<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;

class PurchaseOrder extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'supplier_id',
        'order_date',
        'expected_delivery_date',
        'notes',
        'status',
        'user_id',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'expected_delivery_date' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'notes'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn($eventName) => "Purchase Order berhasil {$eventName}");
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $supplierName = null;

        if ($this->relationLoaded('supplier') && $this->supplier) {
            $supplierName = $this->supplier->name;
        } elseif ($this->supplier_id) {
            $supplierName = DB::table('suppliers')->where('id', $this->supplier_id)->value('name');
        }

        $activity->properties = $activity->properties->put('supplier_name', $supplierName ?? 'Supplier tidak ditemukan');
    }
}
