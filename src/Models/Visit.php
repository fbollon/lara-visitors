<?php

namespace Fbollon\LaraVisitors\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('laravisitors.visits_table', 'visits');
    }

    protected $guarded = [];

    public function scopeDateRange($query, $start = null, $end = null)
    {
        $start = Carbon::parse($start ?? now()->subDays(7))->startOfDay();
        $end = Carbon::parse($end ?? now())->endOfDay();

        return $query->whereBetween($this->table.'.created_at', [$start, $end]);
    }
}
