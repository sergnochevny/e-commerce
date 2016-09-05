	<?php $object = new Controller_Index;?>
<div id="matches_product">
    <div class="s_block_main" id="s_block_main">
        <div class="s_block_pic_main">  
         <?php echo $object->matches_product_list();?>          
        </div>
        <div class="s_block_pic_drop">
            <div id="makeMeDroppable4" class="ui-droppable"></div>
            <div id="makeMeDroppable3" class="ui-droppable"></div>
            <div id="makeMeDroppable2" class="ui-droppable"></div>
            <b id="tests1"><?php echo $object->matches_product_test_view1();?></b>
        </div>
        <script type="text/javascript">
        function handleDropEvent( event, ui ) {
          var draggable = ui.draggable;
        }
        </script>
    </div>
</div> 