<!-- leave_report_view.php -->
<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="leave_report.xls"');
header('Pragma: no-cache');
header('Expires: 0');

$html = '<table border="1"><tr><th>Name</th><th>Type</th><th>Status</th><th>From Date</th><th>To Date</th><th>Total Leave Days</th><th>Description</th></tr>';
foreach ($leaves as $leave) {
    $html .= '<tr>';
    if (is_admin()) {
        $html .= '<td>' . $leave['username'] . '</td>';
    }
    $html .= '<td>' . $leave['leave_type'] . '</td>';
    $html .= '<td>' . $leave['status'] . '</td>';
    $html .= '<td>' . $leave['from_date'] . '</td>';
    $html .= '<td>' . $leave['to_date'] . '</td>';

    // Calculate total leave days for this leave entry
    $from_date = new DateTime($leave['from_date']);
    $to_date = new DateTime($leave['to_date']);
    $leave_days = $from_date->diff($to_date)->days + 1; // Including both start and end dates

    $html .= '<td>' . $leave_days . '</td>';
    $html .= '<td>' . $leave['description'] . '</td>';
    $html .= '</tr>';
}

// Add single row for overall leave days per year
foreach ($overall_leave_days as $year => $leave_days) {
    $html .= '<tr><td colspan="5"><strong>Overall Leave Days (' . $year . ')</strong></td><td><strong>' . implode('</strong></td><td><strong>', $leave_days) . '</strong></td></tr>';
}

$html .= '</table>';

echo $html;
?>
