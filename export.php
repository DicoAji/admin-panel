<?php
if (isset($_POST['export_excel'])) {
    require 'db.php';
    $conn = connect_db();
    $sql = "SELECT th.id, th.nomor_transaksi, th.tanggal_transaksi, th.total_transaksi, mc.nama AS customer_name 
            FROM transaksi_h th
            LEFT JOIN ms_counter mc ON th.id_customer = mc.id";
    $result = $conn->query($sql);
    // Generate nama file Excel
    $filename = "transaksi_data_" . date('Ymd') . ".xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    // Header 
    $headers = array(
        'No',
        'Nomor Transaksi',
        'Tanggal Transaksi',
        'Customer',
        'Total Transaksi'
    );
    echo implode("\t", $headers) . "\n";

    // Ambil data dari hasil query
    while ($row = $result->fetch_assoc()) {
        $line = array(
            $row['id'],
            $row['nomor_transaksi'],
            $row['tanggal_transaksi'],
            $row['customer_name'],
            $row['total_transaksi']
        );
        echo implode("\t", $line) . "\n";
    }

    $conn->close();
    exit();
}
