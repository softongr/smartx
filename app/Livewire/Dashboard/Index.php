<?php

namespace App\Livewire\Dashboard;


use App\Models\AuditLog;
use App\Models\Product;
use App\Models\Setting;
use App\ProductStep;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Index extends Component
{
    public $settings;

    public $recentActivity = [];
    public $hasError=false;
    public $todayScrapeCount = 0;


    public function mount()
    {

        $settings = Setting::first();
        $this->recentActivity = AuditLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        if (!$settings) {
            $this->hasError=true;
        }
    }
    public function render()
    {


        return view('livewire.dashboard.index',[
            'todayScrapeCount' => 1,
        ]);
    }

    public function todayScrapeCount($step)
    {
        $key = 'today_scrape_count_' . now()->format('Y-m-d');
        return Cache::rememberForever($key, function () use ($step) {
            return Product::where('step', $step)
                ->where('source_method', 'scrape')
                ->whereDate('created_at', Carbon::today())
                ->count();
        });
    }



}
