<div class="row" wire:poll.1000ms="getComputerInfo">
    <div class="col mb-3">
        <div class="card text-center">
            <div class="card-header">Mémoire</div>
            <div class="card-body">
                <h5 class="card-title">{{ $usedMemory }} / {{ $totalMemory }} Go</h5>
            </div>
        </div>
    </div>
    <div class="col mb-3">
        <div class="card  text-center">
            <div class="card-header">Processeur</div>
            <div class="card-body">
                <h5 class="card-title">{{ $cpuPercentage }} %</h5>
            </div>
        </div>
    </div>
</div>
