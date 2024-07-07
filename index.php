<?php
require 'db.php';
$conn = connect_db();

$sql = "SELECT th.id, th.nomor_transaksi, th.tanggal_transaksi, th.total_transaksi, mc.nama AS customer_name 
        FROM transaksi_h th
        LEFT JOIN ms_counter mc ON th.id_customer = mc.id";
$result = $conn->query($sql);

$transaksi = [];
$total_transaksi_sum = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transaksi[] = $row;
        $total_transaksi_sum += $row['total_transaksi'];
    }
}

$conn->close();
?>

<?php include 'views/header.php'; ?>
<h2 class="text-2xl mb-4 uppercase font-bold">Transaksi Penjualan</h2>
<p>Filter Tanggal Transaksi</p>
<div class="grid sm:grid-cols-2 grid-cols-1 mt-4">
    <div class="flex space-x-5">
        <input type="date" class="py-1 px-4 rounded" placeholder="Datepicker">
        <p class="h_fit my-auto">sd</p>
        <input type="date" class="rounded w-full py-1 border px-4" placeholder="Datepicker">
        <button class="btn-purple"><i class="fa-solid fa-filter"></i></button>
    </div>
    <div class="flex justify-end">
        <a href="transaksi.php?action=create" class="btn-purple"><i class="fa-solid fa-circle-plus mr-2"></i> Tambah Transaksi</a>
    </div>
</div>
<div class="flex justify-between mt-5">
    <input type="text" name="search" class="w-70 py-1 px-3 border rounded" placeholder="Search">
    <form action="export.php" method="post" class="">
        <button type="submit" name="export_excel" class="btn-purple"><i class="fa-regular fa-file-lines"></i> Export Excel</button>
    </form>
</div>
<table class="table-auto w-full mt-5 border-collapse border border-gray-200">
    <thead>
        <tr class="bg-gray-100">
            <th class="border px-4 py-2">No</th>
            <th class="border px-4 py-2">Nomor Transaksi</th>
            <th class="border px-4 py-2">Customer</th>
            <th class="border px-4 py-2">Total Transaksi</th>
            <th class="border px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($transaksi) > 0) : ?>
            <?php foreach ($transaksi as $index => $row) : ?>
                <tr class="bg-white border-b text-center">
                    <td class="border px-4 py-2"><?= $index + 1 ?></td>
                    <td class="border px-4 py-2"><?= $row['nomor_transaksi'] ?></td>
                    <td class="border px-4 py-2"><?= $row['customer_name'] ?></td>
                    <td class="border px-4 py-2"><?= number_format($row['total_transaksi'], 0) ?></td>
                    <td class="border px-4 py-2"><a href="" class="text-blue-700">Edit</a> | <a href="" class="text-red-700">Hapus</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr class="bg-white border-b">
                <td colspan="5" class="border px-4 py-2 text-center">Tidak ada data transaksi.</td>
            </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="border px-4 py-2 text-right font-bold">Total</td>
            <td class="border px-4 py-2 text-center font-bold"><?= number_format($total_transaksi_sum, 0) ?></td>
            <td class="border"></td>
        </tr>
    </tfoot>
</table>
<?php include 'views/footer.php'; ?>