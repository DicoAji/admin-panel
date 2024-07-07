<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $barang = $_POST['barang'];
    $conn = connect_db();

    // Simpan data customer ke tabel ms_counter
    $stmt = $conn->prepare("INSERT INTO ms_counter (nama, alamat, phone) VALUES (?, ?, ?)");
    foreach ($_POST['customer'] as $customer) {
        $stmt->bind_param("sss", $customer['nama_customer'], $customer['alamat_customer'], $customer['phone_customer']);
        $stmt->execute();
        $id_customer = $stmt->insert_id;
    }

    // Simpan transaksi header
    $stmt = $conn->prepare("INSERT INTO transaksi_h (id_customer, nomor_transaksi, tanggal_transaksi, total_transaksi) VALUES (?, ?, ?, ?)");
    $nomor_transaksi = 'TRX' . time();

    // Menghitung total transaksi dari detail transaksi
    $total_transaksi = 0;
    foreach ($barang as $item) {
        // Hitung subtotal setiap barang
        $subtotal = $item['qty'] * $item['subtotal'];
        // Jumlah subtotal ke total transaksi
        $total_transaksi += $subtotal;
    }

    $stmt->bind_param("issd", $id_customer, $nomor_transaksi, $tanggal_transaksi, $total_transaksi);
    $stmt->execute();
    $id_transaksi_h = $stmt->insert_id;

    // Simpan transaksi detail
    $stmt = $conn->prepare("INSERT INTO transaksi_d (id_transaksi_h, kd_barang, nama_barang, qty, subtotal) VALUES (?, ?, ?, ?, ?)");
    foreach ($barang as $item) {
        $stmt->bind_param("issid", $id_transaksi_h, $item['kd_barang'], $item['nama_barang'], $item['qty'], $item['subtotal']);
        $stmt->execute();
    }
    // Memecah tanggal
    // Simpan tanggal transaksi ke tabel counter
    $bulan = date('m', strtotime($tanggal_transaksi));
    $tahun = date('Y', strtotime($tanggal_transaksi));
    $stmt = $conn->prepare("INSERT INTO `counter` (bulan, tahun, `counter`) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $bulan, $tahun, $id_transaksi_h);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirect to index.php after saving
    header('Location: index.php');
    exit();
}

$conn = connect_db();
$result = $conn->query("SELECT * FROM ms_counter");
$customers = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<?php include 'views/header.php'; ?>
<h2 class="text-2xl uppercase font-bold">FORM Transaksi</h2>
<a href="index.php" class="btn-purple mt-4 inline-block"><i class="fa-solid fa-arrow-left-long"></i></a>

<?php if (isset($_GET['action']) && $_GET['action'] == 'create') : ?>
    <form action="transaksi.php" method="post" class="mt-4 space-y-5">
        <div class="mb-4">
            <label for="tanggal_transaksi" class="block text-sm text-gray-700 font-bold">Tanggal Transaksi:</label>
            <input type="date" name="tanggal_transaksi" required class="mt-1 block sm:w-[25%] w-56">
        </div>
        <div class="border-2 border-gray"></div>

        <div class="mb-4 flex justify-between">
            <p class="font-bold">Pilih Customer:</p>
            <button type="button" onclick="addCustomer()" class="btn-purple mt-2">Tambah Customer</button>
        </div>

        <div id="customer-container" class="mt-4">
            <div class="customer-item mb-1 flex space-x-4">
                <input type="text" name="customer[0][nama_customer]" required class="mt-1 block w-full" placeholder="Nama">
                <input type="text" name="customer[0][alamat_customer]" required class="mt-1 block w-full" placeholder="Alamat">
                <input type="text" name="customer[0][phone_customer]" required class="mt-1 block w-full" placeholder="Phone">
            </div>
        </div>

        <div class="border-2 border-gray"></div>
        <div>
            <div class="flex justify-between mb-4">
                <label for="barang" class="font-bold">Pilih Barang</label>
                <button type="button" onclick="addBarang()" class="btn-purple">Tambah Barang</button>
            </div>
            <div class="flex space-x-3 mt-1">
                <input type="text" name="barang[0][nama_barang]" class="nama" placeholder="Nama">
                <input type="text" name="barang[0][kd_barang]" class="kd_barang" placeholder="Kode Barang">
                <input type="number" name="barang[0][qty]" class="qty" placeholder="Qty">
                <input type="number" name="barang[0][subtotal]" class="sub_total" placeholder="Sub Total">
            </div>
        </div>

        <div id="barang-container" class="mt-1"></div>

        <button type="submit" style="margin-top: 20px !important;" class="btn-purple block"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
    </form>
<?php endif; ?>

<script>
    function addBarang() {
        const container = document.getElementById('barang-container');
        const index = container.children.length;
        const item = document.createElement('div');
        item.className = 'barang-item mt-1 flex space-x-4';
        item.innerHTML = `
        <input type="text" name="barang[${index}][nama_barang]" class="mt-1 block w-full" placeholder="Nama">
        <input type="text" name="barang[${index}][kd_barang]" class="mt-1 block w-full" placeholder="Kode Barang">
        <input type="number" name="barang[${index}][qty]" class="mt-1 block w-full" placeholder="Qty">
        <input type="number" name="barang[${index}][subtotal]" class="mt-1 block w-full" placeholder="Sub Total">
    `;
        container.appendChild(item);
    }

    function addCustomer() {
        const container = document.getElementById('customer-container');
        const index = container.children.length;
        const item = document.createElement('div');
        item.className = 'customer-item mb-4 flex space-x-4';
        item.innerHTML = `
        <input type="text" name="customer[${index}][nama_customer]" required class="mt-1 block w-full" placeholder="Nama">
        <input type="text" name="customer[${index}][alamat_customer]" required class="mt-1 block w-full" placeholder="Alamat">
        <input type="text" name="customer[${index}][phone_customer]" required class="mt-1 block w-full" placeholder="Phone">
    `;
        container.appendChild(item);
    }
</script>

<?php include 'views/footer.php'; ?>