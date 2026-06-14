<?php

return function ($page, $routeYear = null, $routeMonth = null) {

    // 1. Determine active date (either from route parameters or current real-time date)
    if ($routeYear && $routeMonth) {
        $timestamp = strtotime("$routeYear-$routeMonth-01");
    } else {
        $timestamp = time();
    }

    $year  = date('Y', $timestamp);
    $month = date('m', $timestamp);

    // 2. Calculate next/previous month dates
    $prevMonthTime = strtotime("-1 month", strtotime("$year-$month-01"));
    $nextMonthTime = strtotime("+1 month", strtotime("$year-$month-01"));

    // 3. Generate clean, pure /YY-MM paths without anchors
    $prevLink = $page->url() . '/' . date('y-m', $prevMonthTime);
    $nextLink = $page->url() . '/' . date('y-m', $nextMonthTime);

    // 4. Retrieve sketches matching this year and month
    $sketchesPage = page('sketches');
    $sketches     = $sketchesPage
        ? $sketchesPage->children()->unlisted()->filter(function ($child) use ($year, $month) {
            return $child->date()->toDate('Y-m') === "$year-$month";
        })
        : new Kirby\Cms\Pages();

    // 5. Build the structural day-by-day calendar grid
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
