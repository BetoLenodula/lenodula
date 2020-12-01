<div id="some_activity">
  <div id="head_main_activity"><i class="material-icons">dashboard</i></div>
  <a href="https://lenodula.com" class="underl href_action">
    <p align="center"><i class="material-icons">language</i> https://lenodula.com</p>
  </a><br>
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v6.0&appId=544238222898183&autoLogAppEvents=1"></script>
  <div class="fb-cont">
    <div class="fb-page" data-href="https://www.facebook.com/Lenodula/" data-tabs="" data-width="" data-height="240" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
      <blockquote cite="https://www.facebook.com/Lenodula/" class="fb-xfbml-parse-ignore">
        <a href="https://www.facebook.com/Lenodula/"></a>
      </blockquote>
    </div><br><br>
  </div><br>
  <p align="center">Desarrollado y distribuido por Lenodula. Lenodula <?= date('Y'); ?></p><br>
</div>
<div id="centralSection">
  <article id="main">
    <div id="indexHeader" class="divHeader">
      <i class="material-icons">category</i>
      <h1>Línea del tiempo</h1>
    </div><br>
    <style>
      @import url('/Views/template/css/timeline.css');
    </style>
    <h2><?= strtoupper($nom); ?></h2><br>
    <div class="timeline-container timeline-theme-1">
      <div class="timeline js-timeline">
        <?php 
            for($i = 0; $i <= (count($fes) - 1); $i++):
        ?>
        <div data-time="<?= substr($fes[$i], 0, 4); ?>">
          <p>
            <?php 
                if($img[$i] != 'na'):
             ?>
            <img src="<?= $img[$i]; ?>">
            <?php 
                endif;
             ?>
            <?= $dts[$i]; ?><br><br>
            <i><?= $controlador->funcion('alfa_months', $fes[$i]); ?></i>
          </p>
        </div>
        <?php
            endfor;
         ?>
      </div>
    </div><br><br><br><br>
    <script src="/Views/template/js/timeline.js"></script>
    <script>
      $('.js-timeline').Timeline();
    </script>
</article>
</div>