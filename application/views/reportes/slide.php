<section class="sRange">
  <div class="sRange-metrica">
    <?php for ($i=1; $i < 25 ; $i++) {
      ?>
      <div class=""><?= $i ?></div>
      <?php
    } ?>
  </div>
  <div id="myRange" class="sRange-bar">
    <div class="sRange-b1"></div>
    <div class="sRange-b2"></div>
    <button type="button" class="piner1 btn mini-btn2 red" data-icon="&#xe018;"></button>
    <button type="button" class="piner2 btn mini-btn2 red" data-icon="&#xe018;"></button>
  </div>
</section>

<style media="screen">
section.sRange{
    width: 100%;
    position: relative;
    box-sizing: border-box;
}
section.sRange .sRange-metrica{
  overflow: hidden;
  position: relative;
  box-sizing: border-box;
}
section.sRange .sRange-metrica div{
  float: left;
  text-align: right;
  box-sizing: border-box;
  font-size: 1ex;
}
section.sRange div.sRange-bar{
  position: relative;
  border-radius: 3px;
  border: 1px solid #555;
  height: 1ex;
  overflow: hidden;
}
section.sRange .sRange-bar .sRange-b1, section.sRange .sRange-bar .sRange-b2{
  background: #FFF;
  height: 0.7ex;
  position: absolute;
  z-index: 3;
  box-sizing: border-box;
  line-height: normal;
}
section.sRange .sRange-bar .sRange-b2{
  background: green;
  z-index: 2;
}
section.sRange .sRange-bar button, section.sRange .sRange-bar button{
  font-size: 1ex;
  position: absolute;
  top: 0;
  z-index: 5;
}
</style>

<script type="text/javascript">
var initSRangeScale = function(ini, end,  tag, frags){
  $(tag).children('.sRange-b1').css({'width': ( (100/frags)*ini )+'%'});
  $(tag).children('.sRange-b2').css({'width': ( (100/frags)*end )+'%'});
  $(tag).children('button.piner1').css({'left': ( (100/frags)*ini )+'%'});
  $(tag).children('button.piner2').css({'left': ( (100/frags)*end )+'%'});

  $('section.sRange .sRange-metrica div').css({ 'width': (100/frags)+'%' })
}

$(document).ready(function(){
  initSRangeScale(6, 18, '#myRange', 24);
});
</script>
