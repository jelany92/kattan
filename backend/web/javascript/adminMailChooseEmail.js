$('.chk_all').change(function(){
   $(this).parents().eq(3).find('.checkbox').prop('checked', this.checked);
});
$('.checkbox').change(function(){
   var container = $(this).parents().eq(3);
   var chk_all = container.find('.chk_all');
   if(container.find('.checkbox:not(:checked)').length == 0)
   {
      chk_all.prop('checked', true);
   }
   else
   {
      chk_all.prop('checked', false);
   }
});