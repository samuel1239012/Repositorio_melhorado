<?php
  include("../../assets/includes/validacao.php");
  include("../validar_sessao.php");
 
  $id = "";
  $texto="";
  $titulo = "";
  $sub_titulo= "";
  $data_postagem= "";
  $palavra_chave = "";
  $img = false;
 
  if(isset($_GET['id'])&& is_numeric($_GET['id'])){
    $id = $_GET['id'];
 
    // preparação da consulta no back-end
 
     // endpoint da API
     $end_point = "http://localhost/api_jornal/noticia/?id=$id";
 
     // Inicializa o CURL
     $curl = curl_init();
 
     // configurações do CURL
     curl_setopt_array($curl,[
         CURLOPT_URL => $end_point,
         CURLOPT_CUSTOMREQUEST => "GET",
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_SSL_VERIFYPEER => false,
     ]);
 
     // envio do comando CURL e armazenamento da resposta
     $response = curl_exec($curl);
 
     // conersão do JSON para ARRAY
     $dado = json_decode($response, TRUE); // TRUE para um array associativo
 
     $arrNoticia = $dado["noticia"];
 
     if ($dado['status'] =='success'){
      $texto = $arrNoticia['texto'];
      $titulo = $arrNoticia['titulo'];
      $sub_titulo = $arrNoticia['sub_titulo'];
      $palavra_chave = $arrNoticia['palavra_chave'];
     }
     if(!empty($arrNoticia["imagem"])){
      $img = $comp."../".$arrNoticia["imagem"];
    } 
  }
 
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Noticia</title>
 
  <?php include("../../assets/includes/head.php"); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
 
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../../vendor/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
 
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $path."/".$home_interno; ?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
 
    <!-- Right navbar links -->
    <?php include("../../assets/includes/right_menu.php"); ?>
  </nav>
  <!-- /.navbar -->
 
  <!-- Main Sidebar Container -->
  <?php include("../../assets/includes/menu.php"); ?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Main content -->
   
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Noticia</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Inserir Noticia</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Noticia</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="salvar.php" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">  
                      <label for="noticia">ID</label>
                      <input type="text" id="id" name="id" value="<?php  echo $id ?>" class="form-control" placeholder="ID" readonly>
                    </div>
                    <div class="form-group">  
                      <label for="noticia">Texto</label>
                      <input type="text" id="texto" name="texto" value="<?php  echo $texto?>" class="form-control" placeholder="Texto" >
                    </div>
                    <div class="form-group">  
                      <label for="noticia">Titulo</label>
                      <input type="text" id="titulo" name="titulo" value="<?php echo $titulo ?>" class="form-control" placeholder="Titulo">
                    </div>
                    <div class="form-group">  
                      <label for="noticia">Sub-Titulo</label>
                      <input type="text" id="sub_titulo" name="sub_titulo" value="<?php echo $sub_titulo ?>" class="form-control" placeholder="Sub-titulo">
                    </div>
                    <div class="form-group">  
                      <label for="noticia">Palavra Chave</label>
                      <input type="text" id="palavra_chave" name="palavra_chave" value="<?php echo $palavra_chave ?>" class="form-control" placeholder="Palavra-chave">
                    </div>
                    <div class="form-group">  

                    <?php if ($img) { ?>
                        <div style="width: 200px; height: 200px;">
                          <img src="<?php echo $img; ?>" alt="" class="img-fluid">
                        </div>
                      <?php } ?>

                      <label for="imagem">Imagens</label>
                      <input type="file" id="imagem" name="imagem" value="" class="form-control" placeholder="Imagem do Produto">
                    </div>

                    <div class="form-group">  
                      <label for="noticia">Data Postagem</label>
                      <input type="text" id="data_postagem" name="data_postagem" value="<?php  echo $data_postagem ?>" class="form-control" placeholder="y/m/d" readonly>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="index.php" class="btn btn-warning">Cancelar</a>
                  </div>
                </form>
               
 
 
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
   
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
 
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include("../../assets/includes/scripts.php"); ?>
 
</body>
</html>