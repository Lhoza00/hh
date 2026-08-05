<?php
$profile_data["balance"] ="";
$profile_data["totalEarnings"] ="";
$profile_data["withdrawnAmount"] ="";
?>
<?php
if (basename($_SERVER['PHP_SELF']) === 'inbox.php') {
    header("Location: home");
    exit;
}
?>
<html lang="en" id="dashboard">
<?php require_once __DIR__ . '/../layout/head.php';?>
<body>
    <?php require __DIR__ . '/../layout/header.php';?>
    <main>
        <?php require __DIR__ . '/../components/sidebar.php'; ?>
        <section class="WalletSection">
            <div class="container">
                <h1>Wallet</h1>
                <div class="wallet-content">
                    <div class="wallet-card">
                        <h2>Balance</h2>
                        <!--<p><?php echo htmlspecialchars($profile_data['balance'])?> USD</p>-->
                    </div>
                    <hr/>
                    <!--<div class="wallet-card">
                        <h2>Total Earnings</h2>
                        <p><?php echo htmlspecialchars($profile_data['totalEarnings'])?> USD</p>
                    </div>
                    <div class="wallet-card">
                        <h2>Withdrawn Amount</h2>
                        <p><?php echo htmlspecialchars($profile_data['withdrawnAmount'])?> USD</p>
                    </div>-->
                </div>
            </div>
        </section>
    </main>
    <?php require __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>