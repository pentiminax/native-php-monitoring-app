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
        $cpuPercentage = shell_exec('powershell -command "Get-WmiObject -Class Win32_Processor | ForEach-Object { $_.LoadPercentage }"');

        $this->cpuPercentage = intval($cpuPercentage, 0) * $this->numberOfCores;
    }

    private function getNumberOfCores(): void
    {
        $numberOfLogicalProcessors = shell_exec('powershell -command "(Get-CimInstance Win32_Processor).NumberOfCores"');

        $this->numberOfCores = intval($numberOfLogicalProcessors,0);
    }

    private function getTotalMemory(): void
    {
        $totalMemory = shell_exec('powershell -command "(Get-WmiObject -Class Win32_ComputerSystem).TotalPhysicalMemory"');

        $this->totalMemory = round($totalMemory / 1024 / 1024 / 1024);
    }

    private function getUsedMemory(): void
    {
        $freeMemory = shell_exec('powershell -command "(Get-WmiObject -Class Win32_OperatingSystem).FreePhysicalMemory"');

        $this->usedMemory = $this->totalMemory - round($freeMemory / 1024 / 1024, 2);
    }

    private function isMemoryLow(): bool
    {
        return $this->usedMemory > ($this->totalMemory / 2);
    }
}
