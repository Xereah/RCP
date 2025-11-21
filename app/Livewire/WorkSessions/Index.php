<?php

declare(strict_types=1);

namespace App\Livewire\WorkSessions;

use App\Models\WorkSession;
use App\Models\WorkStatus;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true, except: '')]
    public string $search = '';

    #[Url(as: 'status', history: true, except: null)]
    public ?int $statusId = null;

    #[Url(as: 'from', history: true, except: null)]
    public ?string $dateFrom = null;

    #[Url(as: 'to', history: true, except: null)]
    public ?string $dateTo = null;

    public ?string $exportFrom = null;

    public ?string $exportTo = null;

    public function render(): View
    {
        $workSessions = $this->filteredQuery()->paginate();
        $statuses = WorkStatus::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('livewire.work-session.index', compact('workSessions', 'statuses'))
            ->with('i', $this->getPage() * $workSessions->perPage());
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusId(): void
    {
        $this->resetPage();
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'statusId', 'dateFrom', 'dateTo');
        $this->resetPage();
    }

    public function export(string $format): StreamedResponse
    {
        abort_unless(in_array($format, ['csv', 'xlsx'], true), 404);

        $this->validate(
            $this->exportRules(),
            [],
            $this->exportAttributes()
        );

        $sessions = $this->exportQuery()->get();
        $rows = $this->mapSessionsToRows($sessions);

        $filename = sprintf(
            'work-sessions_%s_%s.%s',
            Carbon::parse($this->exportFrom)->format('Ymd'),
            Carbon::parse($this->exportTo)->format('Ymd'),
            $format
        );

        $contentType = $format === 'xlsx'
            ? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            : 'text/csv';

        return response()->streamDownload(
            function () use ($rows, $format): void {
                $writer = SimpleExcelWriter::create('php://output', $format);
                $writer->addRows($rows);
                $writer->close();
            },
            $filename,
            [
                'Content-Type' => $contentType,
            ]
        );
    }

    public function delete(WorkSession $workSession)
    {
        $workSession->delete();

        return $this->redirectRoute('work-sessions.index', navigate: true);
    }

    private function filteredQuery(): Builder
    {
        return $this->baseQuery()
            ->when($this->search !== '', function (Builder $query): void {
                $search = Str::of($this->search)->trim()->value();

                if ($search === '') {
                    return;
                }

                $query->whereHas('personel', function (Builder $personel) use ($search): void {
                    $personel->where('personal_number', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->when($this->statusId, fn (Builder $query): Builder => $query->where('status_id', $this->statusId))
            ->when($this->dateFrom, fn (Builder $query): Builder => $query->whereDate('work_date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn (Builder $query): Builder => $query->whereDate('work_date', '<=', $this->dateTo));
    }

    private function exportQuery(): Builder
    {
        return $this->filteredQuery()
            ->when($this->exportFrom, fn (Builder $query): Builder => $query->whereDate('work_date', '>=', $this->exportFrom))
            ->when($this->exportTo, fn (Builder $query): Builder => $query->whereDate('work_date', '<=', $this->exportTo))
            ->orderBy('work_date')
            ->orderBy('start_time');
    }

    private function baseQuery(): Builder
    {
        return WorkSession::query()
            ->with(['personel.position', 'workStatus'])
            ->orderByDesc('work_date')
            ->orderByDesc('start_time');
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    private function mapSessionsToRows(Collection $sessions): array
    {
        return $sessions->map(function (WorkSession $session): array {
            $personel = $session->personel;
            $position = $personel?->position?->name;

            return [
                'Numer personalny' => $personel?->personal_number,
                'Pracownik' => trim((string) $personel?->last_name . ' ' . (string) $personel?->first_name),
                'Stanowisko' => $position,
                'Data' => $session->work_date,
                'Wejście' => $session->start_time,
                'Wyjście' => $session->end_time,
                'Zaliczony czas' => $session->duration_human,
                'Status' => $session->workStatus?->name,
                'Notatki' => $session->notes,
            ];
        })->all();
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function exportRules(): array
    {
        return [
            'exportFrom' => ['required', 'date'],
            'exportTo' => ['required', 'date', 'after_or_equal:exportFrom'],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function exportAttributes(): array
    {
        return [
            'exportFrom' => 'data początkowa eksportu',
            'exportTo' => 'data końcowa eksportu',
        ];
    }
}
