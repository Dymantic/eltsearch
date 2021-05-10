<?php

namespace App\Purchasing;

use App\DateFormatter;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Purchase extends Model
{
    use HasFactory;

    const SECURE_3DS_APPROVED = '3ds_approved';
    const SECURE_3DS_CANCELLED = '3ds_cancelled';

    protected $fillable = [
        'user_id',
        'package_id',
        'price',
        'paid',
        'currency',
        'card_last_four',
        'card_type',
        'gateway_ref_no',
        'gateway_status',
        'gateway_error',
        'ref_no',
        'purchase_uuid',
    ];

    protected $casts = [
        'paid'  => 'boolean',
        'price' => 'integer',
    ];

    public function scopeSince($query, Carbon $cutoff)
    {
        return $query->where('created_at', '>=', $cutoff);
    }

    public function scopePaid($query)
    {
        return $query->where('paid', true);
    }

    public function customer()
    {
        return $this->morphTo();
    }

    public static function nextRefNumber(): string
    {
        return sprintf("%s%s", Str::of(Str::random(3))->upper(), now()->format('Ymd'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function complete3DSFlow()
    {
        $this->gateway_status = static::SECURE_3DS_APPROVED;
        $this->paid = true;
        $this->save();
        $package = Package::find($this->package_id);
        $this->customer->addPackage($package, $this);
    }

    public function cancelled3DSFlow()
    {
        $this->gateway_status = static::SECURE_3DS_CANCELLED;
        $this->paid = false;
        $this->save();
    }

    public function toArray()
    {
        return [
            'id'             => $this->id,
            'user'           => $this->user,
            'package'        => Package::find($this->package_id)->present(),
            'price'          => $this->price,
            'paid'           => $this->paid,
            'currency'       => $this->currency,
            'card_last_four' => $this->card_last_four,
            'card_type'      => $this->card_type,
            'gateway_ref_no' => $this->gateway_ref_no,
            'ref_no'         => $this->ref_no,
            'purchase_date'  => DateFormatter::PRETTY($this->created_at),
            'error'          => $this->gateway_error,
            'gateway_status' => $this->gateway_status,
        ];
    }
}
