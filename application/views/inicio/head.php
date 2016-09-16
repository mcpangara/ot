  <head>
    <meta charset="utf-8">
    <!-- -->
    <link rel="stylesheet" href="<?= base_url('assets/fontastic/styles.css') ?>" />

    <!-- Range Slider -->
    <link rel="stylesheet" href="<?= base_url('assets/js/vendor/rangeSlider/css/normalize.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/js/vendor/rangeSlider/css/ion.rangeSlider.skinNice.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/js/vendor/rangeSlider/css/ion.rangeSlider.css') ?>" />

    <!-- Materialize -->
    <link rel="stylesheet" href="<?= base_url('assets/materialize/css/materialize.min.css') ?>" />
    <!--  -->
    <link rel="stylesheet" href="<?= base_url('assets/css/principal.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/informe_creator.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/menu_opciones.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/tablas.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/calendario.css') ?>" />
    <link rel="shortcut icon" href="<?= base_url( 'favico.ico' ) ?>" />

    <!-- uploadfile CSS -->
    <link href="<?= base_url('assets/js/uploader/uploadfile.css') ?>" rel="stylesheet">

    <!-- librerias JS -->
    <script type="text/javascript" src="<?= base_url('assets/js/vendor/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/vendor/angular.min.js') ?>"></script>

    <!-- JQuery UI -->
    <script type="text/javascript" src="<?= base_url('assets/js/vendor/jquery-ui/jquery-ui.min.js') ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/vendor/jquery-ui/jquery-ui.css') ?>" />

    <!-- rangeSlider JS -->
    <script type="text/javascript" src="<?= base_url('assets/js/vendor/rangeSlider/js/ion.rangeSlider.min.js') ?>"></script>

    <!-- Materialize -->
    <script type="text/javascript" src="<?= base_url('assets/materialize/js/materialize.min.js') ?>"></script>

    <!-- uploadfile JS -->
    <script src="<?= base_url('assets/js/vendor/jquery.form.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/uploader/jquery.uploadfile.js') ?>" type="text/javascript"></script>

    <!-- datatables -->
    <script src="<?= base_url('assets/js/datatables/Spanish.json') ?>" charset="utf-8"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/datatables/dataTables.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/js/datatables/dataTables.min.css') ?>" media="screen" charset="utf-8">

    <!-- tinyMCE -->
    <script src="<?= base_url('assets/js/vendor/tinymce/tinymce.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vendor/tinymce-angular.js') ?>" type="text/javascript"></script>


    <!-- Mainer JS -->
    <script type="text/javascript">
    var task = {url:'<?= site_url('welcome/loadOptions') ?>'}
    var baseUrl = '<?= site_url() ?>';
    </script>
    <script src="<?= base_url('assets/js/main/OT.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/reportes.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/calendario.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/persona.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/equipo.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/tabs.js') ?>" type="text/javascript"></script>

    <meta charset="utf-8">
    <title>Informes WebApp</title>

    <style media="screen">
      .mce-item-table, .mce-item-table td, .mce-item-table th, .mce-item-table caption{
          border: 0 solid #111;
         cellspacing:0;
      }
    </style>
  </head>
