<style media="screen">
  #tarj-cont{
    position: relative;
    height: 50ex;
  }
  #tarj1{
    position: relative;
    z-index: 1;
    background: #FFF;
    padding: 1ex;
    height: 100%;
  }
  #tarj2{
    position: absolute;
    width: 100%;
    z-index: 2;
    left: 100%;
    top: 0;
    background: #FFF;
    padding: 1ex;
    box-shadow: 0 0 3px #999;
    min-height: 40ex;
  }
  #tarj2.slide{
    left: 0;
    animation-name: showDiv;
    animation-duration: 0.05s;
  }
  #tarj2.unslide{
    left: 100%;
    animation-name: showDiv2;
    animation-duration: 0.05s;
    animation-direction: reverse;
  }
  @keyframes showDiv {
      from {left: 100%;}
      to {left: 0%;}
  }
  @keyframes showDiv2 {
      from {left: 100%;}
      to {left: 0%;}
  }

</style>

<div id="tarj-cont" class="row" ng-controller="reportes">

  <div id="tarj1">
    <?php $this->load->view('reportes/lista/listOT', array('ots'=>$ots) ); ?>
  </div>

  <div id="tarj2" >
    <button type="button" class="btn mini-btn" ng-click="ocultarCalendario('#tarj2')"> << </button>
    <div ng-include="CalendarLink">

    </div>
  </div>

</div>
