<?php 	
	require 'app/Config.inc.php';
	
	$filtroano = $_POST['filtroano'];
	$readPublicacaoporano = new Read();
	$readPublicacaoporano->FullRead("SELECT COUNT(*) FROM publicacao WHERE aprovado = 'S' AND ano = {$filtroano}");
?>
<!DOCTYPE html>
<html class="ls-theme-green ls-html-nobg">
  <head>
    <title>Repositório CONNEPI</title>
	<?php require_once('assets.php');?>
    <script type="text/javascript" src="assets/js/chartist.min.js"></script>
    <link href="assets/css/chartist.min.css" rel="stylesheet" type="text/css">
    
  </head>
  <body>
	<?php require_once('header.php');?>
	<?php require_once('aside.php');?>

    <main class="ls-main ">
	 <div class="ls-box">
      <div class="ls-box ls-board-box">
	   <header class="ls-info-header">
	   <h2 class="ls-title-3">Selecione o ano:</h2>
	   </header>
	   <div class="row text-center">
	     <div class="container-fluid">
		  <div id="sending-stats" class="row ls-clearfix">
		   <span class="ls-board-data">
		   <form action="dashboardano.php" method="post" enctype="multipart/form-data">
	      <select class="form-control inp" name="filtroano">
		   <option value="ano" selected>Ano</option>
		   <option value="2006">2006</option>
		   <option value="2007">2007</option>
		   <option value="2008">2008</option>
		  </select>
		  <input type="submit" class="btn btn-default inp bt-lg" name="submit" value="Filtrar">
		  </span>
		 </div>
		</div>
	  </div>
	</div>
		
		
      <div class="container-fluid">
        <h1 class="ls-title-intro ls-ico-dashboard">Dashboard <?php echo $filtroano ?></h1>

<!-- ----------------- -->
<div class="ls-box ls-board-box">
  <header class="ls-info-header">
    <h2 class="ls-title-3">Quantidade total</h2>
    <!-- <a href="/locawebstyle/documentacao/exemplos/painel2/stats" class="ls-btn ls-btn-sm">Ver relatórios</a> -->
  </header>

  <div id="sending-stats" class="row ls-clearfix">
    <div class="col-sm-12 col-md-12 col-lg-12">
      <div class="ls-box">
        <div class="ls-box-head">
          <h2 class="ls-title-3">Publicações</h2>
        </div>
        <div class="ls-box-body">
          <span class="ls-board-data">
            <strong class="ls-color-theme"><?php echo $readPublicacaoporano->getResult()[0]['COUNT(*)']; ?></strong>
          </span>
        </div>
      </div>
    </div>

  </div>
  <hr class="ls-no-border">
  <div id="panel-charts-2" class="ls-clear-both"></div>
</div>

<!-- ------------- -->

<div class="ls-box ls-board-box">
  <header class="ls-info-header">
    <p class="ls-float-right ls-float-none-xs ls-small-info"><strong></strong></p>
    <h2 class="ls-title-3">Gráficos</h2>
  </header>
  
<div class="ls-box ls-board-box">
  <div id="sending-stats" class="row ls-clearfix">
    <div class="col-sm-12 col-md-6">
      <div class="ls-box">
        <div class="ls-box-head">
          <h6 class="ls-title-4">Quantidade de publicações por área</h6>
        </div>
        <div class="ls-box-body">
          <div class="ct-chart ct-perfect-fourth ct-golden-section" id="chart2"></div>
        </div>
      </div>
    </div>
 </div>
</div>

<div class="ls-box ls-board-box">
  <div id="sending-stats" class="row ls-clearfix">
    <div class="col-sm-12 col-md-12">
      <div class="ls-box">
        <div class="ls-box-head">
          <h6 class="ls-title-4">Quantidade de publicações por IF</h6>
        </div>
        <div class="ls-box-body">
          <div class="ct-chart ct-perfect-fourth ct-golden-section" id="chart7"></div>
        </div>
      </div>
    </div>
 </div>
</div>
</div>
<!-- ---------------- -->

<?php 
// Quantidade de publicações por área

$qpa = new Read();
$qpa->FullRead("SELECT count(*), area FROM publicacao WHERE aprovado='S' AND ano = {$filtroano} GROUP BY area");

$qtd_qpa = array();
$area_qpa = array();

foreach ($qpa->getResult() as $q){
	$qtd_qpa[] = $q['count(*)'];
	$area_qpa[] = $q['area'];
}
//tranforma em string
$qtd_qpa = implode(', ', $qtd_qpa);

//transforma em string
$area_qpa = '"'.implode('", "', $area_qpa).'"';


// Quantidade de publicação por IF

$qpi = new Read();
$qpi->FullRead("SELECT count(*), ies FROM publicacao WHERE aprovado='S' AND ano = {$filtroano} GROUP BY ies");

$qtd_qpi = array();
$ies_qpi = array();

foreach ($qpi->getResult() as $q){
	$qtd_qpi[] = $q['count(*)'];
	$ies_qpi[] = $q['ies'];
}
//tranforma em string
$qtd_qpi = implode(', ', $qtd_qpi);
//transforma em string
$ies_qpi = '"'.implode('", "', $ies_qpi).'"';
?>

<script>
  // Gráfico de barra com a quantidade de artigos por área.
  new Chartist.Bar('#chart2', {
    labels: [<?php echo $area_qpa; ?>],
    series: [[<?php echo $qtd_qpa; ?>]]
  });
  
  // Gráfico de barra com a quantidade de artigos por IF
  new Chartist.Bar('#chart7', {
    labels: [<?php echo $ies_qpi; ?>],
    series: [[<?php echo $qtd_qpi; ?>]]
  });
</script>


    </div>
      <?php require_once('footer.php');?>
    </main>

    
    <?php require_once('assets-footer.php');?>

  </body>