<?php
   include "head.php";
   include "nav.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-finance shadow-sm p-3">
                <h6 class="text-muted">Saldo em Carteira</h6>
                <h3>R$ <?php echo number_format(0.0, 2, ',', '.'); ?></h3>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-left border-success shadow-sm p-3">
                <h6 class="text-muted">Rendimento Mensal</h6>
                <h3 class="text-success">+ 0%</h3>
            </div>
        </div>
    </div>
<?php
   include "baseboard.php";
?>