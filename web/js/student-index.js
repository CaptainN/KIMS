$(document).ready(function(){
   // remove underline from icons in editable fields
   window.setTimeout(function(){
      $(".glyphicon").parent(".editable-click").removeClass("editable-click");
   }, 200);

   /* activate editable fields on mouseover
    $this->registerJs('$("a[rel$=\"editable\"]").hover(function(){
    $this = $(this);
    timer = setTimeout(function(){
    $this.click();
    }, 500);
    }, function(){
    clearTimeout(timer);
    });'); */
});