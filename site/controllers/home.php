<?php

/**
 * @var \Kirby\Cms\Page $page
 */

return function ($page) {
    // 1. Get current month/year from query param or default to current date
    $currentParam = get('month');
    if ($currentParam && preg_match('/^\d{4}-\d{2}$/', $currentParam)) {
        $timestamp = strtotime($currentParam . '-01');
    } else {
        $timestamp = time();
    }

    $year  = date('Y', $timestamp);
    $month = date('m', $timestamp);

    // 2. Calculate pagination variables
    $prevMonthTime = strtotime("-1 month", strtotime("$year-$month-01"));
    $nextMonthTime = strtotime("+1 month", strtotime("$year-$month-01"));

    $prevLink = $page->url() . '?month=' . date('Y-m', $prevMonthTime) . '#sketches';
    $nextLink = $page->url() . '?month=' . date('Y-m', $nextMonthTime) . '#sketches';

    // 3. Find your sketches parent page and filter its children
    // Note: We changed ->listed() to ->unlisted() to match your blueprint status settings
    $sketchesPage = page('sketches');
    $sketches     = $sketchesPage
        ? $sketchesPage->children()->unlisted()->filter(function ($child) use ($year, $month) {
            return $child->date()->toDate('Y-m') === "$year-$month";
        })
        : new Kirby\Cms\Pages();

    // 4. Generate calendar grid
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
    $grid = [];

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $dateString = sprintf('%04d-%02d-%02d', $year, $month, $day);

        $daySketch = $sketches->filter(function ($item) use ($dateString) {
            return $item->date()->toDate('Y-m-d') === $dateString;
        })->first();

        $grid[] = [
            'day'    => $day,
            'date'   => $dateString,
            'sketch' => $daySketch
        ];
    }

    return [
        'grid'         => $grid,
        'currentMonth' => date('F Y', $timestamp),
        'prevLink'     => $prevLink,
        'nextLink'     => $nextLink,
    ];
};
