<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ActivityChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Aktivitas Pengguna';
    protected static ?int $sort = 1;
    protected static ?string $maxHeight = '300px';
    public function getColumnSpan(): int|string
    {
        return 'full';
    }
    
    protected function getData(): array
    {
        $days = 30; // Show data for last 30 days
        $labels = [];
        
        // Generate date labels
        for ($i = $days - 1; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subDays($i)->format('d M');
        }
        
        // User registrations data
        $userRegistrations = $this->getDataForDays($days, function ($date) {
            return User::whereDate('created_at', $date)->count();
        });
        
        // Posts data
        $posts = $this->getDataForDays($days, function ($date) {
            return Post::whereDate('created_at', $date)->count();
        });
        
        // Comments data
        $comments = $this->getDataForDays($days, function ($date) {
            return Comment::whereDate('created_at', $date)->count();
        });
        
        return [
            'datasets' => [
                [
                    'label' => 'Pengguna Baru',
                    'data' => $userRegistrations,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgb(75, 192, 192)',
                ],
                [
                    'label' => 'Post Baru',
                    'data' => $posts,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                ],
                [
                    'label' => 'Komentar Baru',
                    'data' => $comments,
                    'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                    'borderColor' => 'rgb(255, 206, 86)',
                ],
            ],
            'labels' => $labels,
        ];
    }
    
    private function getDataForDays(int $days, callable $callback): array
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $data[] = $callback($date);
        }
        return $data;
    }
    
    protected function getType(): string
    {
        return 'line';
    }
}