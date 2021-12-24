<?php

namespace App\Services;

use App\Models\IncomeTemplate;
use App\Models\IncomeType;
use App\Traits\DimeUtils;
use Carbon\Carbon;

class IncomeService
{
    use DimeUtils;

    /**
     * For employment, create a record for all pay dates in a billing cycle based on user input
     *
     * @param string $cycle
     * @param array $expenses {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @return array {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    public function generatePaidExpenses(string $cycle, array $expenses): array
    {
        $currentMonth = Carbon::createFromTimeString($cycle);
        $results = [];

        foreach ($expenses as $job) {
            $type = IncomeType::find($job['income_type_id']);
            $startPay = Carbon::createFromTimeString($job['initial_pay_date']);
            $method = 'get_' . $this->convertSlugToSnakeCase($type->slug);

            if (method_exists($this, $method)) {
                $results = array_merge($results, $this->{$method}($job, $startPay, $currentMonth));
            } else {
                $results = array_merge($results, $job);
            }

            $this->updateIncomeTemplate($results[count($results) - 1]);
        }


        return $results;
    }

    /**
     * @param array $result {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function updateIncomeTemplate(array $result): void
    {
        $income = IncomeTemplate::where('income_type_id', $result['income_type_id'])
            ->where('name', $result['name'])
            ->first();

        if ($income) {
            $income->initial_pay_date = $result['initial_pay_date'];
            $income->save();
        }
    }

    /**
     * Get weekly pay periods for a billing cycle; called dynamically from generatePaidExpenses()
     *
     * @param array $job {
     *      @value integer | string ['id']
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @param Carbon $startPay
     * @param Carbon $currentMonth
     * @return array {
     *      @value integer | string ['id']
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function get_weekly($job, $startPay, $currentMonth)
    {
        $results = [];

        $day = $startPay->format('D');
        $month = $currentMonth->format('M');
        $initialDate = $startPay;

        for ($i = 1; $i < 8; $i++) {
            $date = Carbon::createFromTimeString($currentMonth->format('Y-m') . '-0' . $i .' 00:00:00');

            if ($date->format('D') === $day) {
                $initialDate = $date;
            }
        }

        $currentMonthWeek = $currentMonth->weekOfYear;

        if ($currentMonth->format('M') === 'Dec') {
            $nextMonthWeek = 52;
        } else {
            $nextMonthWeek = $currentMonth->addMonth()->weekOfYear;
        }

        for ($i = 0; $i <= ($nextMonthWeek-$currentMonthWeek); $i++) {
            if ($initialDate->format('M') === $month) {
                $results[] = [
                    'id' => $job['id'],
                    'name' => $job['name'],
                    'amount' => $job['amount'],
                    'income_type_id' => $job['income_type_id'],
                    'initial_pay_date' => $initialDate->toDateTimeString(),
                ];
            }

            $initialDate->addDays(7);
        }

        return $results;
    }

    /**
     * Get bi-weekly pay periods for a billing cycle; called dynamically from generatePaidExpenses()
     *
     * @param array $job {
     *      @value string ['id']; a temp id is expected
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @param Carbon $startPay
     * @param Carbon $currentMonth
     * @return array {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function get_bi_weekly($job, $startPay, $currentMonth)
    {
        $results = [];
        $nextMonth = (clone $currentMonth)->addMonth();
        $queued_date = clone $startPay;
        $run = true;

        while ($run) {
            $queued_date->addDays(14);

            if ($nextMonth->format('m') === $queued_date->format('m')) {
                $results[] = [
                    'id' => $job['id'],
                    'name' => $job['name'],
                    'amount' => $job['amount'],
                    'income_type_id' => $job['income_type_id'],
                    'initial_pay_date' => $queued_date->toDateTimeString(),
                ];
                continue;
            }

            $run = false;
        }

        return $results;
    }

    /**
     * Get semi-monthly pay periods for a billing cycle; called dynamically from generatePaidExpenses()
     *
     * @param array $job {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @param Carbon $startPay
     * @param Carbon $currentMonth
     * @return array {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function get_semi_monthly($job, $startPay, $currentMonth)
    {
        $results = [];
        $dates = [
            $currentMonth->format('Y-m') . '-15 00:00:00',
            $currentMonth->endOfMonth()->toDateTimeString(),
        ];

        foreach ($dates as $date) {
            $job['initial_pay_date'] = $date;
            $results[] = $job;
        }

        return $results;
    }

    /**
     * Get monthly pay periods for a billing cycle; called dynamically from generatePaidExpenses()
     *
     * @param array $job {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @param Carbon $startPay
     * @param Carbon $currentMonth
     * @return array {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function get_monthly($job, $startPay, $currentMonth)
    {
        $newPayPeriod = $startPay->addMonth();
        $date = $newPayPeriod;

        if ($newPayPeriod->format('Y-m') !== $currentMonth->format('Y-m')) {
            $day = $startPay->format('d');
            $currentCycle = $currentMonth->format('Y-m');
            $date = Carbon::createFromTimeString($currentCycle . '-' . $day . ' 00:00:00');
        }

        return [
            [
                'id' => $job['id'],
                'name' => $job['name'],
                'amount' => $job['amount'],
                'income_type_id' => $job['income_type_id'],
                'initial_pay_date' => $date->toDateTimeString(),
            ]
        ];
    }
}
