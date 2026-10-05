<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'franchise_id',
        'name',
        'contact',
        'email',
        'balance',
    ];

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'customer_id');
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }

    public function refreshBalance()
    {
        $debits = $this->ledgers()->where('type', 'debit')->sum('amount');
        $credits = $this->ledgers()->where('type', 'credit')->sum('amount');
        
        $this->update(['balance' => $debits - $credits]);
        
        return $this->balance;
    }
}
