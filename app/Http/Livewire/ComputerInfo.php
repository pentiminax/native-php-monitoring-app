<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Native\Laravel\Notification;

class ComputerInfo extends Component
{
    public int $cpuPercentage = 0;
    public float $usedMemory = 0;
    public float $totalMemory = 0;
    public int $numberOfCores = 0;

    public function mount(): void
    {
        if (PHP_OS_FAMILY !== 'Windows') {
            return;
        }

        $this->getNumberOfCores();
        $this->getComputerInfo();
    }

    public function render(): View
    {
        return view('livewire.computer-info');
    }

    public function getComputerInfo(): void
    {
        if (PHP_OS_FAMILY !== 'Windows') {
            return;
        }

        $this->getCpuPercentage();
        $this->getTotalMemory();
        $this->getUsedMemory();

        if ($this->isMemoryLow()) {
            Notification::new()
                ->title('Memory alert')
                ->message('You are running out of memory!')
                ->show();
        }
    }

    private function getCpuPercentage(): void
    {
        exec('wmic cpu get LoadPercentage 2>&1', $cpuPercentageOutput);

        $this->cpuPercentage = intval($cpuPercentageOutput[1], 0) * $this->numberOfCores;
    }

    private function getNumberOfCores(): void
    {
        exec('wmic cpu get NumberOfCores 2>&1', $numberOfCoreOutput);

        $this->numberOfCores = $numberOfCoreOutput[1];
    }

    private function getTotalMemory(): void
    {
        exec('wmic ComputerSystem get TotalPhysicalMemory 2>&1', $totalMemoryOutput);

        $this->totalMemory = round($totalMemoryOutput[1] / 1024 / 1024 / 1024);
    }

    private function getUsedMemory(): void
    {
        exec('wmic OS get FreePhysicalMemory 2>&1', $freeMemoryOutput);

        $freeMemory = round($freeMemoryOutput[1] / 1024 / 1024, 2);

        $this->usedMemory = $this->totalMemory - $freeMemory;
    }

    private function isMemoryLow(): bool
    {
        return $this->usedMemory > ($this->totalMemory / 2);
    }
}
